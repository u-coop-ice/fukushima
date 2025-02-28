<?php
function smarty_block_arb_pages($params, $content, &$smarty, &$repeat) {
	$pages = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_page', 0);
		$smarty->assign('db_error', 0);

// PDOオブジェクトを得る
		$pdo = $smarty->getTemplateVars('pdo');
		// テーブルの接頭語を得る
		global $pfx;

		$view_regist_id = $smarty->getTemplateVars('view_page_id');

		// SQLを作成する
		$type = array();
		$data = array();
		$where = array();

		if ($params['list']) {

			$sql = <<< HERE
select count(${pfx}page.id) as ct,${pfx}page.status as status from ${pfx}page

HERE;

			if (count($where)) {
				$sql .= ' where ' . implode(" \n and ", $where) . "\n";
			}

		} else {

			$sql = <<< HERE
SELECT page.* FROM ${pfx}page AS page

HERE;

			// 記事等のIDを読み込む

			$view_page_id = $smarty->getTemplateVars('view_page_id');
			$view_page_code = $smarty->getTemplateVars('view_page_code');
			$view_search_word = $smarty->getTemplateVars('view_search_word');

			// 読み込む記事を限定する場合
			if (!$params['all']) {
				// 記事のIDが指定されている場合
				if ($view_page_id) {
					array_push($data, $view_page_id);
					array_push($where, "page.id = ?");
				} else if ($view_page_code) {
					array_push($data, $view_page_code);
					array_push($where, "page.code = ?");
				}
				// 検索関連
				if ($view_search_word) {
					//日本語入力考慮し、全角スペースを半角にする
					$view_search_word = str_replace("　", " ", $view_search_word);
					//スペースで分解。
					$keywords = preg_split("/[ ]+/", $view_search_word);

					foreach ($keywords as $word) {
						$word = '%' . $word . '%';
						array_push($data, $word, $word);
						array_push($where, "(page.content LIKE ? || page.title LIKE ?)");
					}

				}

			}

			// SQLにwhere句を連結する
			if (count($where)) {
				$sql .= ' WHERE ' . implode(" \n AND ", $where) . "\n";
			}

//paging
			if (!$view_page_id && !$view_page_code) {
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
				$page_count = $res->rowCount();

				$smarty->assign('page_count', $page_count);
				// ページ数を求める
				$per_page = intval($params['per_page']);
				if ($per_page <= 0) {
					$per_page = 10;
				}
				$page_count = intval(($page_count - 1) / $per_page) + 1;
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
				$smarty->assign('first_page_no', ($page_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
				$smarty->assign('last_page_no', ($cur_page == $page_count) ? $page_count : $cur_page * $per_page);
			}
//end paging

			// order句を連結する
			//            $sql .= "order by date ";
			$sql .= "ORDER BY page.id ";
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
				$sql .= "limit 0, " . $limit;
			}
			// 変数$per_pageが定義されているときは、1ページ分の記事を読み込む
			else if ($per_page) {
				$cur_page = $smarty->getTemplateVars('cur_page');
				$offset = ($cur_page - 1) * $per_page;
				$sql .= "limit " . $offset . ", " . $per_page;
			}
		}

		// クエリを実行する
		try {
			$res = $pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			if (count($pages) == 0) {
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
		}
		// 記事を配列に読み込む
		while ($page = $res->fetch()) {
			array_push($pages, $page);
		}
		// 記事がない場合
		if (count($pages) == 0) {
			$smarty->assign('no_page', 1);
			$repeat = false;
			return;
		}

		// 記事をSmartyの変数に保存
		$smarty->assign('pages', $pages);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_page', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$pages = $smarty->getTemplateVars('pages');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_page');
	}

	// 個々の記事を読み込む
	$page = $pages[$ctr];

	// レコードの各フィールドをSmartyの変数に設定する

	if (count($page)) {

		$page['content_decode'] = htmlspecialchars_decode($page['content']);
		$smarty->assign('page', $page);
	}

//    $smarty->assign('page_ct', $page['page_count']);
	$smarty->assign('page_header', ($ctr == 0));
	$smarty->assign('page_footer', ($ctr == count($pages) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の記事があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_page', $ctr);
	$repeat = ($ctr <= count($pages));
	// glueパラメータが指定されていて、かつ最後の記事でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
