<?php
function smarty_block_items($params, $content, &$smarty, &$repeat) {

	$items = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_item', 0);
		$smarty->assign('db_error', 0);
		$smarty->assign('item_header', 0);
		$smarty->assign('item_footer', 0);

		// 新規商品の場合（商品登録ページ用）

		if ($smarty->getTemplateVars('new')) {
			$item = array('id' => 0,
				'name' => '',
				'furigana' => '',
				'maker' => '',
				'creator' => '',
				'date' => date('Y-m-d H:i:s'),
				'category_id' => '1',
				'category_name' => '未分類',
				'price' => 0,
				'description' => '',
				'image' => '',
				'width' => 0,
				'height' => 0,
				'visible' => 0);
			array_push($items, $item);
		}
		// カートの商品を表示する場合
		else if ($params['cart']) {
			// カートの商品を配列変数$itemsに代入
			$cart = HTTP_Session2::get('cart' . PART);
			$items = $cart['items'];
		}
		// 商品を読み込む場合
		else {
			// pdoオブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');
			// テーブルの接頭語を得る
			// SQLを作成する
			$type = array();
			$data = array();
			$where = array();
			$view_order_id = $smarty->getTemplateVars('view_order_id');
			// すべての商品を一覧表示する場合
			$sql = <<< HERE
SELECT i.*
,sk.onstock AS onstock
,sk.stock AS stock
,sk.composition_item_ids AS composition_item_ids
,sc.denomination as subcategory_denomination
,sc.limit_date as subcategory_limit_date
,sc.open_date as subcategory_open_date
,sc.sort_order as subcategory_sort_order
,sc.flag_drink as flag_drink
,s2c.limit_date as sub2category_limit_date
,s2c.denomination as sub2category_denomination
,c.denomination as category_denomination
,c.id as category_id
,c.part as category_part
 FROM sp_item AS i
 LEFT JOIN sp_item_stock AS sk ON sk.item_id = i.id
 LEFT JOIN sp_subcategory AS sc ON i.subcategory_id = sc.id
 LEFT JOIN sp_sub2category AS s2c ON s2c.id = i.sub2category_id
 LEFT JOIN sp_category AS c on sc.category_id = c.id

HERE;
			// 商品等のIDを読み込む
			$view_item_id = $smarty->getTemplateVars('view_item_id');
			$view_item_uuid = $smarty->getTemplateVars('view_item_uuid');
			$view_category_id = $smarty->getTemplateVars('view_category_id');
			$view_subcategory_id = $smarty->getTemplateVars('view_subcategory_id');
			$view_sub2category_id = $smarty->getTemplateVars('view_sub2category_id');
			$view_year = $smarty->getTemplateVars('view_year');
			$view_month = $smarty->getTemplateVars('view_month');
			$view_search_word = $smarty->getTemplateVars('view_search_word');

			$mode = $smarty->getTemplateVars('mode');

			// 読み込む商品を限定する場合
			if (!$params['all']) {
				// 大カテゴリの指定
				if ($params['part']) {
					array_push($where, "c.part = ? ");
					array_push($data, $params['part']);
				}
				// 商品のIDが指定されている場合
				if ($view_item_id) {
					array_push($data, $view_item_id);
					array_push($where, "i.id = ?");
				} else if ($view_item_uuid) {
					array_push($data, $view_item_uuid);
					array_push($where, "i.uuid = ?");

				}
				// カテゴリーが指定されている場合
				else if ($view_sub2category_id) {
					array_push($data, $view_sub2category_id);
					array_push($where, "i.sub2category_id = ?");
				} else if ($view_subcategory_id) {
					array_push($data, $view_subcategory_id);
					array_push($where, "i.subcategory_id = ?");
				} else if ($view_category_id) {
					array_push($data, $view_category_id);
					array_push($where, "sc.category_id = ?");
				}
				// 年と月が指定されている場合
				else if ($view_year && $view_month) {
					array_push($type, 'integer', 'integer');
					array_push($data, $view_year, $view_month);
					array_push($where, "year(i.date) = ?");
					array_push($where, "month(i.date) = ?");
				}

				if ($params['not_id']) {
					array_push($data, intval($params['not_id']));
					array_push($where, "i.id NOT IN (?)");
				}

				if ($params['not_set']) {
					array_push($where, "sk.composition_item_ids IS NULL");
				}

				if ($view_search_word) {
					$view_search_word = trim($view_search_word);
					$view_search_word = preg_replace('/　/', ' ', $view_search_word);
					$view_search_word = mb_convert_kana($view_search_word, "a");
					$view_search_word = preg_replace('/\s+/', ' ', $view_search_word);
					$words = explode(' ', $view_search_word);
					foreach ($words as $word) {
						array_push($type, 'text', 'text', 'text', 'text');
						array_push($data, '%' . $word . '%', '%' . $word . '%', '%' . $word . '%', '%' . $word . '%');
						array_push($where, "(i.name LIKE ? OR i.author LIKE ? OR i.content LIKE ? OR i.description LIKE ?)");
					}
				}

			}
			// 「show_all=1」のパラメータが指定されておらず、
			// かつ管理者モードでなければ
			// 非表示の商品は出力しない
			if (!$params['show_all']) {
				if ($mode != "show_order") {

					if (CURRENT == "app") {
						array_push($where, "i.visible = 1");
						array_push($where, "sc.visible = 1");
					}
				}
			}

			// SQLにwhere句を連結する
			if (count($where)) {
				$sql .= " WHERE " . implode("\nAND ", $where) . " \n ";
			}

			$sql .= "\n";
			$sql .= " GROUP BY i.id ";
			$sql .= "\n";

//paging
			$sql4count = $sql;

			// クエリを実行する
			try {
				$res = $pdo->prepare($sql4count);
				$res->execute($data);
			} catch (PDOException $e) {
				echo $e->getMessage();
				// データベースアクセスに失敗したらエラーとする
				if (count($items) == 0) {
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
			}

			$item_count = $res->rowCount();

			$smarty->assign('item_count', $item_count);
			// ページ数を求める
			$per_page = intval($params['per_page']);
			if ($per_page <= 0) {
				$per_page = 10;
			}
			$page_count = intval(($item_count - 1) / $per_page) + 1;
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
			$smarty->assign('first_item_no', ($item_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_item_no', ($cur_page == $page_count) ? $item_count : $cur_page * $per_page);

//end paging

			// order句を連結する
			if ($mode != "show_order") {
//	            $sql .= "order by item.`release` ";
				if ($params['part'] == "book") {
					$sql .= " ORDER BY i.`release` DESC,subcategory_sort_order ASC ";
				} else {
					$sql .= " ORDER BY subcategory_sort_order ASC, i.`release` DESC ";
				}
			}

			// 商品の出力件数を得る
			$per_page = $smarty->getTemplateVars('per_page');
			// 「all=1」のパラメータが指定されている場合は、
			// 「limit=○」のパラメータで読み込む件数を限定する
			if ($params['all']) {
				$limit = intval($params['limit']);
				if ($limit < 1) {
					$limit = 10;
				}
				$sql .= "LIMIT 0, " . $limit;
			}
			// 変数$per_pageが定義されているときは、1ページ分の商品を読み込む
			else if ($per_page) {
				$cur_page = $smarty->getTemplateVars('cur_page');
				$offset = ($cur_page - 1) * $per_page;
				$sql .= "LIMIT " . $offset . ", " . $per_page;
			}
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
			while ($item = $res->fetch()) {
				array_push($items, $item);
			}
		}
		// 商品がない場合
		if (count($items) == 0) {
			$smarty->assign('no_item', 1);
			$repeat = false;
			return;
		}
/*
// 各商品の小計と全体の合計を計算
$total_price = 0;
$flag_alc = 0; // 酒類選択フラッグ
for ($i = 0; $i < count($items); $i++) {
$item_total_price = $items[$i]['price'] * $items[$i]['num'];
$items[$i]['total_price'] = $item_total_price;
$total_price += $item_total_price;
if ($items[$i]['flag_drink']) {
$flag_alc = 1;
}
}
// 商品をSmartyの変数に保存
$smarty->assign('items', $items);
// 全体の合計をSmartyの変数に保存

$conf_cat_id = $smarty->getConfigVars('conf_cat_id');

//送料計算
$postage = 0;

if ($smarty->getTemplateVars('postage')) {
$postage = $smarty->getTemplateVars('postage');
$postage = intval($postage);
}

/*		$postages = array_column($items, 'postage');

$postage = 0;
if (count($postages)) {
if (max($postages) > 0) {
$postage = 800;
}
$smarty->assign('postage', $postage);
}
 */
		// 商品をSmartyの変数に保存
		$smarty->assign('items', $items);

//		$total_price_all = $total_price + $postage;
		//		$smarty->assign('total_price_all', $total_price_all);
		//		$smarty->assign('total_price', $total_price_all);
		// 酒類選択フラッグをSmartyの変数に保存
		$smarty->assign('flag_alc', $flag_alc);

		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した商品を読み出す
		$items = $smarty->getTemplateVars('items');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr');
	}

	// 個々の商品を読み込む
	$item = $items[$ctr];
	// レコードの各フィールドをSmartyの変数に設定する

//	$item["description"] = htmlspecialchars_decode($item["description"]);

	if (count($item)) {
		if ($item['limit_date'] && strtotime($item['limit_date']) < time()) {
			$item['closed'] = 1;
		} else if ($item['subcategory_limit_date'] && strtotime($item['subcategory_limit_date']) < time()) {
			$item['closed'] = 1;
		} else if (strtotime($item['subcategory_open_date']) > time()) {
			$item['closed'] = 1;
		} else if ($item['sub2category_limit_date'] && strtotime($item['sub2category_limit_date']) < time()) {
			$item['closed'] = 1;
		} else {
			$item['closed'] = null;
		}

		if ($item['composition_item_ids'] && is_string($item['composition_item_ids'])) {
			$item['composition_item_ids'] = json_decode($item['composition_item_ids'], true);
		} else {
			$item['composition_item_ids'] = [];
		}

		$smarty->assign('item', $item);
	}

	$smarty->assign('item_has_category', 1);

/*
for ($ii = 1; $ii <= 3; $ii++) {
$item['extra' . $ii . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($item['extra' . $ii . '_select']));
$tmp = explode(",", $item['extra' . $ii . '_select']);
array_unshift($tmp, '');
$smarty->assign('extra' . $ii . 'List', $tmp);

$item['cart' . $ii . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($item['cart' . $ii . '_select']));
$tmp = explode(",", $item['cart' . $ii . '_select']);
array_unshift($tmp, '');
$smarty->assign('cart' . $ii . 'List', $tmp);

}
 */

	$smarty->assign('item_header', ($ctr == 0));
	if ($ctr == count($items) - 1) {
		$smarty->assign('item_footer', 1);
	}
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の商品があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr', $ctr);
	$smarty->assign('index', $ctr - 1);
	$repeat = ($ctr <= count($items));
	// glueパラメータが指定されていて、かつ最後の商品でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}

	// ブロック内の出力
	return $content;
}
?>
