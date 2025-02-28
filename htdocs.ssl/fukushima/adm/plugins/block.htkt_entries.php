<?php
function smarty_block_htkt_entries($params, $content, &$smarty, &$repeat) {
	$entries = array();
	// ブロックに入る前の処理

	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_entry', 0);
		$smarty->assign('db_error', 0);
		// 新規記事の場合（記事新規作成ページ用）
		if ($smarty->getTemplateVars('new')) {
			$entry = array('id' => 0,
				'namef' => '',
				'nameg' => '',
			);
			array_push($entries, $entry);
		}
		// 記事を読み込む場合
		else {

			// pdoオブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');

			// SQLを作成する

			$data = array();
			$where = array();
			$type = array();
			$sql = <<< HERE
SELECT e.*,
c.denomination AS category_denomination,
c.color AS category_color
 FROM htkt_entry AS e
LEFT JOIN htkt_category as c ON e.category_id = c.id
HERE;
			// 記事等のIDを読み込む
			$view_entry_id = $smarty->getTemplateVars('view_entry_id');
			$view_app_ic = $smarty->getTemplateVars('view_app_ic');

			$view_category_id = $smarty->getTemplateVars('view_category_id');

			$view_year = $smarty->getTemplateVars('view_year');
			$view_month = $smarty->getTemplateVars('view_month');
			$view_searchword = $smarty->getTemplateVars('view_searchword');

			// 読み込む記事を限定する場合
			if (!$params['all']) {
				// 記事のIDが指定されている場合
				if ($view_entry_id) {
					array_push($type, 'integer');
					array_push($data, $view_entry_id);
					array_push($where, "e.id = ?");
				} else if ($params['ic']) {
					array_push($type, 'integer');
					array_push($data, addslashes($params['ic']));
					array_push($where, "e.code = ?");
				} else if ($view_app_ic) {
					array_push($type, 'text');
					array_push($data, addslashes($view_app_ic));
					array_push($where, "e.code = ?");
				} else if ($view_category_id) {
					array_push($type, 'integer');
					array_push($data, $view_category_id);
					array_push($where, "e.category_id = ?");
				}
				// 年と月が指定されている場合
				if ($view_year) {
					array_push($type, 'integer');
					array_push($data, $view_year, $view_month);
					array_push($where, "year(e.regist_date) = ?");
					array_push($where, "month(e.regist_date) = ?");
				}

				if ($view_searchword) {
					$or = array();
					$view_searchword = trim($view_searchword);
					$view_searchword = preg_replace('/　/', ' ', $view_searchword);
					$view_searchword = mb_convert_kana($view_searchword, "a");
					$view_searchword = preg_replace('/\s+/', ' ', $view_searchword);
					$words = explode(' ', $view_searchword);
					foreach ($words as $word) {
						array_push($data, '%' . $word . '%', '%' . $word . '%', '%' . $word . '%');
						array_push($or, "e.title LIKE ? OR e.text LIKE ? OR e.text_return LIKE ?");

						if (count($or)) {
							array_push($where, "(" . implode(" OR ", $or) . ") ");
						}

					}

				}

			}

			if (!$_SESSION['admin_mode'] || CURRENT == "app") {

				if (COMPONENT == "user" && $smarty->getTemplateVars('auth_id')) {
					array_push($type, 'integer');
					array_push($data, $smarty->getTemplateVars('auth_id'));
					array_push($where, "e.`regist_id` = ?");
				} else {
					array_push($type, 'integer');
					array_push($data, 1);
					array_push($where, "e.`publish` = ?");
				}
			}

			// SQLにwhere句を連結する
			if (count($where)) {
				$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
			}

//paging
			if (!$view_entry_id && !$view_entry_code) {
				$sql4count = $sql;

				// クエリを実行する
				try {
					$res = $pdo->prepare($sql4count);
					$res->execute($data);

				} catch (PDOException $e) {
					// データベースアクセスに失敗したらエラーとする
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
				// 記事を配列に読み込む
				$entry_count = $res->rowCount();

				$smarty->assign('entry_count', $entry_count);
				// ページ数を求める
				$per_page = intval($params['per_page']);
				if ($per_page <= 0) {
					$per_page = 10;
				}
				$page_count = intval(($entry_count - 1) / $per_page) + 1;
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
				$smarty->assign('first_entry_no', ($entry_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
				$smarty->assign('last_entry_no', ($cur_page == $page_count) ? $entry_count : $cur_page * $per_page);
			}
//end paging

			// order句を連結する
			$sql .= " ORDER BY e.regist_date ";
			$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
			$sql .= "\n";

			// 記事の出力件数を得る
			$per_page = $smarty->getTemplateVars('per_page');
			// 「all=1」のパラメータが指定されている場合は、
			// 「limit=○」のパラメータで読み込む件数を限定する
			if ($params['all']) {
				$limit = intval($params['limit']);
				if ($limit < 1) {
					$limit = 10;
				}
				$sql .= " limit 0, " . $limit;
			}
			// 変数$per_pageが定義されているときは、1ページ分の記事を読み込む
			else if ($per_page) {
				$cur_page = $smarty->getTemplateVars('cur_page');
				$offset = ($cur_page - 1) * $per_page;
				$sql .= " limit " . $offset . ", " . $per_page;
			}

			try {
				// クエリを実行する
				$res = $pdo->prepare($sql);
				$res->execute($data);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				if (count($entries) == 0) {
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
			}
			// 記事を配列に読み込む
			while ($entry = $res->fetch()) {
				array_push($entries, $entry);
			}
			// 記事がない場合
			if (count($entries) == 0) {
				$smarty->assign('no_entry', 1);
				$repeat = false;
				return;
			}

		}

		// 記事をSmartyの変数に保存
		$smarty->assign('entries', $entries);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_entry', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$entries = $smarty->getTemplateVars('entries');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_entry');
	}

	// 個々の記事を読み込む
	$entry = $entries[$ctr];
	// レコードの各フィールドをSmartyの変数に設定する

	if (count($entry) > 2) {

		if ($entry['arranged']) {
			$entry['text_edit'] = htmlspecialchars_decode($entry['text_edit']);
		}

		$smarty->assign('entry', $entry);
	}

	$smarty->assign('entry_header', ($ctr == 0));
	$smarty->assign('entry_footer', ($ctr == count($entries) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の記事があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_entry', $ctr);
	$repeat = ($ctr <= count($entries));
	// glueパラメータが指定されていて、かつ最後の記事でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
