<?php
function smarty_block_orders($params, $content, &$smarty, &$repeat) {
	$orders = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	$pdo_repl = $smarty->getTemplateVars('pdo_repl');
	$authority = $smarty->getTemplateVars('authority');

	if (is_numeric($smarty->getTemplateVars('view_status'))) {
		$view_status = $smarty->getTemplateVars('view_status');
	}

	if (is_numeric($smarty->getTemplateVars('view_paid'))) {
		$view_paid = $smarty->getTemplateVars('view_paid');
	}

	$view_searchword = $smarty->getTemplateVars('view_searchword');
	$view_regist_date = $smarty->getTemplateVars('view_regist_date');
	$view_date_paid = $smarty->getTemplateVars('view_date_paid');

	if ($smarty->getTemplateVars('view_category_id')) {
		$view_category_id = $smarty->getTemplateVars('view_category_id');
	}

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_order', 0);
		$smarty->assign('db_error', 0);
		// 注文情報をデータベースから読み込む
		$data = array();
		$where = array();
		$or = array();

		$sql4count = <<< HERE
SELECT COUNT(app.id) AS ct

HERE;

		$sql = <<< HERE
SELECT app.*,
sum(os.num) as num,
IFNULL(app.total_price,0)+IFNULL(app.postage,0)-IFNULL(app.reduction,0) as total_price_all,
r.username as username,
app.regist_id as regist_id,
r.namef as regist_namef,
r.nameg as regist_nameg,
r.kanaf as regist_kanaf,
r.kanag as regist_kanag,
r.status as regist_status,
c.flag_send as category_flag_send,
c.return_message as return_message,
c.infocode as category_infocode,
c.denomination as category_denomination,
c.nominate as category_nominate,
CHARACTER_LENGTH(c.paid_completed_message) as category_paid_completed_message,
CHARACTER_LENGTH(c.nopaid_message) as category_nopaid_message

HERE;

		if ($params['no_treatment']) {
			$sql .= ",ae.`date` AS `date_exported`";
		}

		$sql .= <<< HERE

FROM app AS app
LEFT JOIN regist AS r ON app.regist_id = r.id
LEFT JOIN app_sub AS os ON app.id = os.app_id
LEFT JOIN sp_category AS c ON app.category_id = c.id

HERE;

		$sql4count .= <<< HERE

FROM app AS app
LEFT JOIN regist AS r ON app.regist_id = r.id
LEFT JOIN sp_category AS c ON app.category_id = c.id

HERE;

		if ($params['no_treatment']) {
			$sql .= " JOIN app_exported AS ae ON ae.id=app.id ";
			$sql4count .= " JOIN app_exported AS ae ON ae.id=app.id ";

			array_push($data, 0);
			array_push($where, "IFNULL(app.status,0) = ?");

		}

		if ($smarty->getTemplateVars('view_order_id')) {
			array_push($data, $smarty->getTemplateVars('view_order_id'));
			array_push($where, "app.id = ?");
		} else if ($smarty->getTemplateVars('view_app_id')) {
			array_push($data, $smarty->getTemplateVars('view_app_id'));
			array_push($where, "app.id = ?");
		} else if ($params['app_id']) {
			array_push($data, intval($params['app_id']));
			array_push($where, "app.id = ?");
		} else if ($smarty->getTemplateVars('view_app_ic')) {
			array_push($data, $smarty->getTemplateVars('view_app_ic'));
			array_push($where, "app.code = ?");
		}

		if ($view_searchword) {
			$view_searchword = trim($view_searchword);
			$view_searchword = preg_replace('/　/', ' ', $view_searchword);
			$view_searchword = mb_convert_kana($view_searchword, "a");
			$view_searchword = preg_replace('/\s+/', ' ', $view_searchword);
			$words = explode(' ', $view_searchword);
			foreach ($words as $word) {
				array_push($data, '%' . $word . '%', '%' . $word . '%', '%' . $word . '%', '%' . $word . '%');
				array_push($or, "r.namef LIKE ? OR r.nameg LIKE ? OR r.kanaf LIKE ? OR r.kanag LIKE ?");

				array_push($data, '%' . $word . '%', '%' . $word . '%', '%' . $word . '%', '%' . $word . '%');
				array_push($or, "app.ship_namef LIKE ? OR app.ship_nameg LIKE ? OR app.ship_kanaf LIKE ? OR app.ship_kanag LIKE ?");

				if (intval($word) > 0) {
					array_push($data, intval($word));
					array_push($or, " app.app_count = ? ");
				}
				if (count($or)) {
					array_push($where, "(" . implode(" OR ", $or) . ") ");
				}

			}
		}

		if ($view_date_paid) {
			array_push($data, $view_date_paid . "%");
			array_push($where, " (app.date_paid LIKE ?) ");
		}

		if ($view_regist_date) {
			array_push($data, $view_regist_date . '%');
			array_push($where, " (app.regist_date LIKE ?) ");
		}

		if (isset($view_category_id) && is_numeric($view_category_id)) {
			array_push($data, $view_category_id);
			array_push($where, " app.category_id = ? ");
		}

		// 管理者モード
		if ($_SESSION['admin_mode']) {

			if ($authority["master"]["master"] == 0) {
				if (is_array($authority["shopping"]["category_id"])) {
					$ors = array();
					foreach ($authority["shopping"]["category_id"] as $ac) {
						array_push($data, $ac);
						array_push($ors, "c.id = ?\n");
					}
					if (count($ors)) {
						$or = implode(" OR ", $ors);
						array_push($where, "( " . $or . ") \n");
					} else {
						$smarty->assign('no_category', 1);
						$repeat = false;
						return;
					}

				} else {
					$smarty->assign('no_category', 1);
					$repeat = false;
					return;
				}
			}
/*

if (count($authority['shopping']['category_id'])) {
$ats = array();
foreach ($authority['shopping']['category_id'] as $at) {
array_push($ats, "c.id = ?");
array_push($data, $at);
}
array_push($where, ' (' . implode(' OR ', $ats) . ')');
} else {
// 権限がないとき、サブカテゴリなし
$smarty->assign('no_order', 1);
$repeat = false;
return;

}
 */

			if (is_numeric($view_status)) {
				array_push($data, $view_status);
				array_push($where, "IFNULL(app.status,0) = ?");
			} else if (isset($params['status'])) {
				array_push($data, intval($params['status']));
				array_push($where, "IFNULL(app.status,0) = ?");
			}

			if (isset($view_paid)) {
				if ($view_paid == 1) {
					array_push($where, "((IFNULL(app.status,0) <= 1 AND IFNULL(app.total_price,0) - IFNULL(app.reduction,0) + IFNULL(app.postage,0) = IFNULL(app.payment_confirmed,0))
					 OR (app.status = 9 AND IFNULL(app.price_cancelled,0) = IFNULL(app.payment_confirmed,0)))");

				} else if ($view_paid == 2) {
					array_push($where, "((IFNULL(app.status,0) <= 1 AND IFNULL(app.total_price,0) - IFNULL(app.reduction,0) + IFNULL(app.postage,0) < IFNULL(app.payment_confirmed,0))
					 OR (app.status = 9 AND IFNULL(app.price_cancelled,0) < IFNULL(app.payment_confirmed,0)))");
				} else if ($view_paid == 0) {
					array_push($where, "((IFNULL(app.status,0) <= 1 AND IFNULL(app.total_price,0) - IFNULL(app.reduction,0) + IFNULL(app.postage,0) > IFNULL(app.payment_confirmed,0))
					 OR (app.status = 9 AND IFNULL(app.price_cancelled,0) > IFNULL(app.payment_confirmed,0)))");
				}
			} else if ($params['paid']) {
//				array_push($data, intval($params['paid']));
				array_push($where, "((IFNULL(app.status,0) <= 1 AND IFNULL(app.total_price,0) - IFNULL(app.reduction,0) + IFNULL(app.postage,0) = IFNULL(app.payment_confirmed,0))
					 OR (app.status = 9 AND IFNULL(app.price_cancelled,0) = IFNULL(app.payment_confirmed,0)))");

			}

			if ($params['not_sendmail_paid_completed']) {
				array_push($data, 0);
				array_push($where, "IFNULL(app.sendmail_paid_completed,0) = (?)");

			}

			if ($params['nopaid']) {
//				array_push($data, 1);
				//				array_push($where, "IFNULL(app.paid,0) not in (?)");
				array_push($where, "IFNULL(app.total_price,0) - IFNULL(app.reduction,0) + IFNULL(app.postage,0) > IFNULL(app.payment_confirmed,0)");
				array_push($data, 1);
				array_push($where, "IFNULL(app.status,0) <= ?");
				array_push($data, -9);
				array_push($where, "IFNULL(app.sendmail_nopaid,0) > (?)");
			}
			if ($params['nocard']) {
				$paymentTypeList = $smarty->getTemplateVars('paymentTypeList');
				if (count($paymentTypeList)) {
					foreach ($paymentTypeList as $k => $p) {
						if ($p == 1) {
							array_push($data, intval($k));
							array_push($where, "IFNULL(app.payment,0) not in (?)");
						}
					}
				}
			}

			if ($smarty->getTemplateVars('view_payment')) {
				array_push($data, $smarty->getTemplateVars('view_payment'));
				array_push($where, "app.payment = ?");
//				array_push($data, 1);
				//				array_push($where, "IFNULL(app.status,0) <= ?");
			}

		} else {
			array_push($data, $smarty->getTemplateVars('auth_user_id'));
			array_push($where, "r.id = ?");
		}

		array_push($where, "app.component = ?");
		array_push($data, "shopping");

		if (count($where)) {
			$sql .= 'WHERE ' . implode(' AND ', $where) . " ";
			$sql4count .= 'WHERE ' . implode(' AND ', $where) . " ";
		}

		if (COMPONENT == "shopping") {

//paging

			// クエリを実行する
			try {
				if ($smarty->getTemplateVars('master_pdo')) {
					$res = $pdo->prepare($sql4count);
				} else {
					$res = $pdo_repl->prepare($sql4count);
				}
				$res->execute($data);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}

			$order_counts = $res->fetch();
			$order_count = $order_counts['ct'];

			$smarty->assign('order_count', $order_count);
			// ページ数を求める
			$per_page = intval($params['per_page']);
			if ($per_page <= 0) {
				$per_page = 10;
			}
			$page_count = intval(($order_count - 1) / $per_page) + 1;
			$smarty->assign('page_count', $page_count);
			$smarty->assign('per_page', $per_page);
			// 現在のページ番号の調節
			$cur_page = intval($_GET['page']);
			if ($cur_page < 1) {
				$cur_page = 1;
			} else if ($cur_page > $page_count) {
				$cur_page = $page_count;
			}
			// ページ番号等を変数に設定する
			$smarty->assign('cur_page', $cur_page);
			$smarty->assign('prev_page', $cur_page - 1);
			$smarty->assign('next_page', $cur_page + 1);
			$smarty->assign('is_next_page', ($cur_page < $page_count));
			$smarty->assign('is_prev_page', ($cur_page > 1));
			$smarty->assign('first_order_no', ($order_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_order_no', ($cur_page == $page_count) ? $order_count : $cur_page * $per_page);

//end paging
		}

		$sql .= <<< HERE

GROUP BY app.id

HERE;

		$sql .= <<< HERE
ORDER BY app.regist_date DESC

HERE;

		// 注文の出力件数を得る
		$per_page = $smarty->getTemplateVars('per_page');
		// 変数$per_pageが定義されているときは、1ページ分の注文を読み込む
		if ($per_page) {
			$cur_page = $smarty->getTemplateVars('cur_page');
			$offset = ($cur_page - 1) * $per_page;
			$sql .= " LIMIT " . $offset . ", " . $per_page;
		}

		try {
			$res = $pdo_repl->prepare($sql);
			$res->execute($data);
		} catch (Exception $e) {
			echo '<pre>' . $sql . '</pre>';
			print_r($data);
			echo $e->getMessage();
			exit;
			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('db_error', 1);
			$repeat = false;
			return;
		}
		// 注文情報を配列に読み込む
		$orders = $res->fetchAll();

		// 注文情報がない場合
		if (count($orders) == 0) {
			$smarty->assign('no_order', 1);
			$repeat = false;
			return;
		} else {
			$smarty->assign('no_order', 0);
		}
		// 注文情報をSmartyの変数に保存
		$smarty->assign('orders', $orders);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$orders = $smarty->getTemplateVars('orders');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr');
	}

	// 個々の注文を読み込む
	$order = $orders[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する

	$order['category_infocode'] .= "-ODR";
	if ($order['status'] == 9) {
		$order['paid_difference'] = $order['payment_confirmed'] - $order['price_cancelled'];
	} else {
		$order['paid_difference'] = $order['payment_confirmed'] - $order['total_price_all'];
	}

	if ($order['ship_from_phonenumber']) {
		$tmp = [];
		$tmp = explode('-', $order['ship_from_phonenumber']);
		if (count($tmp)) {
			foreach ($tmp as $key => $value) {
				$order['ship_from_phonenumber' . ($key + 1)] = $value;
			}
		}
	}
	if ($order['ship_phonenumber']) {
		$tmp = [];
		$tmp = explode('-', $order['ship_phonenumber']);
		if (count($tmp)) {
			foreach ($tmp as $key => $value) {
				$order['ship_phonenumber' . ($key + 1)] = $value;
			}
		}
	}

	$order['methods'] = json_decode($order['methods'], true);
	$order['return_message'] = htmlspecialchars_decode($order['return_message']);
	$smarty->assign('order', $order);

	$smarty->assign('order_header', ($ctr == 0));
	$smarty->assign('order_footer', ($ctr == count($orders) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr', $ctr);
	$repeat = ($ctr <= count($orders));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
