<?php

$category_id = intval($_POST['category_id']);
$subcategory_id = intval($_POST['subcategory_id']);
$result = array();

if ($category_id > 0) {

	$sql = <<< HERE
SELECT sc.* FROM sp_subcategory AS sc
 WHERE sc.`category_id` = :category_id

HERE;

	try {
		$res = $pdo->prepare($sql);
		$res->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$res->execute();
	} catch (PDOException $e) {
		return;
	}

	$subcategories = $res->fetchAll();
	$result['subcategory'] = $subcategories;

}

//echo json_encode($subplans);
if ($subcategory_id > 0) {

	$sql = <<< HERE
SELECT i.id,i.name FROM sp_item AS i WHERE i.`subcategory_id` = ${subcategory_id}

HERE;

	try {
		$res = $pdo->query($sql);
//		$res->execute(array($subplan_id));
	} catch (PDOException $e) {
// データベースアクセスに失敗したらエラーとする
		//		$smarty->assign('db_error', 1);
		return;
	}

	$items = $res->fetchAll();
	$result['item'] = $items;
}

echo json_encode($result);

exit;

?>
