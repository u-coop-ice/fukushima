<?php
function smarty_block_sp_categories($params, $content, &$smarty, &$repeat) {
	$categories = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	$authority = $smarty->getTemplateVars('authority');
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_category', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if (!$params['all'] && $smarty->getTemplateVars('new_cat')) {
			// 並び順の最大値を求める
			try {
				$sql = "SELECT max(sort_order) as ct FROM sp_category";
				$res = &$pdo->query($sql);
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
				'ordermail' => '',
				'pressmail' => '',
				'description' => '',
				'sort_order' => $data['ct'] + 1);

			$category['method'] = array(
				'sex' => array('use' => 0)
				, 'number' => array('use' => 0)
				, 'membership' => array('use' => 0)
				, 'univ' => array('use' => 0)
				, 'schoolyear' => array('use' => 0)
				, 'department' => array('use' => 0)
				, 'major' => array('use' => 0)
				, 'new_add' => array('use' => 0)
				, 'address' => array('use' => 0)
				, 'student_phone' => array('use' => 0)
				, 'mobilephone' => array('use' => 0)
				, 'phonenumber' => array('use' => 0)
				, 'parent_name' => array('use' => 0)
				, 'bank' => array('use' => 0)
				, 'creditcard' => array('use' => 0)
				, 'memo' => array('use' => 0)
				, 'agree' => array('use' => 0),
			);

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
SELECT c.*,COUNT(sc.id) as child_count
 FROM sp_category AS c
 LEFT JOIN sp_subcategory AS sc ON c.id = sc.category_id

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
			}

			// 管理者モードでなければ
			// 非表示のカテゴリは出力しない
			if (!$_SESSION['admin_mode']) {
				if (!$params['ignore_visible']) {
					array_push($where, "c.visible = 1\n");
				}
			}

			// 管理者ユーザーの権限整理
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
			}
			// カテゴリーがない場合
			if (count($categories) == 0) {
				$smarty->assign('no_category', 1);
				$repeat = false;
				return;
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

//動作期限系取得

		if ($category['date_limit']) {
			if (time() > strtotime($category['date_limit'])) {
				$category['status'] = -9;
			} else if (time() <= strtotime($category['date_start'])) {
				$category['status'] = 0;
			} else {
				$category['status'] = 1;
			}
		}

		if (!$smarty->getTemplateVars('new_cat')) {
			$category['method'] = json_decode($category['method'], true);
		}
		$category["payment"] = json_decode($category["payment"], true);
		$category["opt_ship"] = json_decode($category["opt_ship"], true);

		$category["description"] = htmlspecialchars_decode($category["description"]);
		$category["low"] = htmlspecialchars_decode($category["low"]);

		$smarty->assign('category', $category);
	}

	//	$smarty->assign('category', $method);

	$smarty->assign('category_no_class', ($category['id'] == 1));
	$smarty->assign('category_header', ($ctr == 0));
	$smarty->assign('category_footer', ($ctr == count($categories) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける

	for ($ii = 1; $ii <= 3; $ii++) {
		$category['extra' . $ii . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($category['extra' . $ii . '_select']));
		$tmp = explode(",", $category['extra' . $ii . '_select']);
		array_unshift($tmp, '');
		$smarty->assign('extra' . $ii . 'List', $tmp);
	}

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
