<?php
function smarty_block_regists($params, $content, &$smarty, &$repeat) {
	$regists = array();
	// ブロックに入る前の処理

	if (!$_SESSION['admin_mode']) {
		if ($smarty->getTemplateVars('view_regist_id')) {
			$smarty->assign('new', 1);
		} else if (!$smarty->getTemplateVars('auth_user_id')) {
			$smarty->assign('db_error', 1);
			$repeat = false;
			return;
		}
	}

	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_regist', 0);
		$smarty->assign('db_error', 0);
		// 新規記事の場合（記事新規作成ページ用）
		if ($smarty->getTemplateVars('new')) {
			$regist = array('id' => 0,
				'namef' => '',
				'nameg' => '',
			);
			array_push($regists, $regist);
		}
		// 記事を読み込む場合
		else {

			// pdoオブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');

			$view_status = intval($smarty->getTemplateVars('view_status'));
			$view_dm = intval($smarty->getTemplateVars('view_dm'));

			$condition = [];
			if ($view_status) {
				$condition['status'] = $view_status;
			}
			if ($view_dm) {
				$condition['dm'] = 1;
			}

			// SQLを作成する
			$sq = new adminRegistDB;
			$sq->set_params($params);
			$sq->set_mgdata($condition);

//paging
			$sq->set_flag_count(1);
			$regist_count = $sq->getRegists();

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
			$smarty->assign('first_regist_no', ($regist_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_regist_no', ($cur_page == $page_count) ? $regist_count : $cur_page * $per_page);

			$per_page = $smarty->getTemplateVars('per_page');

//end paging

			$sq->set_block(1);
			$sq->set_cur_page($cur_page);

			$regists = $sq->getRegists();
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

	if (count($regist) > 2) {

//生年月日分割

		if ($regist['birthday']) {
			$regist['birth_year'] = substr($regist['birthday'], 0, 4);
			$regist['birth_month'] = intval(substr($regist['birthday'], 4, 2));
			$regist['birth_day'] = intval(substr($regist['birthday'], -2));
		}

//電話番号分割
		$phone = array('mobilephone', 'parent_mobile', 'student_phone', 'parent_com_phone', 'phonenumber');

		foreach ($phone as $key) {
			$temp = array();
			if ($regist[$key]) {
				$temp = explode("-", $regist[$key]);
				if (count($temp)) {
					foreach ($temp as $i => $ii) {
						$regist[$key . ($i + 1)] = $ii;
					}
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
