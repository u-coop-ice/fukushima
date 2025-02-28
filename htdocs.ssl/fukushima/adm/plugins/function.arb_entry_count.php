<?php
function smarty_function_arb_entry_count($params, &$smarty) {
	global $pfx;
// PDOオブジェクトを得る
	$pdo = $smarty->getTemplateVars('pdo');
	// テーブルの接頭語を得る

	if (isset($params['status_payment'])) {
		$view_status_payment = intval($params['status_payment']);
	}

	// SQLを作成する
	$type = array();
	$data = array();
	$where = array();

	$sql = <<< HERE
SELECT count(${pfx}entry.id) as ct FROM ${pfx}entry
LEFT JOIN ${pfx}entry_status ON ${pfx}entry_status.id = ${pfx}entry.id
LEFT JOIN ${pfx}regist ON ${pfx}regist.id = ${pfx}entry.regist_id
HERE;

	if (is_numeric($view_status_payment)) {
		array_push($type, 'integer');
		array_push($data, $view_status_payment);
		array_push($where, " IFNULL(${pfx}entry_status.status_payment,0) = ? ");
	}

	array_push($where, "${pfx}entry_status.trashed IS NULL");
	array_push($where, " IFNULL(${pfx}entry_status.status,0) <> -9 ");

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
	}

	$entry = $res->fetch();

	return $entry['ct'];

}
?>
