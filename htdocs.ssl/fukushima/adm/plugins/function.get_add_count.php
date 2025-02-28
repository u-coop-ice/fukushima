<?php
function smarty_function_get_add_count($params, &$smarty) {

	$pdo = $smarty->getTemplateVars('pdo');
	$pdo_repl = $smarty->getTemplateVars('pdo_repl');

// SQLを作成する

	$sql = <<< HERE
SELECT COUNT(app_add.`id`) AS ct,IFNULL(app_add.category_id,0) as category_id FROM app_add
 LEFT JOIN app ON app.id = app_add.app_id

HERE;

	$where = array();

	if ($params['add']) {
		array_push($where, "app_add.`add` = '" . $params['add'] . "'");
	}
	if ($params['app']) {
		array_push($where, "app.`app` = '" . $params['app'] . "'");
	}

	if ($params['category_id']) {
		array_push($where, "app_add.`category_id` = '" . $params['category_id'] . "'");
	} else if ($params['no_category']) {
		array_push($where, "app_add.`category_id` IS NULL");
	} else {
		$ext = 1;
	}

	array_push($where, "IFNULL(app_add.auto_send,0) = 0 ");
//	array_push($where, "IFNULL(app_add.root_id,0)=0 ");
	array_push($where, "IFNULL(app_add.noreply,0) < 9");

	if (count($where)) {
		$sql .= " WHERE " . implode(' AND ', $where);
	}

	if ($ext) {
		$sql .= " GROUP BY IFNULL(app_add.category_id,0)";
	}

	$data = array();
	$result = array();
	try {
		$res = $pdo_repl->query($sql);
		$data = $res->fetchAll();
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}

	if (count($data)) {
		foreach ($data as $dt) {
			$result[$dt['category_id']] = $dt['ct'];
		}

		$result['all'] = array_sum($result);

	}
	$smarty->assign("add_counts", $result);

}
?>
