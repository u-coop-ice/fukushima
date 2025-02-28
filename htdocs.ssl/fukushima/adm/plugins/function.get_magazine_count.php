<?php

function smarty_function_get_magazine_count($params, &$smarty) {

	$data = array();
	$where = array();

	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	$pdo_repl = $smarty->getTemplateVars('pdo_repl');
	$view_group_id = $smarty->getTemplateVars('view_group_id');

	$sql = <<< HERE
SELECT COUNT(mm.id) AS ct FROM mail_magazine AS mm
LEFT JOIN mail_group AS mg ON mm.group_id = mg.id

HERE;

	if ($params['group_id']) {
		array_push($data, $params['group_id']);
		array_push($where, "mm.group_id in (?)\n");
	} else if ($params['onetime']) {
		array_push($data, 1);
		array_push($where, "mm.onetime = (?)\n");
	}

	if ($params['sent']) {
		array_push($where, "mm.sent = 1");
	} else if ($params['draft']) {
		array_push($where, "mm.draft = 1");
	} else if ($params['reserved']) {
		array_push($where, "mm.onreserve = 1");
	}

	if (count($where)) {
		$sql .= " WHERE " . implode(' AND ', $where) . "\n";
	}

	try {
		$res = $pdo_repl->prepare($sql);
		$res->execute($data);
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}
	// カテゴリーを配列に読み込む
	$nn = $res->fetch();

	$smarty->assign('getmagazinecount', intval($nn['ct']));
}
?>
