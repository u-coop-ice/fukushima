<?php
function smarty_block_sp_sub2categories($params, $content, &$smarty, &$repeat) {
	$sub2categories = [];
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	$authority = $smarty->getTemplateVars('authority');
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_sub2category', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if (!$params['all'] && $smarty->getTemplateVars('new_s2cat')) {
			// 並び順の最大値を求める
			$sql = "SELECT MAX(sort_order) as ct FROM sp_sub2category";
			try {
				$res = $pdo->query($sql);
			} catch (Exception $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// カテゴリーのデータを初期化する
			$data = $res->fetch();
			$sub2category = array('id' => 0,
				'denomination' => '',
				'description' => '',
				'sort_order' => $data['ct'] + 1);
			array_push($sub2categories, $sub2category);
			$ctr = 0;

		}
		// カテゴリーを読み込む場合
		else {

			$view_subcategory_id = $smarty->getTemplateVars('view_subcategory_id');
			$view_sub2category_id = $smarty->getTemplateVars('view_sub2category_id');

			// カテゴリーをデータベースから読み込む

			$where = array();
			$data = array();
			$where = array();

			$sql = <<< HERE
SELECT sc2.*, count(i.id) as entry_count
,sc.denomination as subcategory_denomination
,sc.limit_date as subcategory_limit_date
,sc.open_date as subcategory_open_date
,sc.visible as subcategory_visible
,c.denomination as category_denomination
,c.id as category_id

FROM sp_sub2category AS sc2
LEFT JOIN sp_subcategory AS sc ON sc2.subcategory_id = sc.id
LEFT JOIN sp_item AS i ON sc2.id = i.sub2category_id
LEFT JOIN sp_category AS c ON sc.category_id = c.id

HERE;

			if ($params['subcategory_id']) {
				array_push($data, $params['subcategory_id']);
				array_push($where, "sc.id = ? \n");
			} else if ($view_subcategory_id) {
				array_push($data, $view_subcategory_id);
				array_push($where, "sc.id = ? \n");
			} else if ($params['id']) {
				array_push($data, $params['id']);
				array_push($where, "sc2.id in (?)\n");
			} else if ($view_sub2category_id) {
				array_push($data, $view_sub2category_id);
				array_push($where, "sc2.id = ? \n");
			}
			if ($params['not_id']) {
				array_push($data, $params['not_id']);
				array_push($where, "sc2.id not in (?)\n");
			}

			// 管理者モードでなければ
			// 非表示のサブカテゴリは出力しない
			if (CURRENT == "app") {
				array_push($data, 1);
				array_push($where, "i.visible = ? \n");
				array_push($data, 1);
				array_push($where, "sc2.visible = ?\n");
				// 管理者ユーザーの権限整理
			} else if (CURRENT == "adm") {
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
							}

						} else {
							$smarty->assign('no_category', 1);
							$repeat = false;
							return;
						}
					}
				}
			}

			if (count($where)) {
				$sql .= " WHERE " . implode(" and ", $where) . "\n";
			}

			$sql .= <<< HERE
GROUP BY sc2.id
ORDER BY sc2.sort_order

HERE;

			try {
				$res = $pdo->prepare($sql);
				$res->execute($data);

			} catch (Exception $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}

			// カテゴリーを配列に読み込む
			while ($sub2category = $res->fetch()) {
				array_push($sub2categories, $sub2category);
			}
			// テンプレートで「no_class_first="1"」のパラメータが指定されているときは
			// 未分類カテゴリーを先頭にする
			if ($params['no_class_first']) {
				array_unshift($sub2categories, $no_class_cat);
			}
			// テンプレートで「no_class_last="1"」のパラメータが指定されているときは
			// 未分類カテゴリーを最後にする
			if ($params['no_class_last']) {
				array_push($sub2categories, $no_class_cat);
			}
			// カテゴリーがない場合
			if (count($sub2categories) == 0) {
				$smarty->assign('no_sub2category', 1);
				$repeat = false;
				return;
			} else {
				$smarty->assign('no_sub2category', 0);
			}
			// カテゴリーをSmartyの変数に保存
			$smarty->assign('sub2categories', $sub2categories);
			// カウンタを初期化
			$ctr = 0;
			$smarty->assign('sub2_ctr', 0);
		}
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$sub2categories = $smarty->getTemplateVars('sub2categories');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('sub2_ctr');
	}

	// 個々のカテゴリーを読み込む
	$sub2category = $sub2categories[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する
	/*
	if ($sub2category['limit_date']) {
		$smarty->assign('sub2category_order', (strtotime($sub2category['limit_date']) > time()));
	} else {
		$smarty->assign('sub2category_order', 1);
	}
*/

	if (strtotime($sub2category['subcategory_limit_date']) > time()) {

		if (strtotime($sub2category['subcategory_open_date']) > time()) {
			$sub2category['state'] = 0;
		} else {
			if (strtotime($sub2category['limit_date']) > time()) {
				$sub2category['state'] = 1;
				$sub2category['end'] = $sub2category['limit_date'];
			} else {
				$sub2category['state'] = 9;
				$sub2category['end'] = $sub2category['limit_date'];
			}
		}
	} else {
		$sub2category['state'] = 9;
		$sub2category['end'] = $sub2category['subcategory_limit_date'];
	}

	if (!$sub2category['visible']) {
		$sub2category['state'] = -9;
	} else if (!$sub2category['subcategory_visible']) {
		$sub2category['state'] = -9;
	}

	$smarty->assign('sub2category', $sub2category);

	$smarty->assign('sub2category_no_class', ($sub2category['id'] == 1));
	$smarty->assign('sub2category_header', ($ctr == 0));
	$smarty->assign('sub2category_footer', ($ctr == count($sub2categories) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('sub2_ctr', $ctr);
	$repeat = ($ctr <= count($sub2categories));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
