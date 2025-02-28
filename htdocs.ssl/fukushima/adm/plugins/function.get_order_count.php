<?php
function smarty_function_get_order_count($params, &$smarty) {

	// データベース関連の情報を得る
	$pdo_repl = $smarty->getTemplateVars('pdo_repl');
	$authority = $smarty->getTemplateVars('authority');

	$pfx = 'sp_';

	if ($params['paid']) {

		$sql = <<< HERE
SELECT COUNT(om.id) AS ct
,IFNULL(om.status,0) AS status
,SIGN(IFNULL(om.payment_confirmed,0) - IFNULL(om.total_price,0)-IFNULL(om.postage,0)+IFNULL(om.reduction,0))+1 AS calc_paid
,SIGN(IFNULL(om.payment_confirmed,0) - IFNULL(om.price_cancelled,0))+1 AS calc_paid_ccl
,om.payment
,category.id AS category_id

 FROM app AS om
JOIN {$pfx}category AS category ON category.id = om.category_id

HERE;

	} else {

		$sql = <<< HERE
SELECT COUNT(om.id) AS ct
,IFNULL(om.status,0) AS status
,category.id AS category_id
 FROM app AS om
JOIN {$pfx}category AS category ON category.id = om.category_id

HERE;

	}

	$data = [];
	$where = [];

	// 管理者モード
	if ($_SESSION['admin_mode']) {

		if ($authority["master"]["master"] == 0) {
			if (is_array($authority["shopping"]["category_id"])) {
				$ors = array();
				foreach ($authority["shopping"]["category_id"] as $ac) {
					array_push($data, $ac);
					array_push($ors, "category.id = ?\n");
				}
				if (count($ors)) {
					$or = implode(" OR ", $ors);
					array_push($where, "( " . $or . ") \n");
				}

			} else {
				$smarty->assign('no_category', 1);
				$repeat = false;
				return;
			}
		}

	}

	array_push($where, "om.component = ?");
	array_push($data, "shopping");

	if ($params['paid']) {
		array_push($where, "( IFNULL(om.status,0) <= ? OR IFNULL(om.status,0) = ? )");
		array_push($data, 1, 9);
	}

	if (count($where)) {
		$sql .= " WHERE " . implode(' AND ', $where) . "\n";
	}

	if ($params['paid']) {

		$sql .= <<< HERE
 GROUP BY calc_paid,calc_paid_ccl,category_id,om.status,om.payment

HERE;

	} else {
		$sql .= <<< HERE
 GROUP BY category_id,IFNULL(om.status,0)

HERE;
	}

	try {
		$res = $pdo_repl->prepare($sql);
		$res->execute($data);
	} catch (Exception $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}

	$orders = [];
	// 注文情報を配列に読み込む
	while ($order = $res->fetch()) {

		if ($params['paid']) {

			if ($order['status'] <= 1) {
				$orders[$order['category_id']][$order['calc_paid']][$order['payment']] += $order['ct'];
			} else if ($order['status'] == 9) {
				$orders[$order['category_id']][$order['calc_paid_ccl']][$order['payment']] = $order['ct'];
			}
		} else {
			$orders[$order['category_id']][$order['status']] = $order['ct'];
		}
	}

	$smarty->assign('order_counts', $orders);

}
?>
