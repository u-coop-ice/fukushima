<?php
function smarty_block_page_loop($params, $content, &$smarty, &$repeat) {

	// ブロックに入る前なら、ページ番号を初期化する
	if (is_null($content)) {
		$page_no = 0;
	}
	// 繰り返しの後であれば、ページ番号を変数から読み出す
	else {
		$page_no = $smarty->getTemplateVars('page_no');
	}
	// 次のページ番号を出力する準備
	$page_no++;
	$smarty->assign('page_no', $page_no);
	$cur_page = $smarty->getTemplateVars('cur_page');
	$page_count = $smarty->getTemplateVars('page_count');
	$smarty->assign('is_cur_page', ($cur_page == $page_no));
	$repeat = ($page_no <= $smarty->getTemplateVars('page_count'));

	if ($params['limit']) {
		if ($page_count >= $page_no) {
			$repeat = ($page_no <= $cur_page + $params['limit']);
		}
		if ($page_no <= $cur_page - $params['limit']) {
			$content = "";
		}
	}

	// glueパラメータが指定されていて、かつ最後の記事でなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
