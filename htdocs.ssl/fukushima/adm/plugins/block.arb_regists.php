<?php
function smarty_block_arb_regists($params, $content, &$smarty, &$repeat) {
	$regists = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_regist', 0);
		$smarty->assign('db_error', 0);
		// 新規記事の場合（記事新規作成ページ用）
		if ($smarty->getTemplateVars('new')) {
			$regist = array('id' => 0,
				'name' => '',
				'kana' => '',
				'cover' => '',
			);
			array_push($regists, $regist);
		}
		// 記事を読み込む場合
		else {
			// MDB2オブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');
			// テーブルの接頭語を得る
			$pfx = "arbeit_";
			// SQLを作成する
			$type = array();
			$data = array();
			$where = array();

			$sql = <<< HERE
SELECT * FROM ${pfx}regist

HERE;

			// 記事等のIDを読み込む
			$view_regist_id = $smarty->getTemplateVars('view_regist_id');
			$view_searchword = $smarty->getTemplateVars('view_searchword');

			// 読み込む記事を限定する場合
			if (!$params['all']) {
				// 記事のIDが指定されている場合
				if ($view_regist_id) {
					array_push($type, 'integer');
					array_push($data, $view_regist_id);
					array_push($where, "${pfx}regist.id = ?");
				} else if ($params['id']) {
					array_push($type, 'integer');
					array_push($data, $params['id']);
					array_push($where, "${pfx}regist.id = ?");
				}

/*				if ($params['regist']) {
array_push($type, 'integer');
array_push($data, 1);
array_push($where, "${pfx}regist.status >= ?");
}*/

				if ($view_searchword) {
					//日本語入力考慮し、全角スペースを半角にする
					$view_searchword = str_replace("　", " ", $view_searchword);
					//スペースで分解。
					$keywords = preg_split("/[ ]+/", $view_searchword);

					foreach ($keywords as $word) {
						$word = '%' . $word . '%';
						array_push($type, 'text', 'text', 'text');
						array_push($data, $word, $word, $word);
						array_push($where, "(${pfx}regist.name LIKE ? OR ${pfx}regist.kana LIKE ? OR ${pfx}regist.email LIKE ?)");
					}
				}

				if ($_SESSION['cmp_mode']) {
					if (!$params['view']) {
						array_push($type, 'integer');
						array_push($data, $smarty->getTemplateVars('auth_cmp_id'));
						array_push($where, "${pfx}regist.id = ?");
						array_push($type, 'integer');
						array_push($data, 1);
						array_push($where, "${pfx}regist.status = ?");
					}
				} else if ($_SESSION['admin_mode']) {
					if ($params['regist']) {
						array_push($type, 'integer');
						array_push($data, 1);
						array_push($where, "${pfx}regist.status >= ?");
					}
				} else {
					array_push($type, 'integer', 'integer');
					array_push($data, 1, -9);
					array_push($where, "(${pfx}regist.status = ? OR ${pfx}regist.status = ?)");
				}

			}

			// SQLにwhere句を連結する
			if (count($where)) {
				$sql .= ' WHERE ' . implode("\n AND ", $where) . "\n";
			}

//paging
			if (!$view_regist_id && !$params['id']) {
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
				$regist_count = $res->rowCount();

				$smarty->assign('regist_count', $regist_count);
				// ページ数を求める
				$per_page = intval($params['per_page']);
				if ($per_page <= 0) {
					$per_page = 10;
				}
				$page_count = intval(($regist_count - 1) / $per_page) + 1;
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
				$smarty->assign('first_entry_no', ($regist_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
				$smarty->assign('last_entry_no', ($cur_page == $page_count) ? $regist_count : $cur_page * $per_page);
			}
//end paging
			// order句を連結する
			//            $sql .= "order by date ";
			$sql .= "ORDER BY id ";
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

			// クエリを実行する
			try {
				$res = $pdo->prepare($sql);
				$res->execute($data);

			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				if (count($regists) == 0) {
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
			}
			// 記事を配列に読み込む
			while ($regist = $res->fetch()) {

				array_push($regists, $regist);
			}
			// 記事がない場合
			if (count($regists) == 0) {
				$smarty->assign('no_regist', 1);
				$repeat = false;
				return;
			}
		}
		// 記事をSmartyの変数に保存
		$smarty->assign('regists', $regists);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_regist', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$regists = $smarty->getTemplateVars('regists');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_regist');
	}

	// 個々の記事を読み込む
	$regist = $regists[$ctr];

	// レコードの各フィールドをSmartyの変数に設定する

	if (count($regist)) {

//電話番号の分割

		foreach (array('telephone', 'fax') as $k) {
			if ($regist[$k]) {
				$tmp = explode('-', $regist[$k]);
				foreach ($tmp as $i => $v) {
					$regist[$k . ($i + 1)] = $v;
				}
			}
		}
		$smarty->assign('regist', $regist);
	}

	$smarty->assign('regist_header', ($ctr == 0));
	$smarty->assign('regist_footer', ($ctr == count($regists) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の記事があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_regist', $ctr);
	$repeat = ($ctr <= count($regists));
	// glueパラメータが指定されていて、かつ最後の記事でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
