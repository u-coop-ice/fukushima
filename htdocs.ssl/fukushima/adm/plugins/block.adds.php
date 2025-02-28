<?php
function smarty_block_adds($params, $content, &$smarty, &$repeat) {
	$adds = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	if (!$_SESSION['admin_mode']) {
		$view_app_id = $smarty->getTemplateVars('view_reserve_id');
	}

	$view_add_id = $smarty->getTemplateVars('view_add_id');
	$view_add_ic = $smarty->getTemplateVars('view_add_ic');
	$view_root_id = $smarty->getTemplateVars('view_root_id');
	$view_noreply = $smarty->getTemplateVars('view_noreply');
	$mode = $smarty->getTemplateVars('mode');
	$view_search_word = $smarty->getTemplateVars('view_search_word');
	$view_category_id = $smarty->getTemplateVars('view_category_id');
	$view_no_category = $smarty->getTemplateVars('view_no_category');

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_add', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）

		// 追加情報をデータベースから読み込む
		$type = array();
		$data = array();
		$where = array();

		$sql4count = <<< HERE
SELECT COUNT(app_add.id) AS ct
	FROM app_add
 LEFT JOIN regist ON app_add.regist_id = regist.id
 LEFT JOIN app ON app_add.app_id = app.id

HERE;

		$sql = <<< HERE
SELECT app_add.*
,regist.namef as namef,regist.nameg as nameg
,regist.email as email
,regist.username as username
,regist.status as user_status
,app.component as app_component
,app.code as app_code
	FROM app_add
 LEFT JOIN regist ON app_add.regist_id = regist.id
 LEFT JOIN app ON app_add.app_id = app.id

HERE;

		if ($view_app_id) {
			array_push($type, 'integer');
			array_push($data, $view_app_id);
			array_push($where, "app_add.app_id in (?) ");
		} else if ($params['app_id']) {
			array_push($type, 'integer');
			array_push($data, $params['app_id']);
			array_push($where, "app_add.app_id in (?) ");
		}

		if ($params['add']) {
			array_push($type, 'text');
			array_push($data, $params['add']);
			array_push($where, "app_add.add in (?) ");
		}
		if ($params['app']) {
			array_push($type, 'text');
			array_push($data, $params['app']);
			array_push($where, "app.component in (?) ");
		}
		if ($params['regist_id']) {
			array_push($type, 'integer');
			array_push($data, $params['regist_id']);
			array_push($where, "app_add.regist_id in (?) ");
		}
		if ($params['send']) {
			array_push($type, 'integer');
			array_push($data, $params['send']);
			array_push($where, "app_add.send in (?) ");
		} else if ($params['recieve']) {
			array_push($type, 'integer');
			array_push($data, $params['recieve']);
			array_push($where, "app_add.recieve in (?) ");
		}
		if ($view_add_id) {
			array_push($type, 'integer');
			array_push($data, $view_add_id);
			array_push($where, "app_add.id in (?) ");
		} else if ($view_add_ic) {
			array_push($type, 'integer');
			array_push($data, $view_add_ic);
			array_push($where, "app_add.code in (?) ");
		} else if ($view_root_id) {
			array_push($type, 'integer', 'integer');
			array_push($data, $view_root_id, $view_root_id);
			array_push($where, " (app_add.root_id in (?) || app_add.id in (?) )");
		}

		if ($view_category_id) {
			array_push($data, intval($view_category_id));
			array_push($where, "app_add.category_id in (?) ");
		} else if ($view_no_category) {
			array_push($where, "IFNULL(app_add.category_id,0) = 0 ");

		}

		if (is_array($view_noreply)) {
			$noreply2List = array(1 => array(0, 1), 2 => array(2, 3), 3 => array(9));
			$sub_where = array();

			foreach ($view_noreply as $noreply) {
				foreach ($noreply2List[$noreply] as $v) {
					array_push($data, $v);
					array_push($sub_where, " IFNULL(app_add.noreply,0) in (?) ");
				}
			}

			if (count($sub_where)) {
				array_push($where, " ( " . implode(" OR ", $sub_where) . " ) ");
			}
		}

		// 検索の場合
		if ($view_search_word) {
			//日本語入力考慮し、全角スペースを半角にする
			$view_search_word = str_replace("　", " ", $view_search_word);
			//スペースで分解。
			$keywords = preg_split("/[ ]+/", $view_search_word);

			foreach ($keywords as $word) {
				$word = '%' . $word . '%';
				array_push($type, 'text', 'text', 'text', 'text');
				array_push($data, $word, $word, $word, $word);
				array_push($where, "(regist.namef LIKE ? OR regist.nameg LIKE ? OR regist.kanaf LIKE ? OR regist.kanag LIKE ?)");
			}
		}

		if ($params['manual']) {
			array_push($where, "IFNULL(app_add.auto_send,0) = 0 ");
			array_push($where, "app_add.add not in (?) ");
			array_push($data, "magazine");
		}

		if (CURRENT == "app") {
			if (!$params['regist_id']) {
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}

			array_push($data, intval($params['regist_id']));
			array_push($where, "app_add.regist_id in (?) ");

			array_push($where, "app_add.regist_date > (NOW() - INTERVAL 2 YEAR) ");

		}

		if (count($where)) {
			$sql .= " WHERE " . implode(" AND\n", $where) . "";
			$sql4count .= " WHERE " . implode(" AND\n", $where) . "";
		}

		if (COMPONENT == "ask" || COMPONENT == "user") {

//paging

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
			$add_counts = $res->fetch();
			$add_count = $add_counts['ct'];
			$smarty->assign('add_count', $add_count);
			// ページ数を求める
			$per_page = intval($params['per_page']);
			if ($per_page <= 0) {
				$per_page = 10;
			}
			$page_count = intval(($add_count - 1) / $per_page) + 1;

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
			$smarty->assign('first_add_no', ($add_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_add_no', ($cur_page == $page_count) ? $add_count : $cur_page * $per_page);

//end paging

		}

		if ($mode == "show_mail" || $mode == "show_reserve" || $mode == "show_app") {
			$sql .= <<< HERE
ORDER BY app_add.id ASC

HERE;
		} else {
			$sql .= <<< HERE

ORDER BY app_add.regist_date DESC

HERE;

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
			$sql .= "limit 0, " . $limit;
		}
		// 変数$per_pageが定義されているときは、1ページ分の記事を読み込む
		else if ($per_page) {
			$cur_page = $smarty->getTemplateVars('cur_page');
			$offset = ($cur_page - 1) * $per_page;
			$sql .= "limit " . $offset . ", " . $per_page;
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
		while ($add = $res->fetch()) {
			array_push($adds, $add);
		}

		// カテゴリーがない場合
		if (count($adds) == 0) {
			$smarty->assign('no_add', 1);
			$repeat = false;
			return;
		} else {
			$smarty->assign('no_add', 0);
		}

		// カテゴリーをSmartyの変数に保存
		$smarty->assign('adds', $adds);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_add', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$adds = $smarty->getTemplateVars('adds');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_add');
	}

	// 個々のカテゴリーを読み込む
	$add = $adds[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する
	if (count($add)) {
		if ($add['purpose']) {
			$add['purpose'] = implode('/', json_decode($add['purpose'], true));
		}
		$smarty->assign('add', $add);
	}
	$smarty->assign('add_header', ($ctr == 0));
	$smarty->assign('add_footer', ($ctr == count($adds) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_add', $ctr);
	$repeat = ($ctr <= count($adds));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
