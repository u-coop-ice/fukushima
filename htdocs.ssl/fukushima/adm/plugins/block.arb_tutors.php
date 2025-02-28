<?php
function smarty_block_arb_tutors($params, $content, &$smarty, &$repeat) {
	$tutors = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_tutor', 0);
		$smarty->assign('db_error', 0);

		$pfx = "arbeit_";
		$tbl = $pfx . "tutor";
		if ($params['view']) {
			$tbl .= "_view";
		}

		// 新規記事の場合（記事新規作成ページ用）
		if (!$params['list'] && $smarty->getTemplateVars('new')) {
			$tutor = array('id' => 0,
				'name' => '',
				'kana' => '',
				'cover' => '',
			);
			array_push($tutors, $tutor);
		}
		// 記事を読み込む場合
		else {
			// MDB2オブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');
			// テーブルの接頭語を得る

			$mode = $smarty->getTemplateVars('mode');
			$dayList = $smarty->getTemplateVars('dayList');
			$sexList = $smarty->getTemplateVars('sexList');

			// SQLを作成する
			$type = array();
			$data = array();
			$where = array();

			// 記事等のIDを読み込む
			$view_tutor_code = $smarty->getTemplateVars('view_tutor_code');

			// 読み込む記事を限定する場合
			if ($params['list']) {

				$sql = <<< HERE
SELECT COUNT(t.id) as ct FROM ${tbl} AS t
LEFT JOIN ${pfx}tutor_status AS s ON t.id = s.id
HERE;

				if ($params['else']) {
					array_push($where, "s.status > 1");
				} else if ($params['ready']) {
					array_push($where, "s.status = 0");
				} else if ($params['visible']) {
					array_push($where, "(
						(t.term1 < NOW() AND t.term2 > NOW() - interval 1 day AND s.status = 1) OR (s.status = -1 AND t.term1 < NOW()))");
				} else if ($params['before']) {
					array_push($where, "t.term1 > NOW()");
					array_push($where, "s.status <= 1");
				} else if ($params['expiry']) {
					array_push($where, "t.term2 < NOW() - interval 1 day");
					array_push($where, "s.status = 1");
				}

			} else {

				$view_all = $smarty->getTemplateVars('view_all');
				$view_visible = $smarty->getTemplateVars('view_visible');
				$view_expiry = $smarty->getTemplateVars('view_expiry');
				$view_ready = $smarty->getTemplateVars('view_ready');
				$view_else = $smarty->getTemplateVars('view_else');
				$view_before = $smarty->getTemplateVars('view_before');

				$sql = <<< HERE
SELECT t.*,s.status as status

FROM ${tbl} AS t JOIN ${pfx}tutor_status AS s ON t.id = s.id

HERE;

				// 記事のIDが指定されている場合
				if ($view_tutor_code) {
					array_push($type, 'integer');
					array_push($data, $view_tutor_code);
					array_push($where, "t.code = ?");
				} else if ($params['id']) {
					array_push($type, 'integer');
					array_push($data, $params['id']);
					array_push($where, "t.id = ?");
				} else if ($view_else) {
					array_push($where, "s.status > 1");
				} else if ($view_ready) {
					array_push($where, "s.status = 0");
				} else if ($view_visible) {
					array_push($where, "(
						(t.term1 < NOW() AND t.term2 > NOW() - interval 1 day AND s.status = 1) OR (s.status = -1 AND t.term1 < NOW()))");
				} else if ($view_before) {
					array_push($where, "t.term1 > NOW()");
					array_push($where, "s.status <= 1");
				} else if ($view_expiry) {
					array_push($where, "t.term2 < NOW() - interval 1 day");
					array_push($where, "s.status = 1");
				}
			}

			// SQLにwhere句を連結する
			if (count($where)) {
				$sql .= ' WHERE ' . implode("\n AND ", $where) . "\n";
			}

//paging
			if (!$view_tutor_code && !$params['id']) {
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
				$tutor_count = $res->rowCount();

				$smarty->assign('tutor_count', $tutor_count);
				// ページ数を求める
				$per_page = intval($params['per_page']);
				if ($per_page <= 0) {
					$per_page = 10;
				}
				$page_count = intval(($tutor_count - 1) / $per_page) + 1;
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
				$smarty->assign('first_tutor_no', ($tutor_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
				$smarty->assign('last_tutor_no', ($cur_page == $page_count) ? $tutor_count : $cur_page * $per_page);
			}
//end paging
			// order句を連結する
			//            $sql .= "order by date ";
			$sql .= " ORDER BY t.id ";
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
				if (count($tutors) == 0) {
					$smarty->assign('db_error', 1);
					$repeat = false;
					return;
				}
			}
			// 記事を配列に読み込む
			$tutors = $res->fetchAll();
			// 記事がない場合
			if (count($tutors) == 0) {
				$smarty->assign('no_tutor', 1);
				$repeat = false;
				return;
			}
		}
		// 記事をSmartyの変数に保存
		$smarty->assign('tutors', $tutors);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_tutor', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$tutors = $smarty->getTemplateVars('tutors');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_tutor');
	}

	// 個々の記事を読み込む
	$tutor = $tutors[$ctr];

	// レコードの各フィールドをSmartyの変数に設定する

	if (count($tutor)) {
		foreach ($tutor as $key => $value) {
			if ($key == 'work_day' || $key == 'student_sex' || $key == 'student_subject') {
				$tutor[$key] = json_decode($value, true);
			}
		}

		if ($tutor['work_day']) {
			$tmp = array();
			foreach ($tutor['work_day'] as $d) {
				array_push($tmp, $dayList[$d]);
			}
			$tutor['work_days'] = implode("・", $tmp);
		} else {
			$tutor['work_days'] = null;
		}

		$departmentList = $smarty->getTemplateVars('departmentList');

		if ($tutor['student_subject']) {
			$tmp = array();
			foreach ($tutor['student_subject'] as $d) {

				array_push($tmp, $departmentList[$d]);
			}
			$tutor['student_subjects'] = implode("・", $tmp);
		} else {
			$tutor['student_subjects'] = null;
		}

		if ($tutor['student_sex']) {
			$tmp = array();
			foreach ($tutor['student_sex'] as $d) {
				array_push($tmp, $sexList[$d]);
			}
			$tutor['student_sexes'] = implode("・", $tmp);
		} else {
			$tutor['student_sexes'] = null;
		}

		$tmp = array();

		if ($tutor['interview']) {
			array_push($tmp, $tutor['interview']);
		}
		if ($tutor['exam']) {
			array_push($tmp, $tutor['exam']);
		}
		if ($tutor['adopt_misc']) {
			array_push($tmp, tutor['adopt_misc']);
		}
		if (count($tmp)) {
			$tutor['adopts'] = implode("・", $tmp);
		}

//電話番号の分割

		foreach (array('telephone', 'fax') as $k) {
			if ($tutor[$k]) {
				$tmp = explode('-', $tutor[$k]);
				foreach ($tmp as $i => $v) {
					$tutor[$k . ($i + 1)] = $v;
				}
			}
		}

//公開非公開

		$term1 = strtotime($tutor['term1']);
		$term2 = strtotime($tutor['term2']);

		if (time() < $term1) {
			$tutor['visible'] = 0;
		} else if ((time() >= $term1) && (time() < $term2)) {
			$tutor['visible'] = 1;
		} else {
			$tutor['visible'] = 2;
		}

		$smarty->assign('tutor_header', ($ctr == 0));
		$smarty->assign('tutor_footer', ($ctr == count($tutors) - 1));
		$smarty->assign('is_odd', ($ctr % 2 == 0));
		// 次の記事があれば繰り返しを続け、なければ繰り返しから抜ける
		$ctr++;
		$smarty->assign('ctr_tutor', $ctr);
		$repeat = ($ctr <= count($tutors));
		// glueパラメータが指定されていて、かつ最後の記事でなければ、
		// 出力の後にglueパラメータの文字を追加する
		if ($repeat && $params['glue']) {
			$content .= $params['glue'];
		}

		$smarty->assign('tutor', $tutor);
	}

	// ブロック内の出力
	return $content;
}
?>
