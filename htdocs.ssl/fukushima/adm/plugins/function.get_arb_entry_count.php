<?php

function smarty_function_get_arb_entry_count($params, &$smarty) {

	$data = array();
	$where = array();
	$pfx = "arbeit_";

	$view_regist_id = $smarty->getTemplateVars('view_regist_id');
	$auth_arbeit_id = $smarty->getTemplateVars('auth_arbeit_id');

	if (CURRENT == 'cmp') {
		if (!$auth_arbeit_id) {
			$smarty->assign('db_error', 1);
			$repeat = false;
			return;
		}
	}

	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	$sql = <<< HERE
select count(${pfx}entry.id) as ct FROM ${pfx}entry LEFT JOIN ${pfx}regist
on ${pfx}regist.id = ${pfx}entry.regist_id
LEFT JOIN ${pfx}entry_status on ${pfx}entry.id = ${pfx}entry_status.id

HERE;
/*
if ($view_regist_id) {
array_push($data, $view_regist_id);
array_push($where, "${pfx}regist.id = ?");
}
 */

	if ($params['else']) {
		array_push($where, "${pfx}entry_status.status > 1");
	} else if ($params['ready']) {
		array_push($where, "IFNULL(${pfx}entry_status.status,0) = 0");
	} else if ($params['visible']) {
//					array_push($where, "${pfx}entry.term1 < NOW() and ${pfx}entry.term2 > NOW()");
		//					array_push($where, "${pfx}entry_status.status = 1");
		array_push($where, "(
						(${pfx}entry.term1 < NOW() AND ${pfx}entry.term2 > NOW() - interval 1 day AND ${pfx}entry_status.status = 1) OR (${pfx}entry_status.status = -1 AND ${pfx}entry.term1 < NOW()))");
	} else if ($params['draft']) {
		array_push($where, "${pfx}entry_status.status = -9");
	} else if ($params['before']) {
		array_push($where, "${pfx}entry.term1 > NOW()");
		array_push($where, "${pfx}entry_status.status <= 1");
	} else if ($params['expiry']) {
		array_push($where, "${pfx}entry.term2 < NOW() - interval 1 day");
		array_push($where, "${pfx}entry_status.status = 1");
	} else if (is_numeric($params['status_payment'])) {
		array_push($where, "${pfx}entry_status.status_payment = ?");
		array_push($data, intval($params['status_payment']));
	}

	if ($_SESSION['admin_mode']) {
		array_push($where, "IFNULL(${pfx}entry_status.status,0) <> -9");
	}

	if ($_SESSION['arbeit_mode']) {
		if (!$auth_arbeit_id) {return;}
		array_push($where, "${pfx}regist.id = ?");
		array_push($data, $auth_arbeit_id);
	}

	array_push($where, "${pfx}entry_status.trashed IS NULL");

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

	$entry = $res->fetch();
	return $entry['ct'];
}
?>
