<?php
function smarty_function_get_component_app_count($params, &$smarty) {
	// 条件に応じてSQLを組み立てる
	$where = array();
	$data = array();

	array_push($where, 'component = ?');
	array_push($data, COMPONENT);

	array_push($where, 'IFNULL(cancelled,0) = ?');
	array_push($data, 0);

	array_push($where, 'IFNULL(archived,0) = ?');
	array_push($data, 0);

	if (isset($params['category_id'])) {
		array_push($where, 'category_id = ?');
		array_push($data, intval($params['category_id']));
	}

	$pdo = $smarty->getTemplateVars('pdo');

	$sql = <<< HERE
SELECT COUNT(app.id) AS ct FROM app

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
		$smarty->assign('db_error', 1);
		return;
	}
	$dd = $res->fetch();

	return $dd['ct'];

}
?>
