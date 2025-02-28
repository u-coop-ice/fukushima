<?php

$category_id = intval($_POST['category_id']);
$selected_comedate = addslashes($_POST['selected_comedate']);

$where = array();
$data = array();

// 各月の記事数を集計
$sql = <<< HERE
SELECT comedate,YEAR(comedate) as year,MONTH(comedate) as month,DAY(comedate) as day, count(id) as ct
FROM app

HERE;

array_push($where, "comedate IS NOT NULL");
array_push($where, "component = ?");
array_push($data, "reserve");

if ($category_id) {
	array_push($where, "category_id = ?");
	array_push($data, $category_id);
}

if (count($where)) {
	$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
}

$sql .= <<< HERE
group by comedate
order by comedate ${sort_order}

HERE;

try {
	$res = $pdo_repl->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	return;
}

$select = "<option value=''>（すべての日程）</option>";
while ($archive = $res->fetch()) {

	if ($selected_comedate == $archive['comedate']) {
		$select .= "<option value='" . $archive['comedate'] . "' selected='selected'>" . $archive['comedate'] . "</option>";
	} else {
		$select .= "<option value='" . $archive['comedate'] . "'>" . $archive['comedate'] . "</option>";
	}
}

echo ($select);

?>
