<?php
function smarty_block_arb_categories($params, $content, &$smarty, &$repeat) {

	if ($params['visible']) {
		if (is_array($_SESSION['arbeitCategoryList'])) {
			$smarty->assign("arbeitCategoryList", $_SESSION['arbeitCategoryList']);
			$repeat = false;
			return;
		}
	}

	$categories = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_category', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if (!$params['all'] && $smarty->getTemplateVars('new_cat')) {
			// 並び順の最大値を求める
			try {
				$sql = "SELECT max(sort_order) as ct FROM arbeit_category";
				$res = $pdo->query($sql);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// カテゴリーのデータを初期化する
			$data = $res->fetch();
			$category = array('id' => 0,
				'denomination' => '',
				'description' => '',
				'sort_order' => $data['ct'] + 1);

			array_push($categories, $category);
		}
		// カテゴリーを読み込む場合
		else {

			if ($smarty->getTemplateVars('view_category_id')) {
				$view_category_id = intval($smarty->getTemplateVars('view_category_id'));
			}
			// カテゴリーをデータベースから読み込む
			$type = array();
			$data = array();
			$where = array();
			$sql = <<< HERE
SELECT c.* FROM arbeit_category AS c

HERE;

			if (!$params['all']) {
				if ($params['id']) {
					array_push($type, 'integer');
					array_push($data, $params['id']);
					array_push($where, "c.id in (?)\n");
				} else if ($view_category_id) {
					array_push($type, 'integer');
					array_push($data, $view_category_id);
					array_push($where, "c.id in (?)\n");
				} else if ($params['not_id']) {
					array_push($type, 'integer');
					array_push($data, $params['not_id']);
					array_push($where, "c.id not in (?)\n");
				}

				if ($params['visible']) {
					array_push($data, 1);
					array_push($where, "c.visible in (?)\n");
				}

			}

			// 管理者モードでなければ
			// 非表示のカテゴリは出力しない
			if (!$_SESSION['admin_mode']) {
				if (!$params['ignore_visible']) {
					array_push($where, "c.visible = 1\n");
				}
			}

			if (count($where)) {
				$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
			}

			$sql .= <<< HERE
GROUP BY c.id
ORDER BY c.sort_order

HERE;

			try {
				$res = $pdo->prepare($sql);
				$res->execute($data);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;

			}
			// カテゴリーを配列に読み込む
			while ($category = $res->fetch()) {
				array_push($categories, $category);
				if ($category['visible'] == 1) {
					$arbeitCategoryList[$category['id']] = $category['denomination'];
				}
			}
			// カテゴリーがない場合
			if (count($categories) == 0) {
				$smarty->assign('no_category', 1);
				$repeat = false;
				return;
			}

			if (count($arbeitCategoryList)) {
				$_SESSION['arbeitCategoryList'] = $arbeitCategoryList;
				$smarty->assign("arbeitCategoryList", $_SESSION['arbeitCategoryList']);
			}
		}

		// カテゴリーをSmartyの変数に保存
		$smarty->assign('categories', $categories);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_cat', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$categories = $smarty->getTemplateVars('categories');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_cat');
	}
	// 個々のカテゴリーを読み込む
	$category = $categories[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する

	if (count($category) > 2) {

		$category["description"] = htmlspecialchars_decode($category["description"]);

		$smarty->assign('category', $category);
	}

	//	$smarty->assign('category', $method);

	$smarty->assign('category_header', ($ctr == 0));
	$smarty->assign('category_footer', ($ctr == count($categories) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける

	$ctr++;
	$smarty->assign('ctr_cat', $ctr);
	$repeat = ($ctr <= count($categories));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
