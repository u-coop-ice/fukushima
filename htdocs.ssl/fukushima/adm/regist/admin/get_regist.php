<?php

$where = array();
$data = array();
if (isset($_POST['regist_id'])) {
	$regist_id = intval($_POST['regist_id']);
	if ($regist_id < 0) {exit();}
	array_push($where, "id = ?");
	array_push($data, $regist_id);

} else if (isset($_POST['username'])) {
	$username = addslashes($_POST['username']);

	array_push($where, "username = ?");
	array_push($data, $username);

} else {
	exit();
}

$sql = <<< HERE
SELECT * FROM regist

HERE;

if (count($where)) {
	$sql .= " WHERE " . implode(" AND ", $where);
}

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	exit();
}
$regist = $res->fetch();
if (count($regist) > 2) {
	$smarty->assign('regist', $regist);

	$html = $smarty->fetch("get_regist.tpl");

} else {

	$html = '<p class="note">ユーザー情報がありません。</p>';
}

//echo json_encode($entry);

echo ($html);
exit();

?>
