<?php
function smarty_block_suborders($params, $content, &$smarty, &$repeat) {
	$suborders = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_item', 0);
		$smarty->assign('db_error', 0);

		// pdoオブジェクトを得る
		$pdo = $smarty->getTemplateVars('pdo');
		// テーブルの接頭語を得る
		// SQLを作成する
		$type = array();
		$data = array();
		$where = array();
		$view_order_id = $smarty->getTemplateVars('view_order_id');
		$view_app_id = $smarty->getTemplateVars('view_app_id');

// 特定の注文での商品を一覧表示する場合

		$sql = <<< HERE
select om.id as order_id,
om.postage as postage,
os.num as num,
os.price as price,
os.price*os.num AS total_price,
os.name as name,
os.no as no,
os.ship_date as ship_date,
os.ship_time as ship_time,
os.noshi as noshi,
os.noshi_other as noshi_other,
os.noshi_name as noshi_name,
os.extra1 as extra1,
os.extra2 as extra2,
os.extra3 as extra3,
os.methods,
i.no as item_no
FROM app_sub os
LEFT JOIN app om ON om.id = os.app_id
LEFT JOIN sp_item i ON os.item_id = i.id
 where os.app_id = ?

HERE;

		if ($view_order_id) {
			array_push($type, 'integer');
			array_push($data, $view_order_id);
		} else if ($view_app_id) {
			array_push($type, 'integer');
			array_push($data, $view_app_id);
		} else {
			$smarty->assign('no_suborder', 1);
			$repeat = false;
			exit();
		}

		$mode = $smarty->getTemplateVars('mode');

		// SQLにwhere句を連結する
		if (count($where)) {
			$sql .= "where " . implode("\nand ", $where) . "\n";
		}
		// order句を連結する
		$sql .= " order by os.`id` ";

		$sql .= "\n";

		// クエリを実行する

		try {
			$res = $pdo->prepare($sql);
			$res->execute($data);
		} catch (Exception $e) {
			// データベースアクセスに失敗したらエラーとする
			if (count($items) == 0) {
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
		}
		// 商品を配列に読み込む
		while ($suborder = $res->fetch()) {
			array_push($suborders, $suborder);
		}
//        }
		// 商品がない場合
		if (count($suborders) == 0) {
			$smarty->assign('no_suborder', 1);
			$repeat = false;
			return;
		}
		// 各商品の小計と全体の合計を計算
		//		$total_price = 0;
		$flag_alc = 0; // 酒類選択フラッグ
		for ($i = 0; $i < count($suborders); $i++) {
//			$suborder_total_price = $suborders[$i]['price'] * $suborders[$i]['num'];
			//			$suborders[$i]['total_price'] = $suborder_total_price;
			//			$total_price += $suborder_total_price;
			if ($suborders[$i]['flag_drink']) {
				$flag_alc = 1;
			}
		}
		// 商品をSmartyの変数に保存
		$smarty->assign('suborders', $suborders);
		// 全体の合計をSmartyの変数に保存

//		if ($suborders[0]['postage'] > 0) {
		//			$total_price += $suborders[0]['postage'];
		//		}

//		$smarty->assign('total_price', $total_price);
		// 酒類選択フラッグをSmartyの変数に保存
		$smarty->assign('flag_alc', $flag_alc);

		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_suborder', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した商品を読み出す
		$suborders = $smarty->getTemplateVars('suborders');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_suborder');
	}

	// 個々の商品を読み込む
	$suborder = $suborders[$ctr];

	// レコードの各フィールドをSmartyの変数に設定する
	if (count($suborder)) {
		$suborder['name'] = htmlspecialchars_decode($suborder['name']);
		$suborder['methods'] = json_decode($suborder['methods'], true);
		$smarty->assign('suborder', $suborder);
	}

	$smarty->assign('suborder_header', ($ctr == 0));
	$smarty->assign('suborder_footer', ($ctr == count($suborders) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の商品があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_suborder', $ctr);
	$smarty->assign('index', $ctr - 1);
	$repeat = ($ctr <= count($suborders));
	// glueパラメータが指定されていて、かつ最後の商品でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}

	// ブロック内の出力
	return $content;
}
?>
