<?php
// 削除する記事のIDを得る
$id = intval($_POST['id']);
$category_id = intval($_POST['category_id']);

// 記事を削除する
if ($category_id) {
	if ($category_id == 99999999) {
		$sql = "delete from {$pfx2}entry";
		$sth = $pdo->query($sql);
		$sql = "ALTER TABLE {$pfx2}entry AUTO_INCREMENT = 1";
		$request = $pdo->query($sql);
	} else {
		$sql = "delete from {$pfx2}entry where category_id = ?";
		$data = array($category_id);

		try {
			$sth = $pdo->prepare($sql);
			$res = $sth->execute($data);
		} catch (Exception $e) {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', '登録データの削除に失敗しました。');
			$smarty->display('error.tpl');
			exit();
		}
	}
} else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'カテゴリの選択が不正です。');
	$smarty->display('error.tpl');
	exit();
}

// 記事一覧のページを再度表示する
if ($category_id == 99999999) {
	header("Location: $self?mode=list_entry&deleted=1");
} else {
	header("Location: $self?mode=list_entry&cid=" . $category_id . "&deleted=1");
}
?>
