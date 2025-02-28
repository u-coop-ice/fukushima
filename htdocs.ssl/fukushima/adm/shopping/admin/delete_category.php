<?php
// カテゴリーを削除する
// 削除するカテゴリーのIDを得る
$category_id = intval($_POST['category_id']);

try {
	$pdo->beginTransaction();

	$del = new adminShoppingDB();
	$del->setAdminAuth($auth);
	$del->set_shopping_category_id($category_id);
	$del->deleteShoppingCategory();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'カテゴリの削除に失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

// カテゴリー一覧のページを再度表示する
if ($query) {
	header("Location: ${self}?${query}&deleted=1");
} else {
	header("Location: $self?mode=list_category&deleted=1");
}

exit();

// カテゴリーを削除する
if ($id) {
	$del = new shoppingDB();
	$del->deleteCategory($id);

//authから削除

	$ath = new shoppingDB();

	$users = array(1);
	array_push($users, intval($auth->getAuthData('id')));
	array_unique($users);
	$fields_auth = array('auth' => 'text');
	$ath->set_fields($fields_auth);

	foreach ($users as $user_id) {

		$authority = $ath->get_authority($user_id);
		$authority = json_decode($authority, true);

		if (is_array($authority['shopping']['category_id'])) {

			$key = array_search($id, $authority['shopping']['category_id']);
			unset($authority['shopping']['category_id'][$key]);
		} else {
			$authority['shopping']['category_id'] = array();
		}

		$authdata["auth"] = json_encode($authority);
		if ($user_id == $auth->getAuthData('id')) {
			$auth->setAuthData('auth', $authdata["auth"]);
		}
		$authdata["id"] = $user_id;

		$ath->set_postdata($authdata);
		$ath->set_tbl('init_user');

		$ath->updateTable();
	}

//ログの書き込み
	$log = new adminDB();

	$logdata['process'] = 'delete_category';
	$logdata['auth_username'] = $auth_username;
	$logdata['value'] = $id;

	$log->set_logdata($logdata);
	$log->insertAdminLog();

} else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'カテゴリーのIDが不正です。');
	$smarty->display('error.tpl');
	exit();
}

// カテゴリー一覧のページを再度表示する
header("Location: $self?mode=list_category&deleted=1");
?>
