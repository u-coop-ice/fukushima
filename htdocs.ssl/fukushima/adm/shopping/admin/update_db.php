<?php
exit();

$paymentList = $smarty->getTemplateVars('paymentList');
$paymentList_flip = array_flip($paymentList);

$shiptimeKeyList = $smarty->getTemplateVars('shiptimeKeyList');
$shiptimeKeyList_flip = array_flip($shiptimeKeyList);

$shiptimeKeyList_flip += array(
	'12時〜14時' => '1214',
	'14時〜16時' => '1416',
	'16時〜18時' => '1416',
	'18時〜20時' => '1820',
	'20時〜21時' => '2021',
	'希望無し' => 'non',
);

//mc_order_main→appのupdate
$sql = <<< HERE
ALTER TABLE app CHANGE id id int(11)
HERE;

try {
	$res = $pdo->query($sql);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

$orders = array();

$sql = <<< HERE
SELECT a.*,
c.flag_send as category_flag_send,
c.nominate as category_nominate,
r.namef as namef,
r.nameg as nameg,
r.kanaf as kanaf,
r.kanag as kanag,
r.zipcodef as zipcodef,
r.zipcodes as zipcodes,
r.pref as pref,
r.addressf as addressf,
r.addresss as addresss,
r.phonenumber as phonenumber,
SUM(sb.num*sb.price) AS total_price

 FROM mc_order_main AS a,
 mc_customer AS r,
 sp_category AS c,
 mc_order_sub AS sb

WHERE r.id=a.customer_id
 AND c.id=a.category_id
 AND a.id=sb.order_id
GROUP BY a.id
HERE;

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

// 注文情報を配列に読み込む
while ($order = $res->fetch()) {
	array_push($orders, $order);
}

$fields = array(
	'id' => 'integer',
	'regist_date' => 'text',
	'regist_id' => 'integer',
	'component' => 'text',
	'category_id' => 'integer',
	'app_count' => 'integer',
	'ship_flag' => 'integer',
	'ship_namef' => 'text',
	'ship_nameg' => 'text',
	'ship_kanaf' => 'text',
	'ship_kanag' => 'text',
	'ship_zipcodef' => 'integer',
	'ship_zipcodes' => 'integer',
	'ship_pref' => 'text',
	'ship_addressf' => 'text',
	'ship_addresss' => 'text',
	'ship_phonenumber' => 'text',
	'ship_age' => 'text',
	'ship_date' => 'text',
	'ship_time' => 'time',
	'payment' => 'integer',
	'store_flag' => 'integer',
	'store' => 'text',
	'total_price' => 'integer',
	'postage' => 'integer',
	'status' => 'integer',
	'treat' => 'text',
	'charged_id' => 'integer',
	'date_export' => 'text',
	'date' => 'text',
	'code' => 'text',
	'methods' => 'text',
	'bill' => 'integer',
	'bill_zipcodef' => 'integer',
	'bill_zipcodes' => 'integer',
	'bill_pref' => 'text',
	'bill_addressf' => 'text',
	'bill_addresss' => 'text',
	'bill_addresst' => 'text',
	'bill_name' => 'text',
	'paid' => 'integer',
	'date_paid' => 'text',
	'payment_confirmed' => 'integer',
	'charged_id' => 'text',
	'webpay' => 'integer',
	'admin_flag' => 'integer',
);

$cst = new shoppingDB();
$cst->set_fields($fields);

foreach ($orders as $k => $order) {

	$order['regist_date'] = $order['date'];
	$order['regist_id'] = $order['customer_id'];
	$order['app_count'] = $order['order_count'];
	$order['admin_flag'] = $order['flag_admin'];

	$order['ship_flag'] = $order['shipflag'];
	if ($order['ship_flag'] == 1) {
		$order['ship_namef'] = $order['shipnamef'];
		$order['ship_nameg'] = $order['shipnameg'];
		$order['ship_kanaf'] = $order['shipkanaf'];
		$order['ship_kanag'] = $order['shipkanag'];
		$order['ship_zipcodef'] = $order['shipzipcodef'];
		$order['ship_zipcodes'] = $order['shipzipcodes'];
		$order['ship_pref'] = $order['shippref'];
		$order['ship_addressf'] = $order['shipaddressf'];
		$order['ship_addresss'] = $order['shipaddresss'];
		$order['ship_phonenumber'] = $order['shipphonenumber'];
	} else if ($order['ship_flag'] == 0) {
		$order['ship_namef'] = $order['namef'];
		$order['ship_nameg'] = $order['nameg'];
		$order['ship_kanaf'] = $order['kanaf'];
		$order['ship_kanag'] = $order['kanag'];
		$order['ship_zipcodef'] = $order['zipcodef'];
		$order['ship_zipcodes'] = $order['zipcodes'];
		$order['ship_pref'] = $order['pref'];
		$order['ship_addressf'] = $order['addressf'];
		$order['ship_addresss'] = $order['addresss'];
		$order['ship_phonenumber'] = $order['phonenumber'];
	}

	$order['ship_time'] = $order['shiptime'];
	if ($order['ship_time']) {
		$order['ship_time'] = $shiptimeKeyList_flip[$order['ship_time']];
	}
	$order['ship_date'] = $order['shipdate'];
	$order['ship_age'] = $order['shipage'];

	$order['store_flag'] = $order['shopflag'];
	$order['store'] = $order['shopname'];

	$order['component'] = 'shopping';
	$order['code'] = md5($order['regist_date'] . $order['username']);

	$order['methods'] = json_encode(array('flag_send' => $order['category_flag_send'], 'nominate' => $order['category_nominate']));

	if (!is_numeric($order['payment'])) {
		$order['payment'] = $paymentList_flip[$order['payment']];
	}

	if ($order['date_paid']) {
		$order['date_paid'] = substr($order['date_paid'], 0, 10);
		$order['paid'] = 1;
		$order['payment_confirmed'] = $order['total_price'] + $order['postage'];
	}

	if ($order['charged_id']) {
		$order['webpay'] = 1;
		$order['paid'] = 1;
		$order['payment_confirmed'] = $order['total_price'] + $order['postage'];
	}

	$cst->set_postdata($order);
	$cst->set_tbl('app');
	$cst->insertTable();
}

$sql = <<< HERE
ALTER TABLE app CHANGE id id int(11) AUTO_INCREMENT
HERE;

try {
	$res = $pdo->query($sql);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

// ページを表示
// 保存・送信後の表示設定

//mc_order_sub→app_subのupdate

$sql = <<< HERE
ALTER TABLE app_sub CHANGE id id int(11)
HERE;

try {
	$res = $pdo->query($sql);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

$suborders = array();

$sql = <<< HERE
SELECT sb.*,

i.`send_date`,
i.`wrap_use`,
i.`noshi_use`,
i.`nominate`,
i.`cart1_use`,
i.`cart1_title`,
i.`cart1_select`,
i.`cart1_note`,
i.`cart2_use`,
i.`cart2_title`,
i.`cart2_select`,
i.`cart2_note`,
i.`cart3_use`,
i.`cart3_title`,
i.`cart3_select`,
i.`cart3_note`,
i.`extra1_use`,
i.`extra1_title`,
i.`extra1_select`,
i.`extra1_note`,
i.`extra2_use`,
i.`extra2_title`,
i.`extra2_select`,
i.`extra2_note`,
i.`extra3_use`,
i.`extra3_title`,
i.`extra3_select`,
i.`extra3_note`,
sc.`flag_drink` AS flag_drink

 FROM mc_order_sub AS sb,
 sp_item as i,
 sp_subcategory as sc

WHERE sb.item_id=i.id
AND sc.id = i.subcategory_id
GROUP BY sb.id
HERE;

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

// 注文情報を配列に読み込む
while ($suborder = $res->fetch()) {
	array_push($suborders, $suborder);
}

$fields = array(
	'id' => 'integer',
	'app_id' => 'integer',
	'item_id' => 'integer',
	'num' => 'integer',
	'no' => 'text',
	'name' => 'text',
	'price' => 'integer',
	'ship_date' => 'text',
	'ship_time' => 'text',
	'noshi' => 'text',
	'noshi_other' => 'text',
	'wrap' => 'text',
	'extra1' => 'text',
	'extra2' => 'text',
	'extra3' => 'text',
	'cart1' => 'text',
	'cart2' => 'text',
	'cart3' => 'text',
	'methods' => 'text',
);

$sub = new shoppingDB();
$sub->set_fields($fields);

foreach ($suborders as $k => $suborder) {

	$method = array();

	$suborder['app_id'] = $suborder['order_id'];
	$suborder['ship_time'] = $suborder['shiptime'];
	$suborder['ship_date'] = $suborder['shipdate'];

	if ($suborder['ship_time']) {
		$suborder['ship_time'] = $shiptimeKeyList_flip[$suborder['ship_time']];
	}

	$method['flag_drink'] = $suborder['flag_drink'];
	$method['wrap_use'] = $suborder['wrap_use'];
	$method['noshi_use'] = $suborder['noshi_use'];

	if ($method['noshi_use']) {
		$method['noshi'] = $suborder['noshi'];
		$method['noshi_other'] = $suborder['noshi_other'];
	}
	if ($method['wrap_use']) {
		$method['wrap'] = $suborder['wrap'];
	}

	$method['nominate'] = $suborder['nominate'];
	$method['send_date'] = $suborder['send_date'];

	foreach (array('extra', 'cart') as $key) {

		for ($i = 1; $i <= 3; $i++) {
			if ($suborder[$key . $i . '_use'] > 0) {

				$suborder[$key . $i . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($suborder[$key . $i . '_select']));
				$tmp = null;
				if ($suborder[$key . $i . '_select']) {
					$tmp = explode(",", $suborder[$key . $i . '_select']);
					array_unshift($tmp, '');
				}

				$method[$key][$i] = array(
					'use' => $suborder[$key . $i . '_use'],
					'title' => $suborder[$key . $i . '_title'],
					'select' => $tmp,
					'note' => $suborder[$key . $i . '_note'],
				);
				if ($suborder[$key . $i]) {
					$method[$key][$i]['value'] = $suborder[$key . $i];
				}

			}
		}
	}

	$suborder['methods'] = json_encode($method);

	$sub->set_postdata($suborder);
	$sub->set_tbl('app_sub');
	$sub->insertTable();

}

$sql = <<< HERE
ALTER TABLE app_sub CHANGE id id int(11) AUTO_INCREMENT
HERE;

try {
	$res = $pdo->query($sql);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

//mc_customer→registのupdate

$sql = <<< HERE
ALTER TABLE regist CHANGE id id int(11)
HERE;

$regists = array();

$sql = <<< HERE
SELECT r.* FROM mc_customer AS r

HERE;

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (Exception $e) {
	var_dump($e);
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

// 注文情報を配列に読み込む
while ($regist = $res->fetch()) {
	array_push($regists, $regist);
}

$fields = array(
	'id' => 'integer',
	'univ_id' => 'integer',
	'regist_date' => 'text',
	'remote_addr' => 'text',
	'remote_host' => 'text',
	'user_agent' => 'text',
	'username' => 'text',
	'password' => 'text',
	'rank' => 'integer',
	'membership' => 'text',
	'email' => 'text',
	'namef' => 'text',
	'nameg' => 'text',
	'kanaf' => 'text',
	'kanag' => 'text',
	'zipcodef' => 'integer',
	'zipcodes' => 'integer',
	'pref' => 'text',
	'addressf' => 'text',
	'addresss' => 'text',
	'phonenumber' => 'text',
	'status' => 'integer',
	'date' => 'text',
);

$rg = new shoppingDB();
$rg->set_fields($fields);

foreach ($regists as $k => $regist) {

	if ($regist['registered'] == 9) {
		$regist['status'] = -9;
	} else if ($regist['registered'] == 1 || $regist['registered'] == 2) {
		if ($regist['username'] && $regist['password']) {
			$regist['status'] = 1;
		} else {
			continue;
		}
	} else {
		continue;
	}

	$regist['regist_date'] = $regist['date'];
	$regist['univ_id'] = $smarty->getConfigVars('univ_id');
	$regist['rank'] = 1;

	$rg->set_postdata($regist);
	$rg->set_tbl('regist');
	$rg->insertTable();
}

$sql = <<< HERE
ALTER TABLE regist CHANGE id id int(11) AUTO_INCREMENT
HERE;

try {
	$res = $pdo->query($sql);
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

header("Location: $self");
exit();

?>
