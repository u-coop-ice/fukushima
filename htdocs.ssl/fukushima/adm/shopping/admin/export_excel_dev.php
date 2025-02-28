<?php

set_time_limit(360);

try {
	$adm = new adminShoppingDB();
	$adm->set_target('ymt');
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
$shiptimeKeyList = $smarty->getTemplateVars('shiptimeKeyList');
$shipTypeList = $smarty->getTemplateVars('shipTypeList');

$keyShiptimeList = array_flip($shiptimeKeyList);

//変数の受け取り

$condition['subcategory_id'] = intval($_POST['subcategory_id']);
$condition['item_id'] = intval($_POST['item_id']);

if (isset($_POST['status'])) {
	$condition['status'] = intval($_POST['status']);
}
if ($_POST['term1']) {
	$condition['term1'] = addslashes($_POST['term1']);
}
if ($_POST['term2']) {
	$condition['term2'] = addslashes($_POST['term2']);
}

$condition['format'] = addslashes($_POST['format']);
$condition['ship'] = intval($_POST['ship']);

//-------------------------------------------------------------------------------------

//(2)PHPExcelオブジェクトの生成

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

//書き出しファイルの選択
$xl = $reader->load(ETC_DIR . ADM_DIR . 'templates/shopping/format4ymt.xls');

//(3)シートの設定
$xl->setActiveSheetIndex(0);
$sheet = $xl->getActiveSheet();
$sheet->setTitle('order');

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
 INNER JOIN app_sub as sub ON om.id = sub.app_id
 INNER JOIN sp_item as i ON i.id = sub.item_id
 INNER JOIN sp_subcategory as s ON i.subcategory_id = s.id

HERE;

if (isset($condition['status'])) {
	array_push($data, $condition['status']);
	array_push($where, 'IFNULL(om.status,0) = ?');
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

if ($condition['ship']) {
	$ship_or = array();
	foreach ($shipTypeList as $key => $value) {
		if ($value) {
			array_push($data, $key);
			array_push($ship_or, 'om.ship_flag = ?');
		}
	}

	if (count($ship_or)) {
		array_push($where, '(' . implode(' OR ', $ship_or) . ')');
	}
}
//component=shopping

array_push($data, 'shopping');
array_push($where, 'om.component = ?');

if (count($where)) {
	$sql .= ' WHERE ' . implode("\nAND ", $where) . "\n";
}

// order句を連結する

$sql .= ' GROUP BY om.id ';
$sql .= "\n";
$sql .= ' ORDER BY om.id ';
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

// 記事を配列に読み込む

$ids = array();
$ymts = array();
$row = 2;
$odd = 0;
$ids = array();

while ($entry = $res->fetch()) {
	$ymt = array_fill(1, 75, null);

	$tp = new paymentDB();
	$tp->set_app_id($entry['id']);

	$entry['num_amount_price'] = $tp->getPayment();
	$entry['num_amount_price'] = str_replace(',', '', $entry['num_amount_price']);

	array_push($ids, $entry['id']);

//(4)セルの値を設定

//	$ymt[1] = sprintf("%04d", $entry['order_count']);
	$ymt[30] = sprintf('%04d', $entry['app_count']);
	$ymt[33] = zen2han_more($entry['memo']);

//依頼主系
	if ($entry['ship_from']) {
		$ymt[22] = sprintf('%03d', $entry['ship_from_zipcodef']) . '-' . sprintf('%04d', $entry['ship_from_zipcodes']);
		$ymt[23] = transHyfun($entry['ship_from_pref'] . han2zen($entry['ship_from_addressf'] . $entry['ship_from_addresss']));

		if (mb_strlen($ymt[23]) > 32) {
			$ymt[23] = mb_convert_kana($ymt[23], 'ak', 'UTF-8');
		}

		$ymt[24] = transHyfun(han2zen($entry['ship_from_addresst']));

		if (mb_strlen($ymt[24]) > 16) {
			$ymt[24] = mb_convert_kana($ymt[24], 'ak', 'UTF-8');
		}

		$ymt[20] = zen2han($entry['ship_from_phonenumber']);
		$ymt[25] = $entry['ship_from_name'];
		$ymt[26] = $entry['ship_from_kana'];
		$ymt[26] = zen2han_more($ymt[26]);

	} else if (!$entry['new_add'] || $entry['new_add'] == 3) {

		$ymt[22] = sprintf('%03d', $entry['zipcodef']) . '-' . sprintf('%04d', $entry['zipcodes']);
		$ymt[23] = transHyfun($entry['pref'] . han2zen($entry['addressf'] . $entry['addresss']));

		if (mb_strlen($ymt[23]) > 32) {
			$ymt[23] = mb_convert_kana($ymt[23], 'ak', 'UTF-8');
		}

		$ymt[24] = transHyfun(han2zen($entry['addresst']));

		if (mb_strlen($ymt[24]) > 16) {
			$ymt[24] = mb_convert_kana($ymt[24], 'ak', 'UTF-8');
		}

		$ymt[20] = zen2han($entry['phonenumber']);
		$ymt[25] = $entry['namef'] . $entry['nameg'];
		$ymt[26] = $entry['kanaf'] . $entry['kanag'];
		$ymt[26] = zen2han_more($ymt[26]);

	} else {

		$ymt[22] = sprintf('%03d', $entry['new_zipcodef']) . '-' . sprintf('%04d', $entry['new_zipcodes']);
		$ymt[23] = transHyfun($entry['new_pref'] . han2zen($entry['new_addressf'] . $entry['new_addresss']));

		if (mb_strlen($ymt[23]) > 32) {
			$ymt[23] = mb_convert_kana($ymt[23], 'ak', 'UTF-8');
		}

		$ymt[24] = transHyfun(han2zen($entry['new_addresst']));

		if (mb_strlen($ymt[24]) > 16) {
			$ymt[24] = mb_convert_kana($ymt[24], 'ak', 'UTF-8');
		}
		if ($entry['student_phone']) {
			$ymt[20] = zen2han($entry['student_phone']);
		} else {
			$ymt[20] = zen2han($entry['mobilephone']);
		}
		$ymt[25] = $entry['namef'] . $entry['nameg'];
		$ymt[26] = $entry['kanaf'] . $entry['kanag'];
		$ymt[26] = zen2han_more($ymt[26]);

	}

//お届け先系
	$ymt[11] = sprintf('%03d', $entry['ship_zipcodef']) . '-' . sprintf('%04d', $entry['ship_zipcodes']);
	$ymt[12] = transHyfun($entry['ship_pref'] . han2zen($entry['ship_addressf'] . $entry['ship_addresss']));
	if (mb_strlen($ymt[12]) > 32) {
		$ymt[12] = mb_convert_kana($ymt[12], 'ak', 'UTF-8');
	}

	$ymt[13] = transHyfun(han2zen($entry['ship_addresst']));
	if (mb_strlen($ymt[13]) > 16) {
		$ymt[13] = mb_convert_kana($ymt[13], 'ak', 'UTF-8');
	}
	$ymt[9] = zen2han($entry['ship_phonenumber']);
	$ymt[16] = $entry['ship_namef'] . $entry['ship_nameg'];
	$ymt[17] = $entry['ship_kanaf'] . $entry['ship_kanag'];
	$ymt[17] = zen2han_more($ymt[17]);

	array_push($ids, $entry['id']);
	$ymts[$entry['id']] = $ymt;
//	$srow = $row;
}

$ids = array_unique($ids);

//クエリの準備
$sql2 = <<< HERE
select s.item_id,
s.no,
s.price,
s.num,
s.name,
s.ship_date,
s.ship_time,
s.noshi,
s.noshi_other,
s.extra1,
s.extra2,
s.extra3

FROM app_sub AS s,sp_item as i
WHERE s.app_id = ? AND i.id = s.item_id

HERE;

if ($condition['item_id']) {
	$sql2 .= " AND i.id = " . $condition['item_id'];
} else if ($condition['subcategory_id']) {
	$sql2 .= " AND i.subcategory_id = " . $condition['subcategory_id'];
}

$res_os = $pdo->prepare($sql2);

foreach ($ids as $id) {
	$res_os->execute(array($id));
	$yymt = $ymts[$id];

	while ($suborder = $res_os->fetch()) {
		$yymt[27] = $suborder['no'];
		$yymt[28] = $suborder['name'];

		if (mb_strlen($yymt[28]) > 25) {
			$yymt[28] = mb_convert_kana($yymt[28], 'ak', 'UTF-8');
		}

		if ($shiptimeKeyList[$suborder['ship_time']]) {
			$yymt[7] = $suborder['ship_time'];
			if ($suborder['ship_time'] == 'non') {
				$yymt[7] = '';
			}
		} elseif ($keyShiptimeList[$suborder['ship_time']]) {
			$yymt[7] = $keyShiptimeList[$suborder['ship_time']];
		} else {
			$yymt[7] = $suborder['ship_time'];
		}

		$yymt[38] = intval($suborder['num']);
		$yymt[74] = intval($suborder['price']);
		$yymt[75] = $yymt[74] * $yymt[38];

//		mb_convert_variables('UTF-8', 'EUC-JP', $yymt);

		foreach ($yymt as $k => $v) {
			if ($k == 38 || $k == 74 || $k == 75) {

				$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

			} else {
				$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			}
			if ($odd % 2 == 1) {
				//				$sheet->getStyleByColumnAndRow($k - 1, $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				//				$sheet->getStyleByColumnAndRow($k - 1, $row)->getFill()->getStartColor()->setRGB('ABE9E6');
			}

//			$sheet->getStyleByColumnAndRow($k - 1, $row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//			$sheet->getStyleByColumnAndRow($k - 1, $row)->getBorders()->getRight()->getColor()->setARGB('FFCCCCCC');
		}
		++$row;
	}
	++$odd;
/*
if ($srow > $row) {$srow--;}
$row = $srow;
$row++;
$odd++;
 */
}

if ($row == '2') {
	$smarty->assign('condition', $condition);
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出すデータはありません。');
	$smarty->display('edit_excel_dev.tpl');
	$smarty->assign('url_query', 'mode=edit_excel');
	exit();
}

//書き出し履歴更新

$now = date('Y:m:d H-i-s');

$fields_exported = array(
	'date' => 'text',
	'id' => 'integer',
);

$expt = new adminShoppingDB();
$expt->set_tbl('app_exported');
$expt->set_fields($fields_exported);

$exportdata['date'] = $now;

foreach ($ids as $id) {
	$exportdata['id'] = $id;
	$expt->set_postdata($exportdata);
	$expt->replaceTable();
}

$outputfile = 'shopping_customer' . $now . '.xls';

// Excel2007
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="' . $outputfile . '"');
header('Cache-Control: public, must-revalidate');
header('Pragma: hack');

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($xl);

$writer->save('php://output');

exit();

// ページを表示
;
