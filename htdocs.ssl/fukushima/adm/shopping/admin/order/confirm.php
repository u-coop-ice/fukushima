<?php

// カート処理のメッセージがあれば、それをSmartyの変数にセットし、
// セッションから削除する
if (isset($cart['cart_msg'])) {
	$smarty->assign('cart_msg', $cart['cart_msg']);
	unset($cart['cart_msg']);
	HTTP_Session2::set('cart' . PART, $cart);
}
// カートの内容が削除されていれば、そのことをSmartyの変数にセットする
if ($_GET['cleared'] == '1') {
	$smarty->assign('cleared', 1);
}
// 商品がカートにあるかどうかを調べる
$is_item_exist = count($cart['items']);
$smarty->assign('is_item_exist', $is_item_exist);

// 購入確認表示モードをセット
$smarty->assign('now_mode', 'confirm');

$methods['address']['title'] = "ご注文者住所";
$methods['phonenumber']['title'] = "ご注文者電話番号";

try {
	$ap = new adminShoppingOrderDB();
	$ap->set_shipdata($shipdata);
	$ap->setAdminAuth($auth);
	$ap->set_session_cart((array) $cart);
	$ap->saveAppShopping();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:

		switch ($ap->get_step()) {
		case 1:
			header('Location: ' . $self . '?mode=list_item');
			break;
		case 2:
			$smarty->display('view_cart.tpl');
			break;
		case 3:
			$smarty->display('step3.tpl');
			break;
		case 4:
			$smarty->display('step4.tpl');
			break;
		case 5:
			$smarty->display('confirm.tpl');
			break;
		default:
			$smarty->display('view_cart.tpl');
			break;
		}
		break;
	case 1:
		$smarty->assign('errmsg', $e->getMessage());
		$smarty->display('error.tpl');
		break;
	}
}
exit();

//合計金額・送料計算
if ($init_category['component']) {

	require_once "../../app/shopping/" . $init_category['component'] . "/lib/calcPrice.class.php";

	$namespace = "shopping\\" . $init_category['component'] . "\\price";
	$ps = new $namespace;
	$ps->set_postdata($shipdata);
	$ps->set_cart($cart);
	$ps->calc_price();

	$cart = $ps->get_cart();

	$postage = $ps->get_postage();
	$reduction = $ps->get_reduction();
	$total_price = $ps->get_price();
	$smarty->assign("postage", $postage);
	$smarty->assign("reduction", $reduction);
	$smarty->assign('total_price', $total_price);
	$smarty->assign('total_price_all', $total_price + $postage - $reduction);

	$shipdata['postage'] = $postage;
	$shipdata['reduction'] = $reduction;
	$shipdata['total_price'] = $total_price;
	$shipdata['total_price_all'] = $total_price + $postage - $reduction;
	HTTP_Session2::set('shipdata', $shipdata);
}

HTTP_Session2::set('cart' . PART, $cart);

if (isset($_POST['order'])) {

	$shipdata["category_id"] = intval($_POST["category_id"]);
	$custdata["category_id"] = $shipdata["category_id"];

	if ($shipdata["category_id"] < 1) {
		$smarty->assign('category_id_err', 1);
		$smarty->assign('err', 1);
	}

	if (isset($_POST["regist_id"])) {
		$shipdata["regist_id"] = intval($_POST["regist_id"]);
		if ($shipdata["regist_id"] < 1) {
			$smarty->assign('regist_id_err', 1);
			$smarty->assign('err', 1);
		}
	} else {
		$shipdata['no_user'] = 1;
	}

	HTTP_Session2::set('fields_all', $fields_all);
	HTTP_Session2::set('fields_sql', $fields_sql);
	HTTP_Session2::set('fields_sql_app', $fields_sql_app);

	HTTP_Session2::set('shipdata', $shipdata);
	HTTP_Session2::set('custdata', $custdata);

// 表示するページの選択
	if ($smarty->getTemplateVars('err') != '') {

// 登録内容にエラーがあったら、入力のページを再度表示
		$tmpl = 'step1.tpl';
	} else {
// 登録内容の確認の場合
		$tmpl = 'list_item.tpl';
	}

} else if (isset($_POST['step1'])) {

	$tmpl = 'step2.tpl';

} else if (isset($_POST['step2']) || is_array($_POST['ship_address'])) {

	if (!$shipdata["regist_id"]) {
		$methods['email']['use'] = 2;
		$methods['name']['use'] = 2;
		$methods['address']['use'] = 2;
		$methods['phonenumber']['use'] = 2;
		$methods['membership']['use'] = 1;
	}

	$methods['ship_flag']['use'] = 1;

	if (intval($_POST['ship_from']) == 1) {

		$methods['ship_from_flag']['use'] = 2;
		$methods['ship_from']['use'] = 2;
		$methods['ship_from_phonenumber']['use'] = 2;
	}

	if (intval($_POST['ship_flag']) == 0) {

	} else if (intval($_POST['ship_flag']) == 1) {

		if (is_array($_POST['ship_address'])) {
			if ($shipdata['ship_address'] != intval(key($_POST['ship_address']))) {
				$shipdata['ship_address'] = intval(key($_POST['ship_address']));
				$shipdata['ship_age'] = null;
			}
		} else {
			unset($shipdata['ship_address']);
			$methods['ship']['use'] = 2;
			$methods['ship_phonenumber']['use'] = 2;
		}

	} else if (intval($_POST['ship_flag']) == 2) {
		$methods['ship_store']['use'] = 2;
	}

	if (count($methods)) {
		$mt = new shoppingDB();
		$mt->set_methods($methods);
		$fields = $mt->get_fields_input();

		$fields_must = array_merge($fields['must'][2], $fields['must'][3], $fields['must'][4]);
		$fields_all = array_merge($fields['all']);

//emailチェック回避
		if ($_POST["email"]) {
			$_POST["emailcfrm"] = $_POST["email"];
		}

		foreach ($fields_all as $field => $v) {
			$value = trim($_POST[$field]);
			$value = mb_convert_kana($value, "KV");
			if ($v == "integer") {
				$value = intval($value);
			} else {
				$value = htmlspecialchars($value, 3, "UTF-8");
			}
			if (!preg_match('/^ship/', $field)) {
				$custdata[$field] = $value;
			}
			$shipdata[$field] = $value;
		}

		// 必須項目の入力チェック

		foreach ($fields_must as $field => $v) {
			if ($shipdata[$field] == '') {
//				echo $field;
				$smarty->assign($field . '_err', 1);
				$smarty->assign('err', 1);
			}
		}

//全角半角変換
		$fields_num = array('membership1', 'membership2', 'membership3', 'zipcodef', 'zipcodes',
			'ship_phonenumber1', 'ship_phonenumber2', 'ship_phonenumber3', 'phonenumber1', 'phonenumber2', 'phonenumber3',
			'ship_from_phonenumber1', 'ship_from_phonenumber2', 'ship_from_phonenumber3',
		);
		foreach ($fields_num as $field) {
			if ($shipdata[$field] != '') {
				$shipdata[$field] = zen2han($shipdata[$field]);
				if (!preg_match("/^[0-9]+$/", $shipdata[$field])) {
					$smarty->assign('no_num_' . $field . '_err', 1);
					$smarty->assign('err', 1);
				}
			}
		}

//birthday生成

		if ($methods['age']['use']) {
			if (!$userAuth->getAuthData('birthday')) {
				$shipdata['birthday'] = $shipdata['birth_year'] . sprintf("%02d", $shipdata['birth_month']) . sprintf("%02d", $shipdata['birth_day']);
			}
		}

//電話番号生成
		if ($shipdata['ship_phonenumber1']) {
			$shipdata['ship_phonenumber'] = $shipdata['ship_phonenumber1'] . '-' . $shipdata['ship_phonenumber2'] . '-' . $shipdata['ship_phonenumber3'];
		}

		if ($shipdata['ship_from_phonenumber1']) {
			$shipdata['ship_from_phonenumber'] = $shipdata['ship_from_phonenumber1'] . '-' . $shipdata['ship_from_phonenumber2'] . '-' . $shipdata['ship_from_phonenumber3'];
		}
		if ($shipdata['phonenumber1']) {
			$shipdata['phonenumber'] = $shipdata['phonenumber1'] . '-' . $shipdata['phonenumber2'] . '-' . $shipdata['phonenumber3'];
		}

		$fields_sql = $mt->get_fields_sql();
		$fields_sql_app = $mt->get_fields_sql_app();
	}

	HTTP_Session2::set('fields_all', $fields_all);
	HTTP_Session2::set('fields_sql', $fields_sql);
	HTTP_Session2::set('fields_sql_app', $fields_sql_app);

	HTTP_Session2::set('shipdata', $shipdata);
	HTTP_Session2::set('custdata', $custdata);

// 表示するページの選択
	if ($smarty->getTemplateVars('err') != '') {

// 登録内容にエラーがあったら、入力のページを再度表示
		$tmpl = 'step2.tpl';
	} else {
// 登録内容の確認の場合
		$tmpl = 'step3.tpl';
	}

} else if (isset($_POST['step3'])) {
	if ($shipdata['shipflag'] < 2) {

		if (isset($_POST['step3']) && $init_category['flag_send']) {

			$fields = array('ship_date', 'ship_time');
			foreach ($fields as $field) {
				$value = strip_tags($_POST[$field]);
				$value = mb_convert_kana($value, "KV");
				$value = htmlspecialchars($value, 3, "UTF-8");
				$shipdata[$field] = $value;
			}

			HTTP_Session2::set('shipdata', $shipdata);
		}

		if ($cart['flag_drink']) {
			if ($shipdata["ship_flag"] == 1) {
				$shipdata["ship_age"] = intval($_POST["ship_age"]);
				if ($shipdata["ship_age"] == -1) {
					$smarty->assign('no_adult_ship_age_err', 1);
					$smarty->assign('err', 1);
				}
			}
			HTTP_Session2::set('shipdata', $shipdata);

		}

// カートの商品数
		$ctr = $is_item_exist;

		$fields = array('ship_date', 'ship_time', 'noshi', 'noshi_other', 'wrap'
			, 'extra1', 'extra2', 'extra3');

		for ($i = 1; $i <= $ctr; $i++) {
			foreach ($fields as $field) {
				$value = strip_tags($_POST[$field . $i]);
				$value = mb_convert_kana($value, "KV");
				$value = htmlspecialchars($value, 3, "UTF-8");
				$cart['items'][($i - 1)][$field] = $value;
			}
		}
		HTTP_Session2::set('cart' . PART, $cart);

	}

// 表示するページの選択
	if ($smarty->getTemplateVars('err') != '') {
// 登録内容にエラーがあったら、入力のページを再度表示
		$tmpl = 'step3.tpl';
	} else {
// 登録内容の確認の場合
		$tmpl = 'step4.tpl';
	}

// 再入力の場合
	if ($_POST['reinput2']) {
		$smarty->assign('reinput', 1);
		$tmpl = 'step3.tpl';
	}

} else if (isset($_POST['confirm'])) {

	$fields = array();
	$fields_must = array();

	$fields_sp2m = array(
		"payment",
	);

	if ($init_category['opt_bill']) {
		$fields_sp2m = array(
			"payment",
			"bill",
		);

		if ($shipdata['ship_flag'] == 2) {
			$fields_sp2m = array(
				"payment",
			);
		}
	}

	$fields_bill_must = array(
		'bill_zipcodef',
		'bill_zipcodes',
		'bill_pref',
		'bill_addressf',
		'bill_name',
	);
	$fields_bill = array(
		'bill_addresss',
		'bill_addresst',
	);

	$fields_sp2 = array(
		"memo",
	);

	$fields = array_merge($fields, $fields_sp2m, $fields_sp2);
	$fields_must = array_merge($fields_must, $fields_sp2m);

	if ($_POST['bill'] == 3) {
		$fields_must = array_merge($fields_must, $fields_bill_must);
		$fields = array_merge($fields, $fields_bill_must, $fields_bill);
	}

	foreach ($fields as $field) {
		$value = strip_tags($_POST[$field]);
		$value = mb_convert_kana($value, "KV");
		$shipdata[$field] = htmlspecialchars($value, 3, "UTF-8");
	}

	$charges = array();

	if ($shipdata['payment'] == 4) {

		if (isset($_POST['chgCardInfo'])) {
			unset($shipdata['token_id']);
		}

		if ($_POST['payjp-token']) {
			$shipdata['token_id'] = addslashes($_POST['payjp-token']);
		} else if ($_POST['payjp-card_id']) {
			$shipdata['card_id'] = addslashes($_POST['payjp-card_id']);
		}

		unset($shipdata['regist_card']);
		if ($_POST['regist_card']) {
			$shipdata['regist_card'] = intval($_POST['regist_card']);
		}
		if (!$shipdata['token_id']) {
			unset($shipdata['regist_card']);
		}

		if (!$shipdata['token_id'] && !$shipdata['card_id']) {
			$smarty->assign('card_err', 1);
			$smarty->assign('err', 1);
		}

	}

	if (isset($_POST['cust_id'])) {
		$shipdata['cust_id'] = $userAuth->getAuthData('cust_id');
	}

	// 必須項目の入力チェック
	foreach ($fields_must as $field) {
		if ($shipdata[$field] == '') {
			$smarty->assign($field . '_err', 1);
			$smarty->assign('err', 1);
		}
	}

	HTTP_Session2::set('shipdata', $shipdata);

	$tmpl = 'shop_confirm.tpl';

// 表示するページの選択
	if ($smarty->getTemplateVars('err') != '') {
// 登録内容にエラーがあったら、入力のページを再度表示
		$tmpl = 'step4.tpl';
	} else {
// 登録内容の確認の場合
		$tmpl = 'confirm.tpl';
	}

} //confirm

if ($init_category['component']) {
//合計金額・送料計算
	require_once "../../app/shopping/" . $init_category['component'] . "/lib/calcPrice.class.php";

	$namespace = 'shopping\\' . $init_category['component'] . '\\price';
//$ps = new shopping\goods\price;
	$ps = new $namespace;

	if ($shipdata['ship_flag'] == 0) {

		if ($shipdata['pref']) {
		} else if ($shipdata['new_pref']) {
			$shipdata['postage_pref'] = $shipdata['new_pref'];
		} else if ($shipdata['regist_id']) {
			$reg = new adminDB();
			$reg->set_id($shipdata['regist_id']);
			$reg->set_tbl("regist");
			$registdata = $reg->selectTable();
			if ($registdata['new_pref']) {
				$shipdata['postage_pref'] = $registdata['new_pref'];
			} else if ($registdata['pref']) {
				$shipdata['postage_pref'] = $registdata['pref'];
			}
		}

	}
	$ps->set_postdata($shipdata);
	$ps->set_cart($cart);
	$ps->calc_price();

	$cart = $ps->get_cart();
	HTTP_Session2::set('cart' . PART, $cart);

	$postage = $ps->get_postage();
	$reduction = $ps->get_reduction();
	$total_price = $ps->get_price();
	$smarty->assign("postage", $postage);
	$smarty->assign("reduction", $reduction);
	$smarty->assign('total_price', $total_price);
	$smarty->assign('total_price_all', $total_price + $postage - $reduction);

	$shipdata['postage'] = $postage;
	$shipdata['reduction'] = $reduction;
	$shipdata['total_price'] = $total_price;
	$shipdata['total_price_all'] = $total_price + $postage - $reduction;
	HTTP_Session2::set('shipdata', $shipdata);
}

// 再入力の場合
if ($_POST['reinput1']) {
	$smarty->assign('reinput', 1);
	$tmpl = 'step2.tpl';
}

if ($_POST['reinput2']) {
	$smarty->assign('reinput', 1);
	$tmpl = 'step3.tpl';
}

if ($_POST['reinput3']) {
	$smarty->assign('reinput', 1);
	$tmpl = 'step4.tpl';
}

if (count($shipdata) < 2) {
	$shipdata = $custdata;
}

$shipdata = HTTP_Session2::get('shipdata');

$smarty->assign('post', $shipdata);
$smarty->assign('view_cat_id', $shipdata['category_id']);

$smarty->assign('methods', $methods);

$smarty->display($tmpl);
?>
