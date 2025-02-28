<?php
function smarty_block_logs($params, $content, &$smarty, &$repeat) {
	$logs = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	$view_searchword = $smarty->getTemplateVars('view_search_word');
	$view_kind = $smarty->getTemplateVars('view_kind');
	$view_mode = $smarty->getTemplateVars('mode');

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_log', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）

		// カテゴリーをデータベースから読み込む
		$type = array();
		$data = array();
		$where = array();

		$tbl = 'admin_log';
		if ($params['log']) {
			$tbl = $params['log'];
		}

		$sql = <<< HERE
SELECT l.* FROM {$tbl} AS l

HERE;

		if ($tbl == 'stock_log') {
			$sql = <<< HERE
SELECT l.*,i.name AS item_name,i.no AS item_no FROM {$tbl} AS l
LEFT JOIN sp_item AS i ON i.id = l.item_id

HERE;
		}

		$sql4count = <<< HERE
SELECT COUNT(l.id) AS `ct` FROM {$tbl} AS l

HERE;

		if ($params['app_id']) {
			array_push($data, $params['app_id']);
			array_push($where, " l.app_id in (?) ");
		} else if ($params['item_id']) {
			array_push($data, $params['item_id']);
			array_push($where, " l.item_id in (?) ");
		}

		if ($params['process']) {
			array_push($type, 'text');
			array_push($data, $params['process']);
			array_push($where, " l.`process` = (?) ");
		}

		if ($params['before']) {
			array_push($where, " l.`date` > ( NOW() - INTERVAL 3 MONTH ) ");
		}

		if ($view_kind) {
			array_push($type, 'text');
			array_push($data, $view_kind);
			array_push($where, " l.`kind` = (?) ");
		}

		if ($view_searchword) {
			$view_searchword = trim($view_searchword);
			$view_searchword = preg_replace('/　/', ' ', $view_searchword);
			$view_searchword = mb_convert_kana($view_searchword, "a");
			$view_searchword = preg_replace('/\s+/', ' ', $view_searchword);
			$words = explode(' ', $view_searchword);
			foreach ($words as $word) {
				array_push($type, 'text');
				array_push($data, '%' . $word . '%');
				array_push($where, " (l.username LIKE ?) ");
			}
		}

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where) . " \n ";
			$sql4count .= " WHERE " . implode(' AND ', $where) . " \n ";

		}

//paging
		if (!isset($params['no_pager'])) {

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

			$log_count = $res->fetchColumn();

			$smarty->assign('log_count', $log_count);
			// ページ数を求める
			$per_page = intval($params['per_page']);
			if ($per_page <= 0) {
				$per_page = 10;
			}
			$page_count = intval(($log_count - 1) / $per_page) + 1;
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
			$smarty->assign('first_log_no', ($log_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_log_no', ($cur_page == $page_count) ? $log_count : $cur_page * $per_page);

//end paging

			if ($params['sort'] == 'ASC') {
				$sql .= " ORDER BY l.`date` ASC ";
			} else if ($params['sort'] == 'DESC') {
				$sql .= " ORDER BY l.`date` DESC ";
			}

			// 記事の出力件数を得る
			$per_page = $smarty->getTemplateVars('per_page');
			// 「all=1」のパラメータが指定されている場合は、
			// 「limit=○」のパラメータで読み込む件数を限定する
			if ($params['all']) {
				$limit = intval($params['limit']);
				if ($limit < 1) {
					$limit = 10;
				}
				// 変数$per_pageが定義されているときは、1ページ分の記事を読み込む
				if ($per_page) {
					$cur_page = $smarty->getTemplateVars('cur_page');
					$offset = ($cur_page - 1) * $per_page;
					$sql .= "LIMIT " . $offset . ", " . $per_page;
				} else {
					$sql .= "LIMIT 0, " . $limit;
				}
			}
		}

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
		while ($log = $res->fetch()) {
			array_push($logs, $log);
		}

		// カテゴリーがない場合
		if (count($logs) == 0) {
			$smarty->assign('no_log', 1);
			$repeat = false;
			return;
		} else {
			$smarty->assign('no_log', 0);
		}

		// カテゴリーをSmartyの変数に保存
		$smarty->assign('logs', $logs);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_log', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$logs = $smarty->getTemplateVars('logs');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_log');
	}

	// 個々のカテゴリーを読み込む
	$log = $logs[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する

	$log['ua'] = ua::getUA($log['user_agent']);
	$smarty->assign('log', $log);

	$smarty->assign('log_header', ($ctr == 0));
	$smarty->assign('log_footer', ($ctr == count($logs) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_log', $ctr);
	$repeat = ($ctr <= count($logs));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
