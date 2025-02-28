<?php

set_time_limit(0);
// ページ選択用のクエリの設定

//変数の受け取り
$condition['category_id'] = intval($_POST['category_id']);
$condition['comedate'] = strip_tags($_POST['comedate']);
$condition['opt_cancelled'] = intval($_POST['opt_cancelled']);
$condition['opt_archived'] = intval($_POST['opt_archived']);
$condition['opt_regist'] = intval($_POST['opt_regist']);
$condition['opt_component'] = strip_tags($_POST['opt_component']);

try {
	$ex = new adminReserveDB;
	$ex->set_condition($condition);
	$ex->exportSpreadSheet();

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出しに失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	$smarty->assign('url_query', 'mode=edit_excel');
	exit();
}

exit();

$vv = new setDB();
$var = $vv->get_vars();

//変数回避

if ($var['address']) {
	$var['address']['addresss'] = 'text';
	$var['address']['addresst'] = 'text';
}
if ($var['new_add']) {
	$var['new_add']['new_addresss'] = 'text';
	$var['new_add']['new_addresst'] = 'text';
	$var['new_add']['new_add'] = 'integer';
}
if ($var['ship_address']) {
	$var['ship_address']['ship_addresss'] = 'text';
	$var['ship_address']['ship_addresst'] = 'text';
}

$var['phonenumber'] = null;
$var['mobilephone'] = null;
$var['parent_mobile'] = null;
$var['parent_com_phone'] = null;
$var['student_phone'] = null;
$var['membership'] = null;

$ct = new livingDB();

$params['part'] = PART;
$params['component'] = COMPONENT;
$ct->set_params($params);
$init_category = $ct->get_init_category_info();
$methods = json_decode($init_category['method'], ture);

$sf = new livingDB();
$sf->set_ship_flag($methods['ship_flag']);
$category_ship_flag_list = $sf->get_ship_flag_list();

//学部学科取得

$sql = <<< HERE
SELECT * FROM init_code WHERE univ_id = ?

HERE;

$sql .= "\n";

$data = array($smarty->getConfigVars('univ_id'));
// クエリを実行する

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	if (count($entries) == 0) {
		$smarty->assign('db_error', 1);
		return;
	}
}

while ($code = $res->fetch()) {
	$codes[$code['name']][$code['id']] = $code['value'];
}

//-------------------------------------------------------------------------------------

//(1)必要なクラスをインクルード
require_once 'vendor/autoload.php';

//(2)PHPExcelオブジェクトの生成
//$xl = new PHPExcel();

//(2.1)PHPExcelオブジェクトを生成する
$reader = PHPExcel_IOFactory::createReader("Excel2007");
$xl = $reader->load(ETC_DIR . ADM_DIR . "templates/" . COMPONENT . '/' . PART . "/template.xlsx");

//(3)シートの設定
$xl->setActiveSheetIndex(0);
$sheet = $xl->getActiveSheet();
$sheet->setTitle('entry');

$sheet->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

//-------------------------------------------------------------------------------------

// pdoオブジェクトを得る
$pdo = $smarty->getTemplateVars('pdo');
// テーブルの接頭語を得る
$pfx = $smarty->getConfigVars('prefix');
$pfx2 = $smarty->getConfigVars('prefix2');

// ユーザー登録テーブルのカラム名を取得
if ($opt_regist) {
	$sql = "SHOW COLUMNS FROM regist";

	try {
		$res = $pdo->prepare($sql);
		$res->execute($data);
	} catch (PDOException $e) {
		// データベースアクセスに失敗したらエラーとする
		if (count($entries) == 0) {
			$smarty->assign('db_error', 1);
			return;
		}
	}
	$regist_keys = array();
	while ($column = $res->fetch()) {

		array_push($regist_keys, $column['Field']);
	}

}

// SQLを作成する
$type = array();
$data = array();
$where = array();
$sql = <<< HERE
SELECT
a.*,
a.regist_date as app_regist_date,
a.cancelled as app_cancelled,
a.status as app_status,
r.*,
c.denomination as category_denomination
 FROM app as a, init_category as c,regist as r
WHERE a.component = c.component AND a.part = c.part AND r.id = a.regist_id

HERE;

if ($opt_cancelled) {
	array_push($data, 0);
	array_push($where, "IFNULL(a.cancelled,0) = ?");
}
if ($opt_archived) {
	array_push($data, 0);
	array_push($where, "IFNULL(a.archived,0) = ?");
}
if ($comedate) {
	array_push($data, $comedate);
	array_push($where, "a.comedate = ?");
}

array_push($data, COMPONENT);
array_push($where, "a.component = ?");

array_push($data, PART);
array_push($where, "a.part = ?");

if (count($where)) {
	$sql .= " AND " . implode("\nAND ", $where) . " \n ";
}

// order句を連結する
$sql .= "ORDER BY a.id ";
$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
$sql .= "\n";

// クエリを実行する

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	// データベースアクセスに失敗したらエラーとする
	if (count($entries) == 0) {
		$smarty->assign('db_error', 1);
		return;
	}
}

// 記事を配列に読み込む

$row = 2;

while ($entry = $res->fetch()) {
	$list = array();
	$entry['extra'] = json_decode($entry['extra'], true);
//	$entry['methods'] = json_decode($entry['methods'], true);

	$list['category_denomination'] = $entry['category_denomination'];
	$list['app_count'] = $entry['app_count'];
	$list['app_regist_date'] = $entry['app_regist_date'];

	$list['comedate'] = $entry['comedate'];
	$list['cometime'] = $entry['cometime'];

	$list['email'] = $entry['email'];

	if (count($methods)) {
		foreach ($methods as $key => $post) {
			if ($key == "extra") {
				if (count($post)) {
					foreach ($post as $exkey => $expost) {
						if ($expost['use']) {
							if (is_array($entry[$key][$exkey])) {
								$entry[$key][$exkey] = implode("/", $entry[$key][$exkey]);
							}
							$list[$key . $exkey] = $entry[$key][$exkey];
						}
					}
				}
			} else if ($key == "age") {
				$list['birthday'] = $entry['birthday'];

			} else if ($post['use']) {
				if ($var[$key]) {
					if (is_array($var[$key])) {
						foreach (array_keys($var[$key]) as $k) {
							$list[$k] = $entry[$k];
						}
					} else {
						$list[$key] = $entry[$key];
					}
				} else {
					$list[$key] = $entry[$key];
				}
			}

		}
	}

	$list['ship_flag'] = $category_ship_flag_list[$list['ship_flag']];

/*
if ($list['zipcodef']) {
$list['zipcode'] = sprintf("%03d", $list['zipcodef']) . sprintf("%04d", $list['zipcodes']);
unset($list['zipcodef']);
unset($list['zipcodes']);
}
 */
//	$list['app_status'] = $entry['app_status'];

	if ($opt_cancelled == 0) {
		$list['app_cancelled'] = $entry['app_cancelled'];
	}

//(4)セルの値を設定

	if ($list['dept']) {
		$list['dept'] = $codes[23][$list['dept']];
	}

	if ($opt_regist) {
		foreach ($regist_keys as $key) {
			if ($key == "password") {continue;}
			if ($key == "dept") {$entry[$key] = $codes[23][$entry[$key]];}
			$list['regist_' . $key] = $entry[$key];
		}

	}

	$entries = $list; // 変数の置換

	$col = 0;
	foreach ($entries as $key => $value) {
		if ($format["$key"] && $value) {$value = sprintf($format["$key"], $value);}
		$sheet->setCellValueExplicitByColumnAndRow($col, $row, $value);
		$col++;

	}
	$row++;
}

if ($row == "2") {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出すデータはありません。');
	$smarty->display('error.tpl');
	$smarty->assign('url_query', 'mode=edit_excel');
	exit();
}

// エクセルのヘッダー書き出し
$row = 1;
$col = 0;
$keys = array_keys($entries);
foreach ($keys as $value) {
//		$value = mb_convert_encoding($value,"UTF-8","EUC-JP");
	$sheet->setCellValueExplicitByColumnAndRow($col, $row, $value);
	$col++;
}

$outputfile = COMPONENT . date('Ymd_H-i-s') . '.xlsx';

// Excel2007
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $outputfile . '"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
$writer->save('php://output');

exit();

// ページを表示

?>
