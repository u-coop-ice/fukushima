<?php
// ページ選択用のクエリの設定
//$smarty->assign('url_query', 'mode=export_excel');

include 'transHyfun.php';

//変数の受け取り

//$entry_flag = htmlspecialchars($_POST['entry_flag'],3,'EUC-JP');
//$univ_id = intval($_POST['univ_id']);

$category_id = intval($_POST['category_id']);
if (isset($_POST['status'])) {
	$status = intval($_POST['status']);
}
if (isset($_POST['date']) && $_POST['date']) {
	$order_date = addslashes($_POST['date']);
} else if ($_POST['term1']) {

	$term1 = addslashes($_POST['term1']);
	$term2 = addslashes($_POST['term2']);

//term2に+1日

	$term2 = strtotime($term2) + 1 * 60 * 60 * 24;
	$term2 = date("Y-m-d", $term2);
}
//$export_date = htmlspecialchars($_POST['export_date'],3,'EUC-JP');
//$mst = htmlspecialchars($_POST['mst'],3,'EUC-JP');
$format = addslashes($_POST['format']);

//-------------------------------------------------------------------------------------

//(1)必要なクラスをインクルード
//(1)必要なクラスをインクルード
require_once 'vendor/autoload.php';

//(2)PHPExcelオブジェクトの生成
//$xl = new PHPExcel();

//(2.1)PHPExcelオブジェクトを生成する
$reader = PHPExcel_IOFactory::createReader("Excel2007");

//書き出しファイルの選択
if ($format == 'KLAS') {
	$xl = $reader->load(ETC_DIR . ADM_DIR . 'templates/shopping/template.xlsx');
} else {
	$xl = $reader->load(ETC_DIR . ADM_DIR . 'templates/shopping/template_all.xlsx');
}

//(3)シートの設定
$xl->setActiveSheetIndex(0);
$sheet = $xl->getActiveSheet();
$sheet->setTitle('order');

$sheet->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

//-------------------------------------------------------------------------------------

// pdoオブジェクトを得る
$pdo = $smarty->getTemplateVars('pdo');
// テーブルの接頭語を得る

// SQLを作成する
$type = array();
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

HERE;

if (isset($status)) {
	array_push($data, $status);
	array_push($where, "IFNULL(om.status,0) = ?");
}

if (isset($category_id)) {
	array_push($data, $category_id);
	array_push($where, "om.category_id = ?");
}

if (isset($order_date)) {
	array_push($data, $order_date . "%");
	array_push($where, "om.date LIKE ?");
} else if ($term1) {
	array_push($data, $term1);
	array_push($where, "om.date >= ?");
	if ($term2) {
		array_push($data, $term2);
		array_push($where, "om.date < ?");
	}

}

if (count($where)) {
	$sql .= "where " . implode("\nand ", $where) . "\n";
}

// order句を連結する

$sql .= "order by om.id ";
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

$sql = <<< HERE
SELECT s.item_id,
i.no,
s.num,
s.ship_date,
s.ship_time,
s.noshi,
s.noshi_other,
s.extra1,
s.extra2,
s.extra3
FROM app_sub as s,sp_item as i
WHERE i.id=s.item_id AND s.app_id = ?

HERE;

// 記事を配列に読み込む

$row = 2;
$odd = 0;
$ids = array();

while ($entry = $res->fetch()) {

	try {
		$res_os = $pdo->prepare($sql);
		$res_os->execute(array($entry['id']));
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
		return;
	}
	$tp = new paymentDB();
	$tp->set_app_id($entry['id']);

	$entry['num_amount_price'] = $tp->getPayment();
	$entry['num_amount_price'] = str_replace(',', '', $entry['num_amount_price']);

	array_push($ids, $entry['id']);

//(4)セルの値を設定

//print_r($entry);exit;

	if ($entry['zipcodef']) {
		$entry['zipcodef'] = sprintf("%03d", $entry['zipcodef']);
	}
	if ($entry['zipcodes']) {
		$entry['zipcodes'] = sprintf("%04d", $entry['zipcodes']);
	}
	$entry['addressf'] = han2zen($entry['addressf']);
	$entry['addresss'] = han2zen($entry['addresss']);
	$entry['addresst'] = han2zen($entry['addresst']);
	$entry['phonenumber'] = zen2han($entry['phonenumber']);

	if ($entry['ship_zipcodef']) {
		$entry['ship_zipcodef'] = sprintf("%03d", $entry['ship_zipcodef']);
	}
	if ($entry['ship_zipcodes']) {
		$entry['ship_zipcodes'] = sprintf("%04d", $entry['ship_zipcodes']);
	}
	$entry['ship_addressf'] = han2zen($entry['ship_addressf']);
	$entry['ship_addresss'] = han2zen($entry['ship_addresss']);
	$entry['ship_phonenumber'] = zen2han($entry['ship_phonenumber']);

//print_r($entry);
	//exit;

	$col = 0;
	foreach ($entry as $key => $value) {

//		$value = mb_convert_encoding($value, "UTF-8", "EUC-JP");

		if ($key == 'addressf' || $key == 'addresss' || $key == 'ship_addressf' || $key == 'ship_addresss' || $key == 'phonenumber' || $key == 'shipphonenumber') {
			$value = transHyfun($value);
		}

		if (preg_match("/^num/", $key)) {
			$sheet->setCellValueExplicitByColumnAndRow($col, $row, $value, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		} else {
			$sheet->setCellValueExplicitByColumnAndRow($col, $row, $value, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		if ($odd % 2 == 1) {
			$sheet->getStyleByColumnAndRow($col, $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$sheet->getStyleByColumnAndRow($col, $row)->getFill()->getStartColor()->setRGB('ABE9E6');
		}

		$col++;
	}

	$suborder = array();

	$srow = $row;

	while ($suborder = $res_os->fetch()) {
		$scol = $col;
		foreach ($suborder as $sk => $sv) {
//			$sv = mb_convert_encoding($sv, "UTF-8", "EUC-JP");
			if ($sk == "ship_time" && $sv == "non") {$sv = "";}
			if (preg_match("/^num/", $sk)) {
				$sheet->setCellValueExplicitByColumnAndRow($scol, $srow, $sv, PHPExcel_Cell_DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValueExplicitByColumnAndRow($scol, $srow, $sv, PHPExcel_Cell_DataType::TYPE_STRING);
			}

			if ($odd % 2 == 1) {
				$sheet->getStyleByColumnAndRow($scol, $srow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$sheet->getStyleByColumnAndRow($scol, $srow)->getFill()->getStartColor()->setRGB('ABE9E6');
			}

			$scol++;
		}

		if ($srow > $row) {
//注文者情報セルのコピー

			for ($cc = 0; $cc <= 56; $cc++) {
// セルを取得
				$cell = $sheet->getCellByColumnAndRow($cc, $row);
				$style = $sheet->getStyleByColumnAndRow($cc, $row);
				if ($cc > 4 && $cc < 55) {
					$sheet->setCellValueExplicitByColumnAndRow($cc, $srow, $cell->getValue());
				}
				$sheet->duplicateStyle($style, PHPExcel_Cell::stringFromColumnIndex($cc) . $srow);
			}

		}

		$srow++;
	}

	if ($srow == $row) {$srow++;}

	$row = $srow;
	$odd++;
}

if ($row == "2") {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出すデータはありません。');
	$smarty->display('error.tpl');
	$smarty->assign('url_query', 'mode=edit_excel');
	exit();
}

/*
if ($format=="ALL") { // エクセルのヘッダー書き出し
$row=1;
$col = 0;
$keys = array_keys($entry);
foreach ($keys as $value) {
$value = mb_convert_encoding($value,"UTF-8","EUC-JP");
$sheet->setCellValueExplicitByColumnAndRow($col, $row, $value);
$col++;
}
}
 */

$outputfile = 'shopping_customer' . date('Ymd_H-i-s') . '.xlsx';

// Excel2007
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $outputfile . '"');
header("Cache-Control: public, must-revalidate");
header("Pragma: hack");

$writer = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
$writer->save('php://output');

exit();

// ページを表示

?>
