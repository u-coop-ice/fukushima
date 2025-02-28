<?php
function smarty_block_magazines($params, $content, &$smarty, &$repeat) {
	$magazines = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_magazine', 0);
		$smarty->assign('db_error', 0);
		// 新規メルマガ記事の場合（商品登録ページ用）
		if ($smarty->getTemplateVars('new_magazine')) {
			$magazine = array('id' => 0,
				'group_id' => '',
				'magsubject' => '',
				'magbodys' => '',
				'update' => '',
				'testtrans' => '',
				'transmission' => '',
				'transnum' => '0',
				'translog' => '0',
				'magviewbit' => '',
			);
			array_push($magazines, $magazine);
		}
		// アドレスを読み込む場合
		else {
			// pdoオブジェクトを得る
			$pdo = $smarty->getTemplateVars('pdo');
			// テーブルの接頭語を得る
			// SQLを作成する
			$type = array();
			$data = array();
			$where = array();
			// すべてのメルマガを一覧表示する場合

			$sql = <<< HERE
SELECT mm.*,mg.denomination as group_denomination,
mg.signature as group_signature,
mg.unsubscribe as group_unsubscribe
FROM mail_magazine AS mm LEFT JOIN mail_group AS mg ON mm.group_id = mg.id

HERE;

			$sql4count = <<< HERE
SELECT COUNT(mm.id) AS ct
FROM mail_magazine AS mm LEFT JOIN mail_group AS mg ON mm.group_id = mg.id

HERE;

			// メルマガのIDなどを読み込む
			$view_magazine_id = $smarty->getTemplateVars('view_magazine_id');
			$view_group_id = $smarty->getTemplateVars('view_group_id');
			$view_status = $smarty->getTemplateVars('view_status');
			$view_searchword = $smarty->getTemplateVars('view_searchword');
			$view_onetime = $smarty->getTemplateVars('view_onetime');

			// 読み込むメルマガを限定する場合
			if (!$params['all']) {
				// IDが指定されている場合
				if ($view_magazine_id) {
					array_push($type, 'integer');
					array_push($data, $view_magazine_id);
					array_push($where, "mm.id = ?");
				}
				// グループが指定されている場合
				else if ($view_group_id) {
					array_push($type, 'integer');
					array_push($data, $view_group_id);
					array_push($where, "mm.group_id = ?");
				}
				if ($view_status == 'sent') {
					array_push($where, "mm.sent = 1");
				} else if ($view_status == 'draft') {
					array_push($where, "mm.draft = 1");
				} else if ($view_status == 'reserved') {
					array_push($where, "mm.onreserve = 1");
				}

				if ($view_onetime == 1) {
					array_push($where, "mm.onetime = 1");
				}

				// 検索の場合
				if ($view_searchword) {

					//日本語入力考慮し、全角スペースを半角にする
					$view_searchword = str_replace("　", " ", $view_searchword);
					//スペースで分解。
					$keywords = preg_split("/[ ]+/", $view_searchword);

					foreach ($keywords as $word) {
						$word = '%' . $word . '%';
						array_push($data, $word, $word);
						array_push($type, "text", "text");
						array_push($where, "(mm.subject LIKE ? OR mm.body LIKE ?)");
					}
				}
			}

			// SQLにwhere句を連結する
			if (count($where)) {
				$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
				$sql4count .= " WHERE " . implode("\nAND ", $where) . "\n";
			}

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
			$magazine_counts = $res->fetch();
			$magazine_count = $magazine_counts['ct'];

			$smarty->assign('magazine_count', $magazine_count);
			// ページ数を求める
			$per_page = intval($params['per_page']);
			if ($per_page <= 0) {
				$per_page = 10;
			}
			$page_count = intval(($magazine_count - 1) / $per_page) + 1;

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
			$smarty->assign('first_magazine_no', ($magazine_count > 0) ? ($cur_page - 1) * $per_page + 1 : 0);
			$smarty->assign('last_magazine_no', ($cur_page == $page_count) ? $magazine_count : $cur_page * $per_page);

//end paging

			// order句を連結する
			if ($view_show == 'reserved') {
				$sql .= "order by mm.reserve ";
			} else {
				$sql .= "order by mm.date ";
			}

			$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';

			$sql .= "\n";
			// 商品の出力件数を得る
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
			// 変数$per_pageが定義されているときは、1ページ分の商品を読み込む
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
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// 商品を配列に読み込む
			while ($magazine = $res->fetch()) {
				array_push($magazines, $magazine);
			}
		}
		// 商品がない場合
		if (count($magazines) == 0) {
			$smarty->assign('no_magazine', 1);
			$repeat = false;
			return;
		}
		// 商品をSmartyの変数に保存
		$smarty->assign('magazines', $magazines);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存したアドレスを読み出す
		$magazines = $smarty->getTemplateVars('magazines');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr');
	}

	// 個々のアドレス情報を読み込む
	$magazine = $magazines[$ctr];
	// レコードの各フィールドをSmartyの変数に設定する

	if ($magazine['condition']) {
		$magazine['condition'] = json_decode($magazine['condition'], ture);
	}

	$smarty->assign('magazine', $magazine);

	$smarty->assign('magazine_header', ($ctr == 0));
	$smarty->assign('magazine_footer', ($ctr == count($magazines) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次の商品があれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr', $ctr);
	$smarty->assign('index', $ctr - 1);
	$repeat = ($ctr <= count($magazines));
	// glueパラメータが指定されていて、かつ最後の商品でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
