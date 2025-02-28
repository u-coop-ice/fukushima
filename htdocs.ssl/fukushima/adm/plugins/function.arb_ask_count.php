<?php
function smarty_function_arb_ask_count($params, &$smarty) {

// PDOオブジェクトを得る
	$pdo = $smarty->getTemplateVars('pdo');
	// テーブルの接頭語を得る
	global $pfx;

	if (isset($params['status'])) {
		$view_status = intval($params['status']);
	}

	// SQLを作成する
	$type = array();
	$data = array();
	$where = array();

	$sql = <<< HERE
select count(${pfx}ask.id) as ct from ${pfx}ask

HERE;

	if (is_numeric($view_status)) {
		array_push($type, 'integer');
		array_push($data, $view_status);
		array_push($where, " IFNULL(${pfx}ask.status,0) = ? ");
	}
	// SQLにwhere句を連結する
	if (count($where)) {
		$sql .= ' where ' . implode(" \n and ", $where) . "\n";
	}

	// クエリを実行する
	try {
		$res = $pdo->prepare($sql);
		$res->execute($data);

	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		if (count($asks) == 0) {
			$smarty->assign('db_error', 1);
			return;
		}
	}

	$ask = $res->fetch();

	return $ask['ct'];

}
?>
