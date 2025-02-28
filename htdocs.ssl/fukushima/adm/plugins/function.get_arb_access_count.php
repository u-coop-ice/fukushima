<?php
function smarty_function_get_arb_access_count($params, &$smarty) {

// PDOオブジェクトを得る
	$pdo = $smarty->getTemplateVars('pdo');
	// テーブルの接頭語を得る
	$pfx = "arbeit_";

	// SQLを作成する
	$type = array();
	$data = array();
	$where = array();

	$sql = <<< HERE
SELECT COUNT(ac.id) AS ct FROM ${pfx}entry_access AS ac

HERE;

	if ($params['entry_id']) {
		array_push($type, 'integer');
		array_push($data, $params['entry_id']);
		array_push($where, " entry_id = ? ");
	}
	// SQLにwhere句を連結する
	if (count($where)) {
		$sql .= ' WHERE ' . implode(" \n AND ", $where) . "\n";
	}

	// クエリを実行する
	try {
		$res = $pdo->prepare($sql);
		$res->execute($data);

	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}

	$rt = $res->fetch();

	return $rt['ct'];

}
?>
