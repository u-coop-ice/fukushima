<?php

$rankList = array(
	0 => '', 1 => '本人', 2 => '保護者');

$search = $_REQUEST['term'];
//$search = 'シロタ';

if (!$search) {
	return;
}

$where = array();
$type = array();
$data = array();

if ($search) {
	$search = trim($search);
	$search = preg_replace('/　/', ' ', $search);
	$search = mb_convert_kana($search, "a");
	$search = preg_replace('/\s+/', ' ', $search);
	$words = explode(' ', $search);
	foreach ($words as $word) {
		array_push($type, 'text', 'text', 'text', 'text');
		array_push($data, '%' . $word . '%', '%' . $word . '%', '%' . $word . '%', '%' . $word . '%');
		array_push($where, " (r.namef LIKE ? OR r.nameg LIKE ? OR r.kanaf LIKE ? OR r.kanag LIKE ?) ");
	}
}

$sql = <<< HERE
SELECT r.* FROM regist as r

HERE;

array_push($where, 'r.status = 1');
if (count($where)) {
	$sql .= " WHERE " . implode(" \nAND ", $where) . "\n";
}

$sql .= " GROUP BY id";

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	$repeat = false;
	return;
}

$users = array();

while ($user = $res->fetch()) {
	array_push($users, $user);
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($users);

/*
header('Content-Type: text/javascript; charset=utf-8');
echo $_REQUEST['callback'] . "(" . json_encode($users) . ")";
 */

exit;

?>
