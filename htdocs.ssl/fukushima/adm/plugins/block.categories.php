<?php
function smarty_block_categories($params, $content, &$smarty, &$repeat) {
	$categories = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	$pdo_repl = $smarty->getTemplateVars('pdo_repl');
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
				$sql = "SELECT max(sort_order) AS ct FROM entry_category";
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
				, 'graduateyear' => array('use' => 0)
				, 'dept' => array('use' => 0)
				, 'age' => array('use' => 0)
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

			if ($smarty->getTemplateVars('view_search_word')) {
				$view_search_word = $smarty->getTemplateVars('view_search_word');
			}

			if ($smarty->getTemplateVars('view_archived')) {
				$view_archived = intval($smarty->getTemplateVars('view_archived'));
			}

			// カテゴリーをデータベースから読み込む
			$type = array();
			$data = array();
			$where = array();
			$sql = <<< HERE
SELECT c.*, count(a.id) as entry_count
 FROM entry_category AS c LEFT JOIN app AS a
 ON c.id = a.category_id

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

				if ($params['no_archived']) {
					array_push($data, 0);
					array_push($where, "IFNULL(c.archived,0) = ?");
				}

			} else {

				if ($view_archived) {
				} else {
					array_push($data, 0);
					array_push($where, "IFNULL(c.archived,0) = ?");
				}

			}

			if ($_SESSION['admin_mode']) {
				if ($authority["master"]["master"] == 0) {
					switch ($params['component']) {
					case 'entry':
					case 'reserve':
						if (is_array($authority[$params['component']]["category_id"])) {
							$ors = array();
							foreach ($authority[$params['component']]["category_id"] as $ac) {
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
						break;
					default:

						if (!$authority[$params['component']]['show']) {
							$smarty->assign('no_category', 1);

							$repeat = false;
							return;
						}
					}
				}

			}

			// 検索
			if ($view_search_word) {
				//日本語入力考慮し、全角スペースを半角にする
				$view_search_word = str_replace('　', ' ', $view_search_word);
				//スペースで分解。
				$keywords = preg_split('/[ ]+/', $view_search_word);

				foreach ($keywords as $word) {
					$word = '%' . $word . '%';
					array_push($data, $word, $word, $word);
					$or = " c.denomination LIKE ? OR c.description LIKE ? OR c.description_web LIKE ?";
					array_push($where, '(' . $or . ')');
				}
			}

			if (!$_SESSION['admin_mode']) {
				array_push($data, COMPONENT);
				array_push($where, "c.component = ?");
			} else {
				if ($params['component']) {
					array_push($data, $params['component']);
					array_push($where, "c.component = ?");
				}
			}

			if (count($where)) {
				$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
			}

			$sql .= <<< HERE
GROUP BY c.id
ORDER BY c.sort_order

HERE;

			if ($params['all']) {

//paging
				$sql4count = $sql;

				// クエリを実行する
				try {
					$res = $pdo_repl->prepare($sql4count);
					$res->execute($data);
				} catch (PDOException $e) {
					// データベースアクセスに失敗したらエラーとする
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
				$category_count = $res->rowCount();
				$smarty->assign('category_count', $category_count);
				// ページ数を求める
				$per_page = intval($params['per_page']);
				if ($per_page <= 0) {
					$per_page = 10;
				}
				$page_count = intval(($category_count - 1) / $per_page) + 1;
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
				$smarty->assign('first_category_no', ($category_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
				$smarty->assign('last_category_no', ($cur_page == $page_count) ? $category_count : $cur_page * $per_page);

//end paging
			}

			// 記事の出力件数を得る
			$per_page = $smarty->getTemplateVars('per_page');
			// 「all=1」のパラメータが指定されている場合は、
			// 「limit=○」のパラメータで読み込む件数を限定する
			if ($per_page) {
				$cur_page = $smarty->getTemplateVars('cur_page');
				$offset = ($cur_page - 1) * $per_page;
				$sql .= "limit " . $offset . ", " . $per_page;
			}

			try {
				$res = $pdo_repl->prepare($sql);
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

		/*

			if (!$smarty->getTemplateVars('new_cat')) {
				$category['method'] = json_decode($category['method'], true);
				$category['stock_multi'] = json_decode($category['stock_multi'], true);
			}

			if ($category['js']) {
				$category['js'] = stripcslashes($category['js']);
			}

			if ($category['description_web']) {
				$category['description_web'] = stripslashes($category['description_web']);
			}

			if ($category['description_web']) {
				$category['description_web'] = stripslashes($category['description_web']);
			}

			if ($category['description_closed']) {
				$category['description_closed'] = stripslashes($category['description_closed']);
			}
		*/
		$smarty->assign('category', $category);
	}

	//	$smarty->assign('category', $method);

	$smarty->assign('category_no_class', ($category['id'] == 1));
	$smarty->assign('category_header', ($ctr == 0));
	$smarty->assign('category_footer', ($ctr == count($categories) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける

/*
for ($ii = 1; $ii <= 3; $ii++) {
$category['extra' . $ii . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($category['extra' . $ii . '_select']));
$tmp = explode(",", $category['extra' . $ii . '_select']);
array_unshift($tmp, '');
$smarty->assign('extra' . $ii . 'List', $tmp);
}
 */

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
