<?php

$category_id = intval($_POST['category_id']);
$comedate = addslashes($_POST['comedate']);
$selected_cometime = $_POST['selected_cometime'];

if ($selected_cometime == "null" || $selected_cometime == "NULL") {
	$selected_cometime = null;
}
if ($selected_cometime) {
	$selected_cometime = json_decode($selected_cometime, true);
} else {
	$selected_cometime = [];
}

$where = array();
$data = array();

// 各月の記事数を集計
$sql = <<< HERE
SELECT cometime,comedate,YEAR(comedate) as year,MONTH(comedate) as month,DAY(comedate) as day, count(id) as ct
FROM app

HERE;

array_push($where, "component = ?");
array_push($data, "reserve");

if ($category_id) {
	array_push($where, "category_id = ?");
	array_push($data, $category_id);
}

if ($comedate) {
	array_push($where, "comedate = ?");
	array_push($data, $comedate);
}

if (count($where)) {
	$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
}

$sql .= <<< HERE
group by cometime
order by cometime ${sort_order}

HERE;

try {
	$res = $pdo_repl->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	return;
}

$select = "";
$select .= "<label class='form-check-label'><input type='checkbox' class='cometime_all form-check-input'";
if (count($selected_cometime) == 0) {
	$select .= " checked='checked' ";
}
$select .= " />すべて</label><br />";

while ($archive = $res->fetch()) {
	if (in_array($archive['cometime'], $selected_cometime)) {
		$select .= "<label class='form-check-label'><input class=' form-check-input' type='checkbox' name='cometime[]' value='" . $archive['cometime'] . "' checked='checked' />" . $archive['cometime'] . "</label><br />";
	} else {
		$select .= "<label class='form-check-label'><input class='form-check-input' type='checkbox' name='cometime[]' value='" . $archive['cometime'] . "' />" . $archive['cometime'] . "</label><br />";
	}
}

echo ($select);

?>
