<?php

if ($postdata['complete']) {
	$postdata = [];
	HTTP_Session2::set('postdata', $postdata);
	header("Location: $init_url");
	exit();
}

try {
	$ap = new appReserveDB();
	$ap->setAuth($userAuth);
	$ap->set_category_id($category_id);
	$ap->saveAppReserve();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:

		$pp = 'post_';

		foreach ($method as $key => $value) {

			if (!preg_match('/^extra/', $key)) {
				$html .= $smarty->fetch($pp . $key . '.tpl');
			} else {
				$k = intval(substr($key, 5));
				$smarty->assign('k', $k);
				$extraList[$k] = [];
				if ($category['method']['extra'][$k]['select']) {
					$select = trim($category['method']['extra'][$k]['select']);
					$select = preg_replace('/\n|\r\n/', "\n", $select);

					$extraList[$k] = explode("\n", $select);
					if ($k == 0) {
						foreach ($extraList[$k] as $v) {
							$tmp = explode(",", $v);
							$tmps[$tmp[0]] = $tmp[1];
						}
						$extraList[$k] = array_keys($tmps);
					}

				}
				$smarty->assign('extraList', $extraList[$k]);

				$html .= $smarty->fetch($pp . 'extra.tpl');
			}
		}

		$smarty->assign("html", $html); //項目のテンプレート発行

		$steps[1] = 'now';
		$smarty->assign('step', $steps);

		$smarty->display('input.tpl');
		exit();
	case 8:
		$pp = 'conf_';

		foreach ($method as $key => $value) {

			if (!preg_match('/^extra/', $key)) {
				$html .= $smarty->fetch($pp . $key . '.tpl');
			} else {
				$k = intval(substr($key, 5));
				$smarty->assign('k', $k);
				$extraList[$k] = [];
				if ($category['method']['extra'][$k]['select']) {
					$select = trim($category['method']['extra'][$k]['select']);
					$select = preg_replace('/\n|\r\n/', "\n", $select);

					$extraList[$k] = explode("\n", $select);
					if ($k == 0) {
						foreach ($extraList[$k] as $v) {
							$tmp = explode(",", $v);
							$tmps[$tmp[0]] = $tmp[1];
						}
						$extraList[$k] = array_keys($tmps);
					}

				}
				$smarty->assign('extraList', $extraList[$k]);

				$html .= $smarty->fetch($pp . 'extra.tpl');
			}
		}

		$smarty->assign("html", $html); //項目のテンプレート発行

		$steps[1] = 'cleared';
		$steps[2] = 'now';
		$smarty->assign('step', $steps);

		$smarty->display('confirm.tpl');
		exit();
	case 7:
		$smarty->assign('stepsFile', []);
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お申込みが重複しています');
		$smarty->display('duplicate.tpl');
		exit();
	case 6:
		$smarty->assign('stepsFile', []);
		$smarty->assign('errmsg', $e->getMessage());

		$pp = 'post_';

		foreach ($method as $key => $value) {

			if (!preg_match('/^extra/', $key)) {
				$html .= $smarty->fetch($pp . $key . '.tpl');
			} else {
				$k = intval(substr($key, 5));
				$smarty->assign('k', $k);
				$extraList[$k] = [];
				if ($category['method']['extra'][$k]['select']) {
					$select = trim($category['method']['extra'][$k]['select']);
					$select = preg_replace('/\n|\r\n/', "\n", $select);

					$extraList[$k] = explode("\n", $select);
					if ($k == 0) {
						foreach ($extraList as $v) {
							$tmp = explode(",", $v);
							$tmps[$tmp[0]] = $tmp[1];
						}
						$extraList[$k] = array_keys($tmps);
					}

				}
				$smarty->assign('extraList', $extraList[$k]);

				$html .= $smarty->fetch($pp . 'extra.tpl');
			}
		}

		$smarty->assign("html", $html); //項目のテンプレート発行

		$smarty->display('input.tpl');
		exit();

		exit();

	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お申込みの登録に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}

}

exit();

if (!$is_login) {
	$methods['email']['use'] = 2;
}

if (isset($_POST["register"]) || isset($_POST["confirm"])) {

	if (count($_POST['extra'])) {
		foreach ($_POST['extra'] as $k => $v) {
			if ($v) {
				$entrydata['extra'][$k] = trim(strip_tags($v));
			}
		}
	}

	$methods['address']['use'] = 0;
	$methods['ship_address']['use'] = 0;

	if (preg_match('/実家/', $entrydata['extra'][1])) {
		$methods['address']['use'] = 2;
		unset($method['ship_address']);

	} else if (preg_match('/転居/', $entrydata['extra'][1])) {
		$methods['ship_address']['use'] = 2;
		unset($method['address']);
	}

	$smarty->assign('methods', $methods);
}
// フォームで登録関係のボタンがクリックされた場合
if (isset($_POST["confirm"]) ||
	isset($_POST["reinput"]) ||
	isset($_POST["register"])) {

	if (isset($_POST["confirm"])) {

		$mt = new setDB();
		$mt->set_methods($methods);
		$fields = $mt->get_fields_input();

		$fields['app']['comedate'] = "text";
		$fields['app']['cometime'] = "text";

		$fields_all = array_merge($fields['all'], $fields['app']);
//		$fields_must = array_merge($fields['must'][2], $fields['must'][3]);

		foreach ($fields_all as $field => $v) {
			if ($agent->isNonMobile()) {
				$value = strip_tags($_POST[$field]);
				$value = mb_convert_kana($value, "KV");
			} else {
				$value = mb_convert_encoding($_POST[$field], "UTF-8", "SJIS");
				$value = mb_convert_kana($value, "KV");
				$value = strip_tags($value);
			}

			$entrydata[$field] = htmlspecialchars($value, 3, 'UTF-8');

/*
if ($fields_must[$field]) {
if ($value == '') {
$smarty->assign($field . '_err', 1);
$smarty->assign('err', 1);
}
}
 */
		}
// 選択項目

		$extra_err = array();
		foreach ($method as $key => $sort) {
			if (preg_match('/^extra/', $key)) {
				$k = intval(substr($key, 5));
//				if ($methods['extra'][$k]['tag'] != 'checkbox') {
				if (!is_array($_POST['extra'][$k])) {
					if ($agent->isNonMobile()) {
						$value = strip_tags($_POST['extra'][$k]);
					} else {
						$value = mb_convert_encoding($_POST['extra'][$k], "UTF-8", "SJIS");
						$value = mb_convert_kana($value, "KV");
						$value = strip_tags($value);
					}
					$entrydata['extra'][$k] = $value;
					if ($methods['extra'][$k]['use'] == 2) {
						if ($value == '') {
							$extra_err[$k] = 1;
							$smarty->assign('err', 1);
						}
					}
				} else {
					$value = $_POST['extra'][$k];
					if ($agent->isNonMobile()) {
						$value = array_map('my_convert_post', $value);
					} else {
						$value = mb_convert_variables("UTF-8", "SJIS", $value);
						$value = array_map('my_convert_post', $value);
					}
					$entrydata['extra'][$k] = $value;
					if ($methods['extra'][$k]['use'] == 2) {
						if (!count($value)) {
							$extra_err[$k] = 1;
							$smarty->assign('err', 1);
						}
					}
				}
			}
		}
		if (count($extra_err)) {
			$smarty->assign('extra_err', $extra_err);
		}

//新住所のオプション

		if ($methods['new_add']['use'] == 2) {
			if ($entrydata['new_add']) {
				$fields['must'][3] = array_diff_key($fields['must'][3], array(
					'new_zipcodef' => 'integer', 'new_zipcodes' => 'integer', 'new_pref' => 'text',
					'new_addressf' => 'text',
					'student_phone1' => 'text',
					'student_phone2' => 'text',
					'student_phone3' => 'text')
				);
			}
		}

		$fields_must = array_merge($fields['must'][2], $fields['must'][3], $fields['must'][4]);

		foreach ($fields_must as $field => $v) {
			if ($entrydata[$field] == '') {
				$smarty->assign($field . '_err', 1);
				$smarty->assign('err', 1);
			}
		}

// メルアド入力確認

		if ($entrydata["email"] != "") {
			if (!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $entrydata["email"])) {
				$smarty->assign('no_email_err', 1);
				$smarty->assign('err', 1);
			}
		}
		if ($entrydata["emailcfrm"] != "") {
			if (!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $entrydata["emailcfrm"])) {
				$smarty->assign('no_emailcfrm_err', 1);
				$smarty->assign('err', 1);
			}
		}

		if ($entrydata["email"] != $entrydata["emailcfrm"]) {
			$smarty->assign('nonemail_err', 1);
			$smarty->assign('err', 1);
		}

//半角数字check
		$fields_num = array('zipcodef', 'zipcodes', 'code_branch', 'account');
		foreach ($fields_num as $field) {
			if ($entrydata[$field] && !preg_match("/^[0-9]+$/", $entrydata[${field}])) {
				$smarty->assign('no_num_' . $field . '_err', 1);
				$smarty->assign('err', 1);
			}
		}

//電話番号生成
		$phones = array('mobilephone', 'phonenumber', 'parent_mobile', 'parent_com_phone', 'student_phone');
		foreach ($phones as $phone) {
			if (!in_array($phone, $method)) {continue;}
			$temp = array();
			for ($i = 1; $i <= 3; $i++) {
				if ($entrydata[$phone . $i]) {
					array_push($temp, $entrydata[$phone . $i]);
				}
			}
			if (count($temp)) {
				$ptemp = implode("-", $temp);
				$entrydata[$phone] = $ptemp;
			}
		}

//birthday生成

		if ($method['age']) {
			$entrydata['birthday'] = $entrydata['birth_year'] . sprintf("%02d", $entrydata['birth_month']) . sprintf("%02d", $entrydata['birth_day']);
		}

//membership生成

		if ($method['membership']) {
			$entrydata['membership'] = $entrydata['membership1'] . $entrydata['membership2'] . $entrydata['membership3'];
		}

		$fields_sql = $mt->get_fields_sql();
		$fields_sql_app = $mt->get_fields_sql_app();

		HTTP_Session2::set('fields_all', $fields_all);
		HTTP_Session2::set('fields_sql', $fields_sql);
		HTTP_Session2::set('fields_sql_app', $fields_sql_app);
		HTTP_Session2::set('entrydata', $entrydata);

//重複申込チェック
		if ($is_login && $data['onduplicate'] == 0 && $entrydata['comedate']) {

			$dpdata = array();
			$dpdata[":comedate"] = $entrydata['comedate'];
			$dpdata[":regist_id"] = $auth_user_id;

			$dps = new livingDB();
			$dps->set_postdata($dpdata);

			$duc = $dps->get_duplicate_sameday();

			if ($smarty->getTemplateVars("db_error")) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('page_title', 'データベース接続エラー');
				$smarty->assign('errmsg', 'データベースからのデータの読み込みに失敗しました。');
				$smarty->display('error.tpl');
				exit();
			}

			if ($duc > 0) {
//				$scdata = array();
				//				HTTP_Session2::set('scdata', $scdata); //セッションキャッシュ解除
				$smarty->assign('page_title', '重複申込エラー');
				$smarty->assign('errmsg', '同日のお申込みが重複しています。');
				$smarty->display('duplicate.tpl');
				exit();
			}
		}

//在庫チェックです。
		if ($entrydata['comedate'] && $entrydata['cometime']) {
			$chk = new livingDB();
			$chk->set_comedate($entrydata['comedate']);
			$chk->set_cometime($entrydata['cometime']);
			$rest_error = $chk->getRest();

			if ($rest_error < 0) {
				$smarty->assign('page_title', '満席エラー');
				$smarty->assign('errmsg', '申し訳ございません。予定席数を超過しましたので、選択された日時でのお申込みはできません。他の時間・日程で選択してください。');
				$smarty->display('input.tpl');
				exit();
			}
		}

	} // confirmのみ

	// 表示するページの選択

	if ($entrydata['complete']) {

		$entrydata = array();
		HTTP_Session2::set('entrydata', $entrydata);
		$tmpl = 'input.tpl';
		$smarty->assign('step', array(1 => 'now'));

	} else if ($smarty->getTemplateVars('err') == 1) {

// 登録内容にエラーがあったら、入力のページを再度表示
		$pp = 'post_';
		$smarty->assign('step', array(1 => 'now'));
		$tmpl = 'input.tpl';

	} else {
// 登録内容の確認の場合
		if ($_POST["confirm"]) {
			$pp = 'conf_';
			$smarty->assign('step', array(1 => 'cleared', 2 => 'now'));
			$tmpl = 'confirm.tpl';
		}
// 再入力の場合
		else if ($_POST['reinput']) {
			$pp = 'post_';
			$smarty->assign('step', array(1 => 'cleared'));
			$smarty->assign('reinput', 1);
			$tmpl = 'input.tpl';
		}
// 登録の場合
		else {

// データベースにユーザー情報を登録する

//投稿者の環境変数を取得
			$entrydata['remote_addr'] = $_SERVER['REMOTE_ADDR'];
			$entrydata['remote_host'] = $_SERVER['REMOTE_HOST'];
			$entrydata['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

//投稿日時を取得
			$date = date('Y-m-d H:i:s');

			$fields_sql = HTTP_Session2::get('fields_sql');
			$fields_sql_app = HTTP_Session2::get('fields_sql_app');

			unset($fields_sql['emailcfrm']);

			$fields_sql_app['remote_addr'] = 'text';
			$fields_sql_app['remote_host'] = 'text';
			$fields_sql_app['user_agent'] = 'text';

			$fields_sql_app['category_id'] = 'integer';
			$entrydata['category_id'] = $category_id;

			$fields_sql_app['extra'] = 'text';
			$entrydata['extra'] = json_encode($entrydata['extra']);

			$fields_sql_app['methods'] = 'text';
			$entrydata['methods'] = json_encode($methods);

			try {

//トランザクション開始
				$pdo->query("SET innodb_lock_wait_timeout=30;");
				$pdo->beginTransaction();

//在庫チェックです。
				if ($entrydata['comedate'] && $entrydata['cometime']) {
					$chk = new livingDB();
					$chk->set_comedate($entrydata['comedate']);
					$chk->set_cometime($entrydata['cometime']);
					$rest_error = $chk->getRest();

					if ($rest_error < 0) {
						$pdo->rollBack();
						$smarty->assign('page_title', '満席エラー');
						$smarty->assign('errmsg', '申し訳ございません。予定席数を超過しましたので、選択された日時でのお申込みはできません。他の時間・日程で選択してください。');
						$smarty->display('input.tpl');
						exit();
					}
				}

//registへの更新／追加

				$set = new setDB();
				$set->set_tbl('regist');

				if ($auth_user_id) {
//					$fields_all['id'] = 'integer';
					$entrydata['id'] = $auth_user_id;
					$set->set_fields($fields_sql);
					$set->set_postdata($entrydata);

					$set->updateTable();

					$entrydata['regist_id'] = $auth_user_id;
					$entrydata["email"] = $userAuth->getusername();
				} else {

//					$fields_sql['id'] = 'integer';

					$fields_sql['status'] = 'integer';
					$entrydata['status'] = -9;

					$fields_sql['univ_id'] = 'integer';
					$entrydata['univ_id'] = $smarty->getConfigVars('univ_id');

					$fields_sql['username'] = 'text';
					$fields_sql['password'] = 'text';

					$fields_sql['regist_date'] = 'text';
					$entrydata['regist_date'] = date('Y-m-d H:i:s');

					$salt = $smarty->getConfigVars('salt');

					$entrydata['password'] = md5($salt . $entrydata['email'] . time());
					$entrydata['username'] = crypt($salt . $entrydata['email'] . time());

					$set->set_fields($fields_sql);
					$set->set_postdata($entrydata);
					$set->insertTable();
					$entrydata['regist_id'] = $set->get_last_insertId();
				}

//appへの追加

// カテゴリ毎の登録数を取得

				$sql = <<< HERE
SELECT MAX(app_count) AS app_count FROM app
WHERE app.component = ? AND app.part = ? AND IFNULL(app.archived,0) = 0

FOR UPDATE

HERE;

				try {
					$res = $pdo->prepare($sql);
					$res->execute(array(COMPONENT, PART));

				} catch (PDOException $e) {
					$pdo->rollBack();
					$smarty->assign('page_title', 'エラー');
					$smarty->assign('errmsg', 'データベース処理にエラーが発生しました。');
					$smarty->display('input.tpl');
					exit();
				}

				$data = array();
				$data = $res->fetch();
				$app_count = $data['app_count'] + 1;

				$fields_sql_app['app_count'] = 'integer';
				$entrydata['app_count'] = $app_count;

				$ap = new setDB();
				$ap->set_tbl('app');

				$fields_sql_app['regist_id'] = "integer";

				$fields_sql_app['regist_date'] = 'text';
				$entrydata['regist_date'] = date('Y-m-d H:i:s');

				$fields_sql_app['component'] = 'text';
				$entrydata['component'] = COMPONENT;

				$fields_sql_app['part'] = 'text';
				$entrydata['part'] = PART;

				$fields_sql_app['comedate'] = 'text';
				$fields_sql_app['cometime'] = 'text';

				$fields_sql_app['code'] = 'text';
				$entrydata['code'] = md5($salt . $entrydata['username'] . time() * $entrydata['regist_id']);

				$ap->set_fields($fields_sql_app);
				$ap->set_postdata($entrydata);
				$ap->insertTable();
				$entrydata['app_id'] = $ap->get_last_insertId();

//投稿されたIDを取得する。
				$smarty->assign('view_app_id', $entrydata['app_id']);

//在庫の更新
				$ck = new livingDB();
				$ck->set_comedate($entrydata['comedate']);
				$ck->updateSelectTime();

				$pdo->commit();

			} catch (Exception $e) {
				$pdo->rollBack();
				$smarty->assign('page_title', 'エラー');
				$smarty->assign('errmsg', 'データベースへの処理に失敗しました。');
				$smarty->display('error.tpl');
				exit();

			}

//生協管理用メールアドレスを取得する。

			$init_ordermail = $_SESSION['config']['email'];
			$init_errormail = $_SESSION['config']['error_email'];

			$infocode = $component[COMPONENT]['infocode'];
			$init_pagetitle = $component[COMPONENT]['title'];

			$store_ordermail = $component[COMPONENT]['store_ordermail'];
// 送信前の定数取得

			$sql = <<< HERE
SELECT ordermail,pressmail,cat_code,denomination
FROM init_category as c
WHERE c.component = ? AND c.part = ?

HERE;
			try {
				$res = $pdo->prepare($sql);
				$res->execute(array(COMPONENT, PART));
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				return;
			}

			$data = array();
			$data = $res->fetch();
			$cat_denomination = $data['denomination']; //カテゴリ名

			$ordermail = $data['ordermail']; //追加メールアド
			$pressmail = $data['pressmail']; //自動返信メール記載アド

			$smarty->assign('pressmail', $pressmail);

// 登録確認メールを送信する
			require_once 'send_mail.php';
			$regist_code = $infocode;
			if (defined('PART')) {
				$regist_code .= '-' . strtoupper(PART);
			}
			$regist_code .= ":" . date("Ymd") . "-" . sprintf("%04d", $entrydata['app_count']); //受付番号の番号作成
			$smarty->assign('regist_code', $regist_code);

			$name = $entrydata["namef"] . ' ' . $entrydata["nameg"];

//メール本文作成

			reset($entrydata);
			while (list($field, $value) = each($entrydata)) {
				if ($field == "extra") {$entrydata[$field] = json_decode($value, true);}
/*				if (!is_array($entrydata[$field])) {
$entrydata[$field] = htmlspecialchars($value, 3, 'UTF-8');
}
 */
			}

			$smarty->assign('post', $entrydata);

			$html = '';
			$pp = 'conf_';
			foreach ($method as $key => $value) {
				$extraList = null;
				if (!preg_match('/^extra/', $key)) {
					if ($key == "bank") {
						$html .= $smarty->fetch('conf_bank_blank.tpl');
					} else {
						$html .= $smarty->fetch($pp . $key . '.tpl');
					}
				} else {
					$k = intval(substr($key, 5));
					$smarty->assign('k', $k);
					if ($methods['extra'][$k]['select']) {
						$select = trim($methods['extra'][$k]['select']);
						$select = preg_replace('/\n|\r\n/', "\n", $select);
						$extraList = explode("\n", $select);

						$tmps = array();
						if ($k == 0) {
							foreach ($extraList as $v) {
								$tmp = explode(",", $v);
								$tmps[$tmp[0]] = $tmp[1];
							}
							$extraList = array_keys($tmps);
							$post_extra = $entrydata['extra'];
							$extramail = array();
							if (is_array($post_extra[0])) {
								foreach ($post_extra[0] as $pe) {
									array_push($extramail, $tmps[$pe]);
								}
							} else {
								array_push($extramail, $tmps[$post_extra[0]]);
							}

						}

						$smarty->assign('extraList', $extraList);
					}
					$html .= $smarty->fetch($pp . 'extra.tpl');
				}
			}
//			$text = $html;
			$html = preg_replace("/<th class=\"mh\".*<\/th>/", "", $html);
			$html = preg_replace("/<\/th>/", "]", $html);
			$html = preg_replace("/<th.*>/", "[", $html);
			$smarty->assign('html', $html);
			$text = strip_tags($html);
			$text = preg_replace('/(\n)+|(\r\n)+/', "\n", $text);
			$smarty->assign('text', $text);

			$smarty->assign('app_code', $entrydata['code']);

			$cust_body = $smarty->fetch('customer_mail.tpl');
			$order_body = $smarty->fetch('order_mail.tpl');

//			$cust_subject = $cat_denomination . 'を承りました【' . $init_coopname . '】';
			$cust_subject = $cat_denomination . 'を承りました';
//登録者へのメール送信
			$from_mail = 'DO_NOT_REPLY@u-coop.or.jp';

			$comments['component'] = COMPONENT;
			$comments['cid'] = $entrydata['category_id'];
			$comment = json_encode($comments);

			send_mail($init_coopname, $from_mail, $entrydata["email"], $cust_subject, $cust_body, null, null, null, $comment);

//管理者メール設定
			if ($ordermail) {
				$init_ordermail = $ordermail;
			} else if ($store_ordermail) {
				$init_ordermail = $store_ordermail;
			}

			$order_subject = $regist_code . '【' . $cat_denomination . '】';

//メール連動系の処理 Ccへ追加
			$cc = null;
			if (count($extramail)) {
				$cc = implode(",", $extramail);
			}

//管理者へのメール送信
			send_mail($name, $entrydata["email"], $init_ordermail, $order_subject, $order_body, $cc);

//app_addへの登録

			$adddata['app_id'] = $entrydata['app_id'];
			$adddata['regist_id'] = $auth_user_id;
			$adddata['code'] = md5($infocode . time() . APP_DIR . $email);
			$smarty->assign('adic', $adddata['code']);
			$smarty->assign('view_ic', $data['code']);

			$adddata['subject'] = $cust_subject;
			$adddata['memo'] = $cust_body;

			$adddata['send'] = 1;
			$adddata['noreply'] = 1;
			$adddata['auto_send'] = 1;
			$adddata['add'] = 'entry';

			$add = new setDB();

			$add->set_adddata($adddata);
			$add->insertAdd();

//ログのセット

			$log = new setDB();
			$logdata['kind'] = 'gas';
			$logdata['username'] = $userAuth->getUsername();
			$logdata['app_id'] = $entrydata['app_id'];
			$log->set_logdata($logdata);
			$log->insertLog();

// セッション初期化
			//			$entrydata = array();
			//			HTTP_Session2::set('entrydata', $entrydata);

// 登録完了画面表示する
			$self .= '?mode=complete';
			header("Location: $self");
			exit();

		}
	}
}
// 登録フォームのページへ移動してきた場合
else {

	$tmpl = 'input.tpl';
}

reset($entrydata);
/*
while (list($field, $value) = each($entrydata)) {
//	if ($field == "extra") {$entrydata[$field] = json_decode($value, true);}
if (!is_array($entrydata[$field])) {
//		$entrydata[$field] = htmlspecialchars($value, 3, 'UTF-8');
}
}
 */

$smarty->assign('post', $entrydata);

$html = '';

if (!$pp) {$pp = 'post_';}

foreach ($method as $key => $value) {

	if (!preg_match('/^extra/', $key)) {
		$html .= $smarty->fetch($pp . $key . '.tpl');
	} else {
		$k = intval(substr($key, 5));
		$smarty->assign('k', $k);
		if ($methods['extra'][$k]['select']) {
			$select = trim($methods['extra'][$k]['select']);
			$select = preg_replace('/\n|\r\n/', "\n", $select);
			$extraList = explode("\n", $select);

			if ($k == 0) {
				foreach ($extraList as $v) {
					$tmp = explode(",", $v);
					$tmps[$tmp[0]] = $tmp[1];
				}
				$extraList = array_keys($tmps);
			}

			$smarty->assign('extraList', $extraList);
		}

		$html .= $smarty->fetch($pp . 'extra.tpl');
	}
}

$smarty->assign("html", $html); //項目のテンプレート発行

$smarty->display($tmpl);

?>
