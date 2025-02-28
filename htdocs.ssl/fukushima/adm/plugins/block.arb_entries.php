<?php
function smarty_block_arb_entries($params, $content, &$smarty, &$repeat) {
	$entries = array();
	// ブロックに入る前の処理

	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_entry', 0);
		$smarty->assign('db_error', 0);

		$pfx = "arbeit_";
		$tbl = $pfx . "entry";
		if ($params['view']) {

			if ($_SESSION['admin_mode'] && $smarty->getTemplateVars('view_entry_code')) {

			} else {
				$tbl .= "_view";
			}
		}

		if (!$params['list'] && $smarty->getTemplateVars('new')) {
			$entry = array('id' => 0,
			);
			array_push($entries, $entry);
		} else {

			// PDOオブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');
			$pdo_repl = $smarty->getTemplateVars('pdo_repl');
			// テーブルの接頭語を得る

			$view_regist_id = $smarty->getTemplateVars('view_regist_id');
			$view_category_id = $smarty->getTemplateVars('view_category_id');
			if ($view_category_id) {
				$view_category_id = intval($view_category_id);
			}
			$auth_arbeit_id = $smarty->getTemplateVars('auth_arbeit_id');

			if (CURRENT == 'cmp') {
				if (!$auth_arbeit_id) {
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
			}

			// SQLを作成する
			$type = array();
			$data = array();
			$where = array();

			if ($params['list']) {

				$sql = <<< HERE
SELECT COUNT(j.id) AS ct FROM ${tbl} AS j LEFT JOIN ${pfx}regist
ON ${pfx}regist.id = j.regist_id
LEFT JOIN ${pfx}entry_status on j.id = ${pfx}entry_status.id

HERE;

				if ($params['else']) {
					array_push($where, "${pfx}entry_status.status > 1");
				} else if ($params['ready']) {
					array_push($where, "IFNULL(${pfx}entry_status.status,0) = 0");
				} else if ($params['draft']) {
					array_push($where, "${pfx}entry_status.status = -9");
				} else if ($params['visible']) {
//					array_push($where, "${pfx}entry.term1 < NOW() and ${pfx}entry.term2 > NOW()");
					//					array_push($where, "${pfx}entry_status.status = 1");
					array_push($where, "(
						(j.term1 < NOW() AND j.term2 > NOW() - interval 1 day AND ${pfx}entry_status.status = 1) OR (${pfx}entry_status.status = -1 AND j.term1 < NOW()))");
				} else if ($params['before']) {
					array_push($where, "j.term1 > NOW()");
					array_push($where, "${pfx}entry_status.status = 1");
				} else if ($params['expiry']) {
					array_push($where, "j.term2 < NOW() - interval 1 day");
					array_push($where, "${pfx}entry_status.status = 1");
				}

				if ($_SESSION['admin_mode']) {
					array_push($where, "IFNULL(${pfx}entry_status.status,0) <> -9");
				}

				if ($_SESSION['arbeit_mode']) {
					if (!$auth_arbeit_id) {return;}
					array_push($where, "${pfx}regist.id = ?");
					array_push($data, $auth_arbeit_id);
				}

				array_push($where, "${pfx}entry_status.trashed IS NULL");

				if (count($where)) {
					$sql .= ' WHERE ' . implode(" \n AND ", $where) . "\n";
				}

			} else {

				$sql = <<< HERE
SELECT j.*,IFNULL(${pfx}entry_status.status,0) as status
,IFNULL(${pfx}entry_status.paid,0) as paid
,IFNULL(${pfx}entry_status.status_payment,0) as status_payment
,${pfx}entry_status.fee as fee
,${pfx}entry_status.date_paid as date_paid
,${pfx}entry_status.mailed as mailed
,${pfx}entry_status.mailed_date as mailed_date
,IFNULL(${pfx}regist.status,0) as status_regist
,${pfx}regist.cmp_name as regist_cmp_name
 FROM ${tbl} as j LEFT JOIN ${pfx}regist
 ON ${pfx}regist.id = j.regist_id
 LEFT JOIN ${pfx}entry_status ON j.id = ${pfx}entry_status.id

HERE;

				// 記事等のIDを読み込む

				$view_entry_id = $smarty->getTemplateVars('view_entry_id');
				$view_entry_code = $smarty->getTemplateVars('view_entry_code');
				$view_search_word = $smarty->getTemplateVars('view_search_word');
				$view_all = $smarty->getTemplateVars('view_all');
				$view_visible = $smarty->getTemplateVars('view_visible');
				$view_expiry = $smarty->getTemplateVars('view_expiry');
				$view_ready = $smarty->getTemplateVars('view_ready');
				$view_else = $smarty->getTemplateVars('view_else');
				$view_before = $smarty->getTemplateVars('view_before');
				$view_draft = $smarty->getTemplateVars('view_draft');

				$view_fee = $smarty->getTemplateVars('view_fee');

				$view_range_term2 = $smarty->getTemplateVars('view_range_term2');
				$view_range_term1 = $smarty->getTemplateVars('view_range_term1');

				if ($_SESSION['admin_mode']) {
					$view_status_payment = $smarty->getTemplateVars('view_status_payment');
				}

				// 読み込む記事を限定する場合
				if (!$params['all'] && !$view_all) {
					// 記事のIDが指定されている場合
					if ($view_entry_id) {
						array_push($type, 'integer');
						array_push($data, $view_entry_id);
						array_push($where, "j.id = ?");
					} else if ($view_entry_code) {
						array_push($type, 'text');
						array_push($data, $view_entry_code);
						array_push($where, "j.code = ?");
					} else if ($view_else) {
						array_push($where, "${pfx}entry_status.status > 1");
					} else if ($view_ready) {
						array_push($where, "IFNULL(${pfx}entry_status.status,0) = 0");
					} else if ($view_draft) {
						array_push($type, 'integer');
						array_push($where, "${pfx}entry_status.status = -9");
					} else if ($view_visible) {
						array_push($where, "(
						(j.term1 < NOW() AND j.term2 > NOW() - interval 1 day AND ${pfx}entry_status.status = 1) OR (${pfx}entry_status.status = -1 AND j.term1 < NOW()))");
					} else if ($view_before) {
						array_push($where, "j.term1 > NOW()");
						array_push($where, "${pfx}entry_status.status = 1");
					} else if ($view_expiry) {
						array_push($where, "j.term2 < NOW() - interval 1 day");
						array_push($where, "${pfx}entry_status.status = 1");
					} else if (is_numeric($view_status_payment)) {
						array_push($type, 'integer');
						array_push($data, $view_status_payment);
						array_push($where, "IFNULL(${pfx}entry_status.status_payment,0) = ?");
					}

				}

				if (is_numeric($view_fee)) {
					array_push($type, 'integer');
					array_push($data, $view_fee);
					array_push($where, "${pfx}entry_status.fee = ?");
				}

				if ($view_range_term1) {
					array_push($data, $view_range_term1);
					array_push($where, "j.term1 >= ?");
				}

				if ($view_range_term2) {
					array_push($data, $view_range_term2);
					array_push($where, "j.term1 - INTERVAL 1 DAY < ?");
				}

				if ($_SESSION['admin_mode']) {
					array_push($where, "IFNULL(${pfx}entry_status.status,0) <> -9");
				}

				if (!$params['view']) {
					if ($_SESSION['arbeit_mode']) {
						if (!$auth_arbeit_id) {
							$smarty->assign('db_error', 1);
							$repeat = false;
							return;}
						array_push($where, "${pfx}regist.id = ?");
						array_push($data, $auth_arbeit_id);
					} else if ($view_regist_id) {
						array_push($type, 'integer');
						array_push($data, $view_regist_id);
						array_push($where, "${pfx}regist.id = ?");
					}
				}
				// 検索関連
				if ($view_search_word) {
					//日本語入力考慮し、全角スペースを半角にする
					$view_search_word = str_replace("　", " ", $view_search_word);
					//スペースで分解。
					$keywords = preg_split("/[ ]+/", $view_search_word);

					foreach ($keywords as $word) {
						$word = '%' . $word . '%';
						array_push($type, 'text', 'text', 'text', 'text', 'text');
						array_push($data, $word, $word, $word, $word, $word);
						array_push($where, "(j.title LIKE ? OR j.work LIKE ? OR j.length LIKE ? OR ${pfx}regist.cmp_name LIKE ? OR ${pfx}regist.cmp_kana LIKE ? )");
					}

				}

				if ($view_category_id) {
					array_push($where, "JSON_CONTAINS(j.`category_id`,?,'$.category_id')");
					array_push($data, $view_category_id);
				}

				array_push($where, "${pfx}entry_status.trashed IS NULL");

				// SQLにwhere句を連結する
				if (count($where)) {
					$sql .= ' where ' . implode(" \n and ", $where) . "\n";
				}

				$sql .= "GROUP BY j.id\n";

//paging
				if (!$view_entry_id && !$view_entry_code) {
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
				if (CURRENT == "app") {
					$sql .= "order by j.term1 DESC,j.id DESC";
//					$sql .= 'desc';
					$sql .= "\n";
				} else if ($_SESSION['admin_mode']) {
					$sql .= "order by j.id ";
					$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
					$sql .= "\n";
				} else if ($_SESSION['arbeit_mode']) {
					$sql .= "order by j.id ";
					$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
					$sql .= "\n";
				} else {
					$sql .= "order by j.term1 ";
					$sql .= 'desc';
					$sql .= "\n";
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
			}
//			if ($_SESSION['admin_mode']) {
			//	echo $sql;
			//			}
			// クエリを実行する
			try {
				$res = $pdo_repl->prepare($sql);
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
	/*
		$pdo = $smarty->getTemplateVars('pdo');
		$pfx = "arbeit_";

		$sql2 = <<< HERE
		SELECT ${pfx}entry_area.* FROM ${pfx}entry_area
		WHERE `entry_id` = ?

	HERE;

		// クエリを実行する

		try {
			$res2 = $pdo->prepare($sql2);
			$res2->execute(array($entry['id']));

		} catch (PDOException $e) {

			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('db_error', 1);
			return;
		}
		// 記事を配列に読み込む
		$tmp_entry_areas = array();
		while ($tmp_entry_area = $res2->fetch()) {
			array_push($tmp_entry_areas, $tmp_entry_area['area_id']);
		}
		$entry['area'] = $tmp_entry_areas;

		//	print_r($tmp_entry_areas);
*/
	//公開非公開

	$term1 = strtotime($entry['term1']);
	$term2 = strtotime($entry['term2']);

	$entry['status'] = intval($entry['status']);
	if (time() < $term1) {
		$entry['visible'] = 0;
	} else if (($entry['status'] == 1 && time() >= $term1) && (time() < $term2 + 24 * 60 * 60) || ($entry['status'] == -1 && time() >= $term1)) {
		$entry['visible'] = 1;
	} else {
		$entry['visible'] = 2;
	}

	$entry['work'] = htmlspecialchars_decode($entry['work']);
	$entry['connection'] = htmlspecialchars_decode($entry['connection']);

	if ($entry['category_id']) {
		$entry['category_id'] = json_decode($entry['category_id'], true);
	}

	if (count($entry)) {
		$smarty->assign('entry', $entry);
	}

//    $smarty->assign('entry_ct', $entry['entry_count']);
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
