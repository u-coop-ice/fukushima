<?php
function smarty_block_users($params, $content, &$smarty, &$repeat) {
	$users = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	$authority = $smarty->getTemplateVars('authority');
	if (!$authority['master']['show']) {return;}
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_user', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if ($smarty->getTemplateVars('new_user')) {
			$user = array('id' => 0,
				'username' => '',
			);
			array_push($users, $user);
		}

		// カテゴリーを読み込む場合
		else {
			// カテゴリーをデータベースから読み込む
			$type = array();
			$data = array();
			$where = array();

			$sql = <<< HERE
select init_user.* from init_user

HERE;

			if ($params['id']) {
				array_push($type, 'integer');
				array_push($data, $params['id']);
				array_push($where, "init_user.id in (?)\n");
			}
			if ($params['not_id']) {
				array_push($type, 'integer');
				array_push($data, $params['not_id']);
				array_push($where, "init_user.id not in (?)\n");
			}

			if (count($where)) {
				$sql .= " where " . implode(' and ', $where) . "\n";
			}
			$sql .= <<< HERE
group by init_user.id
 order by init_user.id

HERE;

			try {
				$res = $pdo->prepare($sql);
				$res->execute($data);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// ユーザーを配列に読み込む
			while ($user = $res->fetch()) {
				array_push($users, $user);
			}

			// ユーザーがない場合
			if (count($users) == 0) {
				$smarty->assign('no_user', 1);
				$repeat = false;
				return;
			} else {
				$smarty->assign('no_user', 0);
			}
		}
		// ユーザーをSmartyの変数に保存
		$smarty->assign('users', $users);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_user', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$users = $smarty->getTemplateVars('users');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_user');
	}

	// 個々のカテゴリーを読み込む
	$user = $users[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する

	if (count($user)) {

		$user['auth'] = json_decode($user['auth'], true);

		$smarty->assign('user', $user);
	}

	$smarty->assign('user_header', ($ctr == 0));
	$smarty->assign('user_footer', ($ctr == count($users) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_user', $ctr);
	$repeat = ($ctr <= count($users));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
