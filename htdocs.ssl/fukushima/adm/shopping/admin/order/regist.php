<?php

$shipdata = HTTP_Session2::get('shipdata');

//$custdata = HTTP_Session2::get('custdata');

if (!count($shipdata)) {
	header("Location: ${self}");
	exit();
} else {
	$smarty->assign('post', $shipdata);
}

// 最初のページに強制
if (!$shipdata['regist_id'] && $shipdata['no_user'] != '1') {
	header("Location: ${self}");
	exit();
}

if ($shipdata['regist_id']) {

//ユーザー情報の取得

	$sql = <<< HERE
SELECT * FROM regist WHERE id = ?

HERE;

	try {
		$res = $pdo->prepare($sql);
		$res->execute(array($shipdata['regist_id']));
	} catch (Exception $e) {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
		$smarty->display('error.tpl');
		exit();
	}

	$registdata = $res->fetch();

	$smarty->assign('post_pref', $registdata['pref']);
	$custdata["regist_id"] = $shipdata["regist_id"];
	HTTP_Session2::set('custdata', $custdata);

} else {
	$custdata["no_user"] = 1;
	HTTP_Session2::set('custdata', $custdata);
	$smarty->assign('post_pref', $custdata['pref']);
}

$app_count = $init_category["app_count"] + 1;

$infocode = $smarty->getTemplateVars('infocode');
if ($init_category["infocode"]) {$infocode = $init_category["infocode"];}
$infocode .= '-ODR';

$regist_code = $infocode . ":" . date("Ymd") . "-" . sprintf("%04d", $app_count); //受付番号の番号作成
$smarty->assign('regist_code', $regist_code);

//カード課金

$charges = array();

if ($shipdata['payment'] == 4) {

	$card = array();

	require_once "payjp.class.php";

	if ($shipdata['token_id']) {
		$card['card'] = $shipdata['token_id'];
	} else if ($shipdata['cust_id']) {

		if ($shipdata['card_id']) {
			$cust = new \shopping\payjp\webCharge();
			$cust->setCustomer_id($shipdata['cust_id']);
			$cust->setCard_id($shipdata['card_id']);

			$customerdata['email'] = $userAuth->getAuthData('email');
			$cust->setCustomerData($customerdata);
			$cust->updateCustomer();
		}
		$card['customer'] = $shipdata['cust_id'];

	} else {
		$smarty->assign('err', 1);
	}

	$card['amount'] = $shipdata['total_price_all'];

	$card['description'] = $regist_code;

	$charge = new \shopping\payjp\webCharge();

	$charge->setCard($card);

	$charges = $charge->charge();
	if (is_array($charges['err'])) {
		$smarty->assign('wc_errmsg', $charges['err']['errmsg']);
		$smarty->assign('err', 1);
	}

//$shipdata['token_id']='';

}

$fields_sql = HTTP_Session2::get('fields_sql');
$fields_sql_app = HTTP_Session2::get('fields_sql_app');

HTTP_Session2::set('shipdata', $shipdata);

if ($smarty->getTemplateVars('err') == '') {

	try {

		$pdo->beginTransaction();

		$shipdata['regist_date'] = date('Y-m-d H:i:s');

		if ($shipdata['no_user']) {

//投稿者の環境変数を取得
			$shipdata['remote_addr'] = getenv('REMOTE_ADDR');
			$shipdata['remote_host'] = getenv('REMOTE_HOST');
			$shipdata['user_agent'] = getenv('HTTP_USER_AGENT');
			$shipdata['username'] = md5('no_user' . $shipdata['regist_date'] . $shipdata['email']);
			$shipdata['password'] = md5('no_password' . $shipdata['regist_date'] . $shipdata['email']);
			$shipdata['membership'] = $shipdata['membership1'] . $shipdata['membership2'] . $shipdata['membership3'];
			$shipdata['status'] = -9;
			$shipdata['rank'] = 1;
			$shipdata['univ_id'] = $smarty->getConfigVars('univ_id');

			$fields_cst = array(
				'remote_addr' => 'text',
				'remote_host' => 'text',
				'user_agent' => 'text',
				'username' => 'text',
				'password' => 'text',
				'membership' => 'text',
				'regist_date' => 'text',
				'status' => 'integer',
				'univ_id' => 'integer',
				'rank' => 'integer',
			);

			if ($cart['flag_drink']) {
				if ($shipdata['birthday']) {

					$fields_cst['birthday'] = 'text';
					$fields_cst['id'] = 'integer';

					$userAuth->setAuthData('birthday', $shipdata['birthday']);

				}
			}

			$fields = array_merge($fields_cst, $fields_sql);

			$cst = new shoppingDB();
			$cst->set_fields($fields);
			$cst->set_postdata($shipdata);
			$cst->set_tbl('regist');

			$cst->insertTable();
			$shipdata['regist_id'] = $cst->get_last_insertId();
		}

		if (!$shipdata['no_user']) {

// 発送先の上書き
			if (!$shipdata['ship_flag'] || ($shipdata['ship_flag'] == 1 && $shipdata['ship_address'])) {

				if (!$shipdata['ship_flag']) {

					$shipdata['ship_namef'] = $registdata['namef'];
					$shipdata['ship_nameg'] = $registdata['nameg'];
					$shipdata['ship_kanaf'] = $registdata['kanaf'];
					$shipdata['ship_kanag'] = $registdata['kanag'];

					if ($registdata['new_addressf']) {
						$shipdata['ship_zipcodes'] = $registdata['new_zipcodes'];
						$shipdata['ship_zipcodef'] = $registdata['new_zipcodef'];
						$shipdata['ship_pref'] = $registdata['new_pref'];
						$shipdata['ship_addressf'] = $registdata['new_addressf'];
						$shipdata['ship_addresss'] = $registdata['new_addresss'];
						$shipdata['ship_addresst'] = $registdata['new_addresst'];
						if ($registdata['student_phone']) {
							$shipdata['ship_phonenumber'] = $registdata['student_phone'];
						} else {
							$shipdata['ship_phonenumber'] = $registdata['mobilephone'];
						}

					} else {
						$shipdata['ship_zipcodes'] = $registdata['zipcodes'];
						$shipdata['ship_zipcodef'] = $registdata['zipcodef'];
						$shipdata['ship_pref'] = $registdata['pref'];
						$shipdata['ship_addressf'] = $registdata['addressf'];
						$shipdata['ship_addresss'] = $registdata['addresss'];
						$shipdata['ship_addresst'] = $registdata['addresst'];
						$shipdata['ship_phonenumber'] = $registdata['phonenumber'];
					}

				} else if ($shipdata['ship_address']) {

					$adr = new shoppingDB();
					$adr->set_ship_address_id($shipdata['ship_address']);
					$adr->set_auth_id($registdata['id']);
					$ship_address = $adr->getShipAddress();

					$shipdata['ship_namef'] = $ship_address['ship_namef'];
					$shipdata['ship_nameg'] = $ship_address['ship_nameg'];
					$shipdata['ship_kanaf'] = $ship_address['ship_kanaf'];
					$shipdata['ship_kanag'] = $ship_address['ship_kanag'];

					$shipdata['ship_zipcodes'] = $ship_address['ship_zipcodes'];
					$shipdata['ship_zipcodef'] = $ship_address['ship_zipcodef'];
					$shipdata['ship_pref'] = $ship_address['ship_pref'];
					$shipdata['ship_addressf'] = $ship_address['ship_addressf'];
					$shipdata['ship_addresss'] = $ship_address['ship_addresss'];
					$shipdata['ship_addresst'] = $ship_address['ship_addresst'];
					$shipdata['ship_phonenumber'] = $ship_address['ship_phonenumber'];
					if ($cart['flag_drink']) {
						if (!$shipdata['ship_age']) {
							$shipdata['ship_age'] = $ship_address['ship_age'];
						}
					}
				}

			}

		} else {
			if ($shipdata['ship_flag'] == 0) {

				$shipdata['ship_namef'] = $shipdata['namef'];
				$shipdata['ship_nameg'] = $shipdata['nameg'];
				$shipdata['ship_kanaf'] = $shipdata['kanaf'];
				$shipdata['ship_kanag'] = $shipdata['kanag'];

				$shipdata['ship_zipcodes'] = $shipdata['zipcodes'];
				$shipdata['ship_zipcodef'] = $shipdata['zipcodef'];
				$shipdata['ship_pref'] = $shipdata['pref'];
				$shipdata['ship_addressf'] = $shipdata['addressf'];
				$shipdata['ship_addresss'] = $shipdata['addresss'];
				$shipdata['ship_addresst'] = $shipdata['addresst'];
				$shipdata['ship_phonenumber'] = $shipdata['phonenumber'];
			}

		}

		if (!$shipdata['ship_flag'] || ($shipdata['ship_flag'] == 1 && $shipdata['ship_address'])) {

			$fields_sql_ship = array(
				'ship_namef' => "text",
				'ship_nameg' => "text",
				'ship_kanaf' => "text",
				'ship_kanag' => "text",
				'ship_zipcodef' => "integer",
				'ship_zipcodes' => "integer",
				'ship_pref' => "text",
				'ship_addressf' => "text",
				'ship_addresss' => "text",
				'ship_addresst' => "text",
				'ship_phonenumber' => "text",
				'ship_age' => "integer",
			);

			if (count($fields_sql_app)) {

				$fields_sql_app = array_merge($fields_sql_app, $fields_sql_ship);
			} else {
				$fields_sql_app = $fields_sql_ship;
			}
		}

// 注文メインのデータを保存する

		$fields_om = array(
			'regist_date' => 'text',
			'regist_id' => 'integer',
			'category_id' => 'integer',
			'charged_id' => 'text',
			'app_count' => 'integer',
			'component' => 'text',
			'code' => 'text',
			'postage' => 'integer',
			'total_price' => 'integer',
			'reduction' => 'integer',
			'payment' => 'integer',
			'admin_flag' => 'integer',
			'memo' => 'text',
		);

		if ($init_category['flag_send']) {
			$fields_om['ship_date'] = 'text';
			$fields_om['ship_time'] = 'text';
		}

		$category_methods['flag_send'] = $init_category['flag_send'];
		$category_methods['nominate'] = $init_category['nominate'];
		$shipdata['methods'] = json_encode($category_methods);
		$fields_om['methods'] = 'text';

		$shipdata['charged_id'] = $charges->id;

		$shipdata['app_count'] = $app_count;
		$shipdata['component'] = COMPONENT;
//管理からの入力フラグ
		$shipdata['admin_flag'] = 1;
		$shipdata['code'] = md5(COMPONENT . PART . time() . $registdata['email']);

		$fields_om = array_merge($fields_om, $fields_sql_app);

		$om = new shoppingDB();
		$om->set_fields($fields_om);
		$om->set_postdata($shipdata);
		$om->set_tbl('app');

		$om->insertTable();

		$shipdata['app_id'] = $om->get_last_insertId();

// 注文された個々の商品のデータを保存する
		$items = $cart['items'];

		$fields_os = array(
			'app_id' => 'integer',
			'item_id' => 'integer',
			'num' => 'integer',
			'ship_date' => 'text',
			'ship_time' => 'text',
			'noshi' => 'text',
			'noshi_other' => 'text',
			'extra1' => 'text',
			'extra2' => 'text',
			'extra3' => 'text',
			'cart1' => 'text',
			'cart2' => 'text',
			'cart3' => 'text',
			'price' => 'integer',
			'name' => 'text',
			'no' => 'text',
			'methods' => 'text',
		);

		$os = new shoppingDB();
		$os->set_fields($fields_os);
		$os->set_tbl('app_sub');

		for ($i = 0; $i < count($items); $i++) {

// 商品の名前と価格を取得

			$sql = <<< HERE
SELECT name,price FROM sp_item AS item
 where item.id = ?

HERE;

			try {
				$res = &$pdo->prepare($sql);
				$res->execute(array($items[$i]["id"]));
			} catch (Exception $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				return;
			}
			$data = $res->fetch();

			if (is_array($cart['methods'][$i])) {

				if ($cart['methods'][$i]['wrap_use']) {
					$cart['methods'][$i]['wrap'] = $items[$i]['wrap'];
				}
				if ($cart['methods'][$i]['noshi_use']) {
					$cart['methods'][$i]['noshi'] = $items[$i]['noshi'];
					$cart['methods'][$i]['noshi_other'] = $items[$i]['noshi_other'];
				}
				if (count($cart['methods'][$i]['extra'])) {
					foreach ($cart['methods'][$i]['extra'] as $j => $extra) {
						$cart['methods'][$i]['extra'][$j]['value'] = $items[$i]['extra' . $j];
					}
				}
				if (count($cart['methods'][$i]['cart'])) {
					foreach ($cart['methods'][$i]['cart'] as $k => $extra) {
						$cart['methods'][$i]['cart'][$k]['value'] = $items[$i]['cart' . $k];
					}
				}

				$items[$i]['methods'] = json_encode($cart['methods'][$i]);
			}

			$items[$i]['name'] = $data['name'];
			$items[$i]['price'] = $data['price'];

			$items[$i]['app_id'] = $shipdata['app_id'];
			$items[$i]['item_id'] = $items[$i]['id'];
			$os->set_postdata($items[$i]);
			$os->insertTable();

		}

//配送先を保存
		/*
		if (!$shipdata["no_user"]) {
			if ($shipdata['ship_flag'] == 1) {

				$fields_ship = array(
					'regist_id' => 'integer',
					'ship_namef' => "text",
					'ship_nameg' => "text",
					'ship_kanaf' => "text",
					'ship_kanag' => "text",
					'ship_zipcodef' => "integer",
					'ship_zipcodes' => "integer",
					'ship_pref' => "text",
					'ship_addressf' => "text",
					'ship_addresss' => "text",
					'ship_addresst' => "text",
					'ship_phonenumber' => "text",
					'ship_age' => "integer",
				);

				if ($shipdata['ship_address']) {
					$shipdata['id'] = $shipdata['ship_address'];
				}

				$sp = new shoppingDB();
				$sp->set_fields($fields_ship);
				$sp->set_postdata($shipdata);
				$sp->set_tbl('app_ship');

				if (!$shipdata['ship_address']) {
					$sp->insertTable();
				} else {
					$sp->updateTable();
				}
			}
		}
*/
		$pdo->commit();

	} catch (Exception $e) {
		$pdo->rollBack();
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'データベースへの処理に失敗しました(r)。');
		$smarty->display('error.tpl');
		exit();

	}

// 注文完了メールを送信する
	/*
		require_once 'send_mail.php';

		$email = $registdata('email');
		if (!$email) {$email = $shipdata['email'];}

		$smarty->assign('post', $shipdata);

		$cust_body = $smarty->fetch('shop_order_mail.tpl');

		$order_body = $smarty->fetch('coop_order_mail.tpl');
		$cust_subject = 'ご注文ありがとうございました【' . $init_category["name"] . '】';

		$replymail = "DO_NOT_REPLY@u-coop.or.jp";

		$comments['component'] = COMPONENT;
		$comments['part'] = PART;
		$comments['cid'] = $init_category['id'];
		$comment = json_encode($comments);

		if (!send_mail($init_coopname, $replymail, $email, $cust_subject, $cust_body, null, null, null, $comment)) {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', '注文完了メールの送信に失敗しました。');
			$smarty->display('error.tpl');
			exit();
		}

		$order_subject = $regist_code . '【' . $init_category["name"] . '】';

		if ($shipdata['namef']) {
			$name = $shipdata['namef'] . ' ' . $shipdata['nameg'];
		} else {
			$name = $registdata('namef') . ' ' . $registdata('nameg');
		}

	//受注メールアドレスの上書き
		$init_ordermail = $smarty->getTemplateVars('init_ordermail');
		$init_errormail = $smarty->getTemplateVars('init_errormail');
		if ($init_category['ordermail']) {
			$init_ordermail = $init_category['ordermail'];
		}

		send_mail($name, $email, $init_ordermail, $order_subject, $order_body);

	//app_addへの登録

		try {

			$pdo->beginTransaction();

			$adddata['regist_id'] = $shipdata['regist_id'];

			$adddata['app_id'] = $shipdata['app_id'];
			$adddata['code'] = md5($infocode . time() . APP_DIR . $email);
			$smarty->assign('adic', $adddata['code']);

			$adddata['subject'] = $cust_subject;
			$adddata['memo'] = $cust_body;

			$adddata['send'] = 1;
			$adddata['noreply'] = 1;
			$adddata['auto_send'] = 1;
			$adddata['add'] = COMPONENT;

			$add = new setDB();

			$add->set_adddata($adddata);
			$add->insertAdd();
	//ログのセット

			$log = new setDB();
			$logdata['kind'] = COMPONENT;
			$logdata['app_id'] = $shipdata['app_id'];

			if ($userAuth->getUsername()) {
				$logdata['username'] = $userAuth->getUsername();
			} else {
				$logdata['username'] = "nouser_" . $email;
			}

			$log->set_logdata($logdata);
			$log->insertLog();

			$pdo->commit();

		} catch (Exception $e) {
			$pdo->rollBack();
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', 'データベースへの処理に失敗しました(r)。');
			$smarty->display('error.tpl');
			exit();

		}

*/

// カートを空にする
	$shipdata = array();
	$cart['items'] = array();
	$cart['methods'] = array();
	HTTP_Session2::set('cart' . PART, $cart);
	HTTP_Session2::set('shipdata', $shipdata);
	$smarty->assign('item_in_cart', "");

// ありがとうメッセージのページを表示する
	$tmpl = 'complete.tpl';

} else {
	//カードエラーの場合

	$tmpl = 'confirm.tpl';

	$smarty->assign('view_cat_id', $shipdata['category_id']);
}
$smarty->display($tmpl);

?>
