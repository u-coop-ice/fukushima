<?php
function smarty_block_apps($params, $content, &$smarty, &$repeat) {
	$apps = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_app', 0);
		$smarty->assign('db_error', 0);
		// 新規記事の場合（記事新規作成ページ用）
		// pdoオブジェクトを得る
		$pdo = $smarty->getTemplateVars('pdo');
		$pdo_repl = $smarty->getTemplateVars('pdo_repl');
		// テーブルの接頭語を得る
		$auth1 = $smarty->getTemplateVars('auth1');

		// SQLを作成する
		$type = array();
		$data = array();
		$where = array();
		$sql = <<< HERE
SELECT a.*
,r.username as username
,r.namef as namef
,r.nameg as nameg
,r.email as email
,r.`status` as regist_status
,r.univ_id as univ_id
,r.dept as dept
,regist_export.date as regist_date_export

 FROM app AS a LEFT JOIN regist AS r
 ON a.regist_id = r.id
	LEFT JOIN regist_export
 ON r.id = regist_export.id

HERE;

		// 記事等のIDを読み込む
		$view_app_id = $smarty->getTemplateVars('view_app_id');
		$view_app_ic = $smarty->getTemplateVars('view_app_ic');

		$view_univ_id = $smarty->getTemplateVars('view_univ_id');
		$view_category_id = $smarty->getTemplateVars('view_category_id');

		$view_year = $smarty->getTemplateVars('view_year');
		$view_month = $smarty->getTemplateVars('view_month');
		$view_day = $smarty->getTemplateVars('view_day');
		$view_time = $smarty->getTemplateVars('view_time');

		$view_search_word = $smarty->getTemplateVars('view_search_word');
		$view_stock_multi = $smarty->getTemplateVars('view_stock_multi');

		$view_archived = $smarty->getTemplateVars('view_archived');

		// 読み込む記事を限定する場合
		if (!$params['all']) {
			// 記事のIDが指定されている場合

			if (!$_SESSION['admin_mode']) {
				array_push($data, $smarty->getTemplateVars('auth_id'));
				array_push($where, "r.id = ?");
				if (!$smarty->getTemplateVars('auth_id')) {
					$smarty->assign('page_title', 'エラー');
					$smarty->assign('errmsg', '不正なアクセスです。');
					$smarty->display('error.tpl');
					exit();
				}

				array_push($where, "IFNULL(a.status,0) > -1");

			} else {
				if ($view_regist_id) {
					array_push($type, 'integer');
					array_push($data, $view_regist_id);
					array_push($where, "r.id = ?");
				} elseif ($params["rid"]) {
					array_push($type, 'integer');
					array_push($data, $params["rid"]);
					array_push($where, "r.id = ?");
				}
			}

			if ($view_app_id) {
				array_push($type, 'integer');
				array_push($data, $view_app_id);
				array_push($where, "a.id = ?");
			} elseif ($params["app_id"]) {
				array_push($type, 'integer');
				array_push($data, $params["app_id"]);
				array_push($where, "a.id = ?");
			} elseif ($view_app_ic) {
				array_push($type, 'text');
				array_push($data, $view_app_ic);
				array_push($where, "a.code = ?");
			}

			if ($view_category_id) {
				array_push($type, 'integer');
				array_push($data, $view_category_id);
				array_push($where, "a.category_id = ?");
			}

			if ($view_univ_id) {
				array_push($type, 'integer');
				array_push($data, $view_univ_id);
				array_push($where, "r.univ_id = ?");
			}
			if ($view_app) {
				array_push($type, 'text');
				array_push($data, $view_app);
				array_push($where, "a.app = ?");
			} else if ($params['app']) {
				array_push($type, 'text');
				array_push($data, addslashes($params['app']));
				array_push($where, "a.component = ?");
			}

			// 年と月が指定されている場合
			if ($view_year && $view_month && $view_day) {
				array_push($type, 'integer', 'integer', 'integer');
				array_push($data, $view_year, $view_month, $view_day);
				array_push($where, "YEAR(a.comedate) = ?");
				array_push($where, "MONTH(a.comedate) = ?");
				array_push($where, "DAY(a.comedate) = ?");
			}
			// 年と月が指定されている場合
			if ($view_time) {
				array_push($type, 'text');
				array_push($data, $view_time);
				array_push($where, "a.cometime = ?");
			}

			// 検索
			if ($view_search_word) {
				//日本語入力考慮し、全角スペースを半角にする
				$view_search_word = str_replace('　', ' ', $view_search_word);
				//スペースで分解。
				$keywords = preg_split('/[ ]+/', $view_search_word);

				foreach ($keywords as $word) {
					$num = intval($word);
					$word = '%' . $word . '%';
					array_push($data, $word, $word, $word, $word, $word);
					array_push($type, 'text', 'text', 'text', 'text', 'text');
					$or = "r.email LIKE ? OR r.namef LIKE ? OR r.nameg LIKE ? OR r.kanaf LIKE ? OR r.kanag LIKE ?";
					if ($num > 0) {
						array_push($data, $num);
						array_push($type, 'integer');
						$or .= " OR a.app_count = ?";
					}

					array_push($where, '(' . $or . ')');
				}
			}

			if ($_SESSION['admin_mode']) {
				if (defined("COMPONENT")) {
					if (COMPONENT != "ask" && COMPONENT != "ajax") {
						array_push($data, COMPONENT);
						array_push($where, "a.component = ?");
					}
				}
				if (!$view_archived) {
					array_push($data, 0);
					array_push($where, "IFNULL(a.archived,0) = ?");
				}

			}

//2年前までの履歴を表示
			if (!$_SESSION['admin_mode']) {
				array_push($where, "DATE_SUB(CURDATE(),INTERVAL 2 YEAR) < a.regist_date");
			}

		}

		// SQLにwhere句を連結する
		if (count($where)) {
			$sql .= " where " . implode(" and ", $where) . "\n";
		}

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
		$app_count = $res->rowCount();
		$smarty->assign('app_count', $app_count);
		// ページ数を求める
		$per_page = intval($params['per_page']);
		if ($per_page <= 0) {
			$per_page = 10;
		}
		$page_count = intval(($app_count - 1) / $per_page) + 1;
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
		$smarty->assign('first_app_no', ($app_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
		$smarty->assign('last_app_no', ($cur_page == $page_count) ? $app_count : $cur_page * $per_page);

//end paging

		// order句を連結する
		//            $sql .= "order by date ";
		$sql .= "ORDER BY a.regist_date ";
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
			$res = $pdo_repl->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('db_error', 1);
			$repeat = false;
			return;
		}
		// 記事を配列に読み込む
		while ($app = $res->fetch()) {
			array_push($apps, $app);
		}
		// 記事がない場合
		if (!$apps[0]["id"]) {
			$smarty->assign('no_app', 1);
			$repeat = false;
			return;
		}
		// 記事をSmartyの変数に保存
		$smarty->assign('apps', $apps);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_app', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$apps = $smarty->getTemplateVars('apps');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_app');
	}

	// 個々の記事を読み込む
	$app = $apps[$ctr];
	// レコードの各フィールドをSmartyの変数に設定する

	if (count($app)) {

		if ($app['extra']) {
			$app['extra'] = json_decode($app['extra'], true);
		}
		$smarty->assign('app', $app);
	}

	if ($view_app_id || $view_app_ic) {
		if ($app['component'] != 'shopping') {
			$methods = json_decode($app['methods'], true);
			$method = array();

			if (count($methods)) {
				$smarty->assign("methods", $methods); //項目のテンプレート発行

				foreach ($methods as $key => $value) {
					if ($key != 'extra') {
						if (is_array($value)) {
							if ($value['use']) {
								$method[$key] = $value['sort'];
							}
						}
					} else {
						foreach ($value as $k => $v) {
							if ($v['use']) {
								$method[$key . $k] = $v['sort'];
							}
						}
					}
				}
			}
			asort($method);
			$smarty->assign('method', $method);

			while (list($key, $value) = each($method)) {

				if (preg_match('/^extra/', $key)) {
					$k = intval(substr($key, 5));
					$extras[$key]['k'] = $k;

//				$smarty->assign('k', $k);

					if ($methods['extra'][$k]['select']) {

						$select = trim($methods['extra'][$k]['select']);
						$select = preg_replace('/\n|\r\n/', "\n", $select);

//					$extraList[$k] = explode("\n", $select);
						$extras[$key]['list'] = explode("\n", $select);
					}
				}
			}

			$smarty->assign('extras', $extras);

/*
$ff = new setDB();
$ff->set_methods($methods);
$notes = $ff->get_notes();
$smarty->assign('notes', $notes);
 */
		}
	}

	$smarty->assign('app_header', ($ctr == 0));
	$smarty->assign('app_footer', ($ctr == count($apps) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));

	// 次の記事があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_app', $ctr);
	$repeat = ($ctr <= count($apps));
	// glueパラメータが指定されていて、かつ最後の記事でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
