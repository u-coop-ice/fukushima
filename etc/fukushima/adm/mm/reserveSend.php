<?php

$present_dir = (dirname(__FILE__));

if (!preg_match('/\/$/', $present_dir)) {
	$present_dir .= '/';
}

$etc_dir = preg_replace('/\/mm/', "", $present_dir);
$rootpath = preg_replace('/\/etc\//', "/htdocs.ssl/", $etc_dir);

set_include_path($rootpath . '/admin' . PATH_SEPARATOR .
	$rootpath . '/lib' . PATH_SEPARATOR .
	get_include_path());

if (!count($config)) {
	$config = parse_ini_file($etc_dir . '/config/config.php', true);
}

// ライブラリの組み込み
// ライブラリの組み込み
require_once $rootpath . 'lib/classLoader.class.php';
$classLoader = new ClassLoader();
$classLoader->registerDir($rootpath . 'lib/Classes');
$classLoader->registerDir($rootpath . 'lib/Classes/trait');

$dbuser = $config['dbuser'];
$dbpass = $config['dbpass'];
$dbhost = $config['dbhost'];
$database = $config['database'];
$dbsocket = $config['dbsocket'];
$dbsocket_repl = $config['dbsocket_repl'];

// データベースに接続
$pdo = adminConfigDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket);
if ($dbsocket_repl) {
	$pdo_repl = adminConfigDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket_repl);
} else if ($dbhost_repl) {
	$pdo_repl = adminConfigDB::initDB($dbuser, $dbpass, $dbhost_repl, $database, $dbsocket);
} else {
	$pdo_repl = $pdo;
}

try {
	$adm = new adminMmDB();
	$adm->set_config($config);
	$adm->sendMagazines();
} catch (Exception $e) {
	echo $e->getMessage();
}
exit();
//メルマガ取得

$mags = array();
$sql = <<< HERE
SELECT mm.*,mg.signature as signature,
mg.main_email as main_email,
mg.unsubscribe as unsubscribe,
mg.forced as forced,
admin_user_id as admin_user_id
FROM mail_magazine as mm
LEFT JOIN mail_group as mg ON mm.group_id = mg.id
	WHERE mm.onreserve = 1 and mm.reserve < now()

HERE;

try {
	$res3 = $pdo->query($sql);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$errmsg = 'メルマガの取得に失敗しました(2)';
	exit();
}

while ($mag = $res3->fetch()) {
	array_push($mags, $mag);
}

require_once 'commonDB.class.php';
require_once 'setDB.class.php';

// 初期設定テーブルの読み込み
$init = new setDB();
$init->set_tbl('init_config');
$init->set_where(array('univ_id' => "integer"));
$init->set_postdata(array('univ_id' => $config['univ_id']));
$init_config = $init->selectTable();

$init_ordermail = $init_config['email'];
$init_errormail = $init_config['error_email'];

try {

	$cnt = count($mags);
	if ($cnt > 0) {

		$upm = new setDB();
		$upm->set_tbl('mail_magazine');

		$fields_upm = array(
			"sent" => "integer",
			"onreserve" => "integer",
//			"sent_count" => "integer",
		);

		$upm->set_fields($fields_upm);

		$upmdata['sent'] = 1;
		$upmdata['onreserve'] = 0;

//メルマガ送信する場合の処理（メール送信に時間がかかるので、最初にmagazineだけupdate）
		for ($j = 0; $j < $cnt; $j++) {

			$sql = <<< HERE
		UPDATE mail_magazine set `sent` = ? , `onreserve` = ?
		WHERE `id` = ?

HERE;
			$data = array(1, 0, $mags[$j]['id']);

			try {
				$res4 = $pdo->prepare($sql);
				$res4->execute($data);
			} catch (PDOException $e) {
				$errmsg = 'メルマガの更新に失敗しました(3)';
				echo ($errmsg);
				exit();
			}

		}

//メルマガ送信

		require_once 'send_mail.php';

//トランザクション開始

		$pdo->beginTransaction();

		$set = new setDB();

		for ($i = 0; $i < $cnt; $i++) {

			$sends = array();
			if (!$mags[$i]['group_id']) {continue;}

			$comments['auid'] = $mags[$i]['admin_user_id'];
			$comments['component'] = "mm";
			$comment = json_encode($comments);

			$snd = new setDB();
			$snd->set_id($mags[$i]['group_id']);
			$sends = $snd->get_magazine_id();

//発信元アドレス
			$coop_email = $init_ordermail;
			if ($mags[$i]['main_email']) {
				$coop_email = $mags[$i]['main_email'];
			}

			$subject = $mags[$i]['subject'];
			$subject = htmlspecialchars_decode($subject);

			$body = $mags[$i]['body'];
			$body = htmlspecialchars_decode($body);

			$signature = $mags[$i]['signature'];
			$signature = htmlspecialchars_decode($signiture);

			if ($mags[$i]['main_email']) {
				$coop_email = $mags[$i]['main_email'];
			}

			$maildata['noreply'] = 9;
			$maildata['subject'] = $subject;
			$maildata['send'] = 1;
			$maildata['add'] = 'magazine';

			$sent_count = count($sends);

			for ($j = 0; $j < $sent_count; $j++) {

				if ($sends[$j]['namef']) {
					$mbody = <<< HERE
{$sends[$j]['namef']} {$sends[$j]['nameg']}さま

HERE;

				} else {
					$mbody = <<< HERE
{$sends[$j]['username']}さま

HERE;
				}

				$mbody .= <<< HERE

{$body}

{$signature}

HERE;

				$to = $sends[$j]['email'];

				$maildata['code'] = md5($sends[$j]['email'] . mt_rand() . $maildata['add'] . time());
				$maildata['regist_id'] = $sends[$j]['id'];
				$maildata['regist_date'] = date('Y-m-d H:i:s');

				$mbody .= <<< HERE
---------------------

【送信専用】当メールは送信専用ですので、当メールには返信できません。

このメールはサインイン後、以下URLでも確認できます。
{$config['init_url']}app/user/?mode=show_mail&adic={$maildata['code']}


HERE;

				if ($mags[$i]['unsubscribe']) {

					$urlencode_email = urlencode($sends[$j]['username']);
					$mbody .= <<< HERE
---------------------

※当メールは、{$init_coopname}にユーザー登録された方に対してお送りしております。
今後、このようなお知らせが不要な方は、大変お手数ですが下記のURLより
配信停止処理（要サインイン）をお願いいたします。
{$config['init_url']}app/user/?mode=unsubscribe_mail&username={$urlencode_email}


HERE;

				}

				$mbody .= <<< HERE
---------------------
{$config['init_coopname']} {$config['init_url']}
HERE;

				$maildata['memo'] = $mbody;

				send_mail($config['init_coopname'], $coop_email, $to, $subject, $mbody, null, null, null, $comment);
				if ($j % 10 == 0) {sleep(2);}

				$set->set_adddata($maildata);
				$set->insertAdd();

			}

//マガジンの更新
			$upmdata['id'] = $mags[$i]['id'];
			$upmdata['sent_count'] = $sent_count;
			$upm->set_postdata($upmdata);
			$upm->updateTable();

//ログの書き込み

			$fields = array('app_id' => 'integer', 'process' => 'text', 'value' => 'text', 'auth_username' => 'text');
			$logdata['process'] = 'send_reserved_magazine';
			$logdata['auth_username'] = "root";
			$logdata['app_id'] = $mags[$i]['id'];
			$logdata['value'] = 1;
			$log = new setDB();
			$log->set_postdata($logdata);
			$log->set_fields($fields);
			$log->set_tbl('admin_log');

			$log->insertTable();

//送信完了メール配信
			$cc = null;
			if ($comments['auid']) {

// 初期設定テーブルの読み込み
				$aau = new setDB();
				$aau->set_tbl('init_user');
				$aau->set_where(array('id' => "integer"));
				$aau->set_postdata(array('id' => intval($comments['auid'])));
				$au = $aau->selectTable();

				if ($au['email']) {
					$cc = $au['email'];
				}
			}

//送信完了用メール本文生成

			$mbody = <<< HERE
{$config['init_coopname']}さま

予約送信が完了しました。
送信数：{$sent_count}

以下メール本文です。

---------------------

{$body}

{$signature}

---------------------

【送信専用】当メールは送信専用ですので、当メールには返信できません。

このメールはサインイン後、以下URLでも確認できます。
{$config['init_url']}app/user/?mode=show_mail&adic=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

---------------------
{$config['init_coopname']} {$config['init_url']}
HERE;

			send_mail($config['init_coopname'], $coop_email, $init_ordermail, "【予約送信完了】" . $subject, $mbody, $cc);

		} //for

	}
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベースへの処理に失敗しました。');
	$smarty->display('error.tpl');
	exit();

}

exit();
?>