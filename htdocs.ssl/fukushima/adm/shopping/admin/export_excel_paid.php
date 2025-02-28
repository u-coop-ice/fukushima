<?php
set_time_limit(360);

try {
	$adm = new adminShoppingDB();
	$adm->set_target('paid');
	$adm->exportSpreadSheet();
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出しに失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

exit();

// ページ選択用のクエリの設定
//$smarty->assign('url_query', 'mode=export_excel');

include 'transHyfun.php';

$paymentAdminList = $smarty->getTemplateVars('paymentAdminList');

//変数の受け取り

$condition['category_id'] = intval($_POST['category_id']);
$condition['subcategory_id'] = intval($_POST['subcategory_id']);
$condition['item_id'] = intval($_POST['item_id']);

if (isset($_POST['status'])) {
	$condition['status'] = intval($_POST['status']);
}

if (isset($_POST['paid'])) {
	$condition['paid'] = intval($_POST['paid']);
}

if (isset($_POST['date_paid1'])) {
	$condition['date_paid1'] = addslashes($_POST['date_paid1']);
}
if (isset($_POST['date_paid2'])) {
	$condition['date_paid2'] = addslashes($_POST['date_paid2']);
}

if ($_POST['term1']) {
	$condition['term1'] = addslashes($_POST['term1']);
}
if ($_POST['term2']) {
	$condition['term2'] = addslashes($_POST['term2']);
}

//-------------------------------------------------------------------------------------

//(2.1)PHPExcelオブジェクトを生成する
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

//書き出しファイルの選択
$xl = $reader->load(ETC_DIR . ADM_DIR . 'templates/shopping/template_paid.xlsx');

//(3)シートの設定
$xl->setActiveSheetIndex(0);
$sheet = $xl->getActiveSheet();
$sheet->setTitle('paid');

$sheet->getParent()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

//-------------------------------------------------------------------------------------

// pdoオブジェクトを得る
$pdo = $smarty->getTemplateVars('pdo');

// SQLを作成する
$data = array();
$where = array();

$sql = <<< HERE
select om.*,
c.namef as namef,c.nameg as nameg,
c.kanaf as kanaf,c.kanag as kanag,

c.email as email,

c.membership as membership,
c.dept as dept,

c.birthday as birthday,
c.mobilephone as mobilephone,

c.new_add,
c.new_zipcodef as new_zipcodef,
c.new_zipcodes as new_zipcodes,
c.new_pref as new_pref,
c.new_addressf as new_addressf,
c.new_addresss as new_addresss,
c.new_addresst as new_addresst,
c.student_phone as student_phone,

c.zipcodef as zipcodef,
c.zipcodes as zipcodes,
c.pref as pref,
c.addressf as addressf,
c.addresss as addresss,
c.addresst as addresst,
c.phonenumber as phonenumber



FROM app as om
 LEFT JOIN regist as c ON om.regist_id=c.id
 LEFT JOIN payment_log as l ON (om.id=l.app_id AND l.process = "payment_confirmed")
 INNER JOIN app_sub as sub ON om.id = sub.app_id
 INNER JOIN sp_item as i ON i.id = sub.item_id
 INNER JOIN sp_subcategory as s ON i.subcategory_id = s.id

HERE;

if (isset($condition['status'])) {
	array_push($data, $condition['status']);
	array_push($where, 'IFNULL(om.status,0) = ?');
}

if (isset($condition['paid'])) {
	array_push($data, $condition['paid'] - 1, $condition['paid'] - 1);
	array_push($where, "((om.status <=1  AND SIGN(IFNULL(om.payment_confirmed,0) - IFNULL(om.total_price,0) - IFNULL(om.postage,0) + IFNULL(om.reduction,0)) = ?)
OR (om.status = 9  AND SIGN(IFNULL(om.payment_confirmed,0) - IFNULL(om.price_cancelled,0) = ?)))");
}

if ($condition['date_paid1']) {
	array_push($data, $condition['date_paid1']);
	array_push($where, "l.memo >= ?");
}
if ($condition['date_paid2']) {
	array_push($data, $condition['date_paid2']);
	array_push($where, " (l.memo - INTERVAL 1 DAY) < ?");
}

if ($condition['item_id']) {
	array_push($data, $condition['item_id']);
	array_push($where, 'sub.item_id = ?');
} else if ($condition['subcategory_id']) {
	array_push($data, $condition['subcategory_id']);
	array_push($where, 's.id = ?');
} else if ($condition['category_id']) {
	array_push($data, $condition['category_id']);
	array_push($where, 'om.category_id = ?');
}

if ($condition['term1']) {
	array_push($data, $condition['term1']);
	array_push($where, 'om.regist_date >= ?');
}
if ($condition['term2']) {
	array_push($data, $condition['term2']);
	array_push($where, '( om.regist_date - INTERVAL 1 DAY ) < ?');
}

//component=shopping

array_push($data, "shopping");
array_push($where, "om.component = ?");

if (count($where)) {
	$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
}

// order句を連結する
$sql .= " GROUP BY om.id ";

$sql .= " ORDER BY om.id ";
$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
$sql .= "\n";

// クエリを実行する

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	return;
}

$sql_log = <<< HERE
SELECT * FROM payment_log WHERE app_id = ?
AND process = "payment_confirmed"

HERE;

try {
	$res2 = $pdo->prepare($sql_log);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	return;
}

// 記事を配列に読み込む

$ids = array();
$ymts = array();
$row = 3;
$odd = 0;
$ids = array();

while ($entry = $res->fetch()) {

	$ymt = array_fill(1, 17, null);

	$tp = new paymentDB();
	$tp->set_app_id($entry['id']);

	$entry['num_amount_price'] = $entry['total_price'] + $entry['postage'] - $entry['reduction'];
	$entry['num_amount_price'] = str_replace(',', '', $entry['num_amount_price']);

	$ymt[4] = intval($entry['num_amount_price']);
	if ($entry['status'] == 9) {
		$ymt[4] = intval($entry['price_cancelled']);
	}
	$ymt[5] = intval($entry['payment_confirmed']);
	$ymt[6] = $ymt[5] - $ymt[4];

	$res2->execute(array($entry['id']));
	$logs = $res2->fetchAll();
	if (count($logs)) {
		foreach ($logs as $log) {
			$ymt[7] .= $log['memo'] . ' ' . $log['value'] . "\n";
		}
	}

	$ymt[8] = $paymentAdminList[$entry['payment']];

//	array_push($ids, $entry['id']);

//(4)セルの値を設定

	$ymt[1] = sprintf("%04d", $entry['app_count']);

//依頼主系
	if (!$entry['new_add'] || $entry['new_add'] == 3) {

		$ymt[10] = sprintf("%03d", $entry['zipcodef']) . '-' . sprintf("%04d", $entry['zipcodes']);
		$ymt[11] = transHyfun($entry['pref'] . han2zen($entry['addressf'] . $entry['addresss']));

		$ymt[11] .= transHyfun(han2zen($entry['addresst']));
		$ymt[11] = mb_convert_kana($ymt[11], "ak", 'UTF-8');

		$ymt[9] = zen2han($entry['phonenumber']);

	} else {

		$ymt[10] = sprintf("%03d", $entry['new_zipcodef']) . '-' . sprintf("%04d", $entry['new_zipcodes']);
		$ymt[11] = transHyfun($entry['new_pref'] . han2zen($entry['new_addressf'] . $entry['new_addresss']));

		$ymt[11] .= transHyfun(han2zen($entry['new_addresst']));

		$ymt[11] = mb_convert_kana($ymt[11], "ak", 'UTF-8');

		if ($entry['student_phone']) {
			$ymt[9] = zen2han($entry['student_phone']);
		} else {
			$ymt[9] = zen2han($entry['mobilephone']);
		}

	}

	$ymt[3] = $entry['namef'] . $entry['nameg'];
	$ymt[2] = $entry['kanaf'] . $entry['kanag'];
	$ymt[2] = zen2han($ymt[2]);

	foreach ($ymt as $k => $v) {
		if (is_numeric($v)) {

			$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

		} else {
			$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		}

	}
	$row++;
}

if ($row == "3") {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出すデータはありません。');
	$smarty->display('error.tpl');
	$smarty->assign('url_query', 'mode=edit_excel');
	exit();
}

$outputfile = 'shopping_paid' . $term1 . '-' . $term2 . '.xlsx';

// Excel2007
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $outputfile . '"');
header("Cache-Control: public, must-revalidate");
header("Pragma: hack");

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xl);
$writer->save('php://output');

exit();

// ページを表示

?>
