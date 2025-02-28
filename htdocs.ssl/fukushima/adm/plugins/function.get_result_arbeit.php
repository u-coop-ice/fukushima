<?php
function smarty_function_get_result_arbeit($params, &$smarty) {

	$pdo = $smarty->getTemplateVars('pdo');

	$view_range_term2 = $smarty->getTemplateVars('view_range_term2');
	$view_range_term1 = $smarty->getTemplateVars('view_range_term1');

	$view_range_term2_paid = $smarty->getTemplateVars('view_range_term2_paid');
	$view_range_term1_paid = $smarty->getTemplateVars('view_range_term1_paid');

	$where = array();
	$data = array();

	$sql = <<< HERE
SELECT COUNT(e.id) as ct,
SUM(es.`fee`) as fee,
IFNULL(es.status_payment,0) as status_payment
FROM arbeit_entry as e LEFT JOIN arbeit_entry_status as es ON e.id = es.id

HERE;

	if ($view_range_term1) {
		array_push($data, $view_range_term1);
		array_push($where, "e.term1 >= ?");
	}

	if ($view_range_term2) {
		array_push($data, $view_range_term2);
		array_push($where, "e.term1 - INTERVAL 1 DAY < ?");
	}

	if ($view_range_term1_paid) {
		array_push($data, $view_range_term1_paid);
		array_push($where, "es.date_paid >= ?");
	}

	if ($view_range_term2_paid) {
		array_push($data, $view_range_term2_paid);
		array_push($where, "es.date_paid - INTERVAL 1 DAY < ?");
	}

	if (count($where)) {
		$sql .= " WHERE " . implode(' AND ', $where);
	}

	$sql .= <<< HERE

 GROUP BY IFNULL(es.status_payment,0)
 ORDER BY IFNULL(es.status_payment,0)

HERE;

	try {
		$res = $pdo->prepare($sql);
		$res->execute($data);
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}

	$results = array();
//	$results = $res->fetchAll();
	while ($result = $res->fetch()) {
		$results[$result['status_payment']] = array(
			'ct' => intval($result['ct']),
			'fee' => intval($result['fee']),
		);
	}
	$smarty->assign("results", $results);

	$sql = <<< HERE
SELECT e.id as id,e.numberofperson as np,IFNULL(es.status,0) as status
FROM arbeit_entry as e LEFT JOIN arbeit_entry_status as es ON e.id = es.id

HERE;

	array_push($where, "e.term1 IS NOT NULL");
	array_push($where, "e.term2 IS NOT NULL");
	array_push($where, "IFNULL(es.status_payment,0) <> 9");

	if (count($where)) {
		$sql .= " WHERE " . implode(' AND ', $where);
	}

	$sql .= <<< HERE

 ORDER BY e.id

HERE;

	try {
		$res = $pdo->prepare($sql);
		$res->execute($data);
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}

	$sum = 0;
	$ct = 0;
	$results = $res->fetchAll();

	$num['ct'] = count($results);

	if ($num['ct']) {
		foreach ($results as $result) {
			$ct++;
			$result['np'] = mb_convert_kana($result['np'], 'n', 'UTF-8');
			$result['np'] = preg_replace("/～/", "〜", $result['np']);

			if (preg_match("/^[0-9]+$/", $result['np'])) {
				$sum += intval($result['np']);
			} else if (preg_match("/〜([0-9]+)$/", $result['np'], $matches)) {
				$sum += $matches[1];
			} else if (preg_match("/若干/", $result['np'])) {
				$sum += 1;
			} else {
				$ct--;
			}
		}
	}
	$num['sum'] = $sum;
	$num['cte'] = $ct;
	$num['diff'] = $num['ct'] - $ct;
	$smarty->assign("num", $num);

}
?>
