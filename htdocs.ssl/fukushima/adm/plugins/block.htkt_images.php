<?php
//require_once 'make_path.php';
function smarty_block_htkt_images($params, $content, &$smarty, &$repeat) {
	$images = array();
	$per_row = intval($params['per_row']);
	if ($per_row < 1) {
		$per_row = 1;
	}
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_image', 0);
		$smarty->assign('db_error', 0);
		// MDB2オブジェクトを得る
		$pdo = $smarty->getTemplateVars('pdo');
		// 記事をデータベースから読み込む
		$type = array();
		$data = array();
		$where = array();
		$sql = "select *,CONCAT(`filepath`,`filename`) AS file_name from htkt_image\n";
		$view_image_id = $smarty->getTemplateVars('view_image_id');
		$view_year = $smarty->getTemplateVars('view_year');
		$view_month = $smarty->getTemplateVars('view_month');
		if (!$params['all']) {
			if ($view_image_id) {
				array_push($type, 'integer');
				array_push($data, $view_image_id);
				array_push($where, "id = ?");
			} else if ($view_year && $view_month) {
				array_push($type, 'integer', 'integer');
				array_push($data, $view_year, $view_month);
				array_push($where, "year(date) = ?");
				array_push($where, "month(date) = ?");
			}
		}
		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

//paging
		if (!$view_image_id) {
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
			$image_count = $res->rowCount();

			$smarty->assign('image_count', $image_count);
			// ページ数を求める
			$per_page = intval($params['per_page']);
			if ($per_page <= 0) {
				$per_page = 10;
			}
			$page_count = intval(($image_count - 1) / $per_page) + 1;
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
			$smarty->assign('first_image_no', ($image_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_image_no', ($cur_page == $page_count) ? $image_count : $cur_page * $per_page);
		}
//end paging

		$sql .= "order by date ";
		$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
		$sql .= "\n";
		$per_page = $smarty->getTemplateVars('per_page');
		if ($params['all']) {
			$limit = intval($params['limit']);
			if ($limit < 1) {
				$limit = 5;
			}
			$sql .= "limit 0, " . $limit;
		} else if ($per_page) {
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
		// 画像を配列に読み込む
		while ($image = $res->fetch()) {
			array_push($images, $image);
		}
		// 画像がない場合
		if (count($images) == 0) {
			$smarty->assign('no_image', 1);
			$repeat = false;
			return;
		}

		// 画像をSmartyの変数に保存
		$smarty->assign('images', $images);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr', 0);
		// 繰り返しの回数を求める
		if ($per_row > 1) {
			$loop_count = (intval((count($images) - 1) / $per_row) + 1) * $per_row;
		} else {
			$loop_count = count($images);
		}
		$smarty->assign('loop_count', $loop_count);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した画像を読み出す
		$images = $smarty->getTemplateVars('images');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr');
		// 繰り返しの回数を読み出す
		$loop_count = $smarty->getTemplateVars('loop_count');
	}

	if ($ctr < count($images)) {
		// 個々の画像を読み込む
		$image = $images[$ctr];
		// レコードの各フィールドをSmartyの変数に設定する
		$smarty->assign('image', $image);
		$smarty->assign('image_null_cell', 0);
	} else {
		$smarty->assign('image_null_cell', 1);
	}
	$smarty->assign('image_header', ($ctr == 0));
	$smarty->assign('image_footer', ($ctr == $loop_count - 1));
	$smarty->assign('image_row_header', ($ctr % $per_row == 0));
	$smarty->assign('image_row_footer', ($ctr % $per_row == $per_row - 1));
	if ($per_row > 1) {
		$is_odd_row = !((($ctr - $ctr % $per_row) / $per_row) % 2);
	} else {
		$is_odd_row = ($ctr % 2 == 0);
	}
	$smarty->assign('is_odd_row', $is_odd_row);
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の画像があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr', $ctr);
	$repeat = ($ctr <= $loop_count);
	// glueパラメータが指定されていて、かつ最後の画像でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
