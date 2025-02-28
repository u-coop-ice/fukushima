<?php
function smarty_block_htkt_archives($params, $content, &$smarty, &$repeat) {
	$archives = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_archive', 0);
		$smarty->assign('db_error', 0);
		// PDOオブジェクトを得る
		$pdo = $smarty->getTemplateVars('pdo');
		// 下書き記事を出力しない場合は、where句を作る

		//        if (!$params['show_draft'] && !$_SESSION['admin_mode']) {
		$where = "where publish = 1";
//        }
		// 並べ替え方法の設定
		if ($params['sort_order'] == 'ascend') {
			$sort_order = 'asc';
		} else {
			$sort_order = 'desc';
		}
		// 各月の記事数を集計
		$sql = <<< HERE
SELECT year(regist_date) as `year`, month(regist_date) as `month`, count(id) as entry_count
FROM htkt_entry
$where
group by `year`, `month`
order by `year` ${sort_order}, `month` ${sort_order}

HERE;

		try {
			$res = &$pdo->query($sql);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('db_error', 1);
			$repeat = false;
			return;
		}
		// 年月を配列に読み込む
		while ($archive = $res->fetch()) {
			array_push($archives, $archive);
		}
		// アーカイブがない場合
		if (count($archives) == 0) {
			$smarty->assign('no_archive', 1);
			$repeat = false;
			return;
		}
		// アーカイブをSmartyの変数に保存
		$smarty->assign('archives', $archives);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存したアーカイブを読み出す
		$archives = $smarty->getTemplateVars('archives');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr');
	}

	// 個々のアーカイブの情報を読み込む
	$archive = $archives[$ctr];
	// レコードの各フィールドをSmartyの変数に設定する
	$smarty->assign('archive', $archive);

	$smarty->assign('archive_header', ($ctr == 0));
	$smarty->assign('archive_footer', ($ctr == count($archives) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のアーカイブがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr', $ctr);
	$repeat = ($ctr <= count($archives));
	// glueパラメータが指定されていて、かつ最後のアーカイブでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
