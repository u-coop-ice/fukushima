<?php
function smarty_block_export($params, $content, &$smarty, &$repeat) {
	$exports = array();
	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_export', 0);
		$smarty->assign('db_error', 0);
		// pdoオブジェクトを得る
		$pdo = $smarty->getTemplateVars('pdo');
		// テーブルの接頭語を得る
		$pfx = $smarty->get_config_vars('prefix');
		// 下書き記事を出力しない場合は、where句を作る
		//        if (!$params['show_draft'] && !$_SESSION['admin_mode']) {
		$where = "where publish = 1 and date_export is not NULL";
//        }
		// 並べ替え方法の設定
		if ($params['sort_order'] == 'ascend') {
			$sort_order = 'asc';
		} else {
			$sort_order = 'desc';
		}
		// 各月の記事数を集計
		$sql = <<< HERE
select date_export, count(id) as ct
from ${pfx}entry
$where
group by date_export
order by date_export
HERE;
		$res = &$pdo->query($sql);
		if (PEAR::isError($res)) {
			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('db_error', 1);
			$repeat = false;
			return;
		}
		// 年月を配列に読み込む
		while ($export = $res->fetchRow()) {
			array_push($exports, $export);
		}
		// アーカイブがない場合
		if (count($exports) == 0) {
			$smarty->assign('no_export', 1);
			$repeat = false;
			return;
		}
		// アーカイブをSmartyの変数に保存
		$smarty->assign('exports', $exports);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存したアーカイブを読み出す
		$exports = $smarty->getTemplateVars('exports');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr');
	}

	// 個々のアーカイブの情報を読み込む
	$export = $exports[$ctr];
	// レコードの各フィールドをSmartyの変数に設定する
	$smarty->assign('export_date', $export['date_export']);
	$smarty->assign('export_entry_count', $export['ct']);
	$smarty->assign('export_header', ($ctr == 0));
	$smarty->assign('export_footer', ($ctr == count($exports) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のアーカイブがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr', $ctr);
	$repeat = ($ctr <= count($exports));
	// glueパラメータが指定されていて、かつ最後のアーカイブでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
