<?php
function smarty_function_get_auth_username($params, &$smarty) {
	// 条件に応じてSQLを組み立てる
	$where = array();
	$data = array();
	$view_category_id = $smarty->getTemplateVars('view_category_id');

	if ($view_category_id) {
		array_push($where, 'category_id = ?');
		array_push($data, $view_category_id);
	}

	$pdo = $smarty->getTemplateVars('pdo');
	$pfx = $smarty->getTemplateVars('pfx');
	$pfx2 = $smarty->getTemplateVars('pfx2');

	$sql = <<< HERE
SELECT ${pfx2}authorization.* FROM ${pfx2}authorization

HERE;

	if (count($where)) {
		$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
	}

	try {
		// クエリを実行する
		$res = $pdo->prepare($sql);
		$res->execute($data);
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		if (count($entries) == 0) {
			$smarty->assign('db_error', 1);
			return;
		}
	}
	$auth_username = null;
	// 記事を配列に読み込む
	while ($username = $res->fetch()) {
		$auth_username .= $username['username'] . ',' . $username['password_raw'] . "\n";
	}

	$smarty->assign('auth_username', $auth_username);

}
?>
