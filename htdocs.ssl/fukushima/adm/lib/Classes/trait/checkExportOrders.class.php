<?php
trait checkExportOrders {

	private $_cell_style = [
		'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
			'color' => ['rgb' => 'C0C0C0']],
		'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => ['rgb' => 'C0C0C0']],
		'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => ['rgb' => 'C0C0C0']],
	];

	private $_cell_style2 = [
		'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
		'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
		'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
		'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
	];

	private $_cell_style3 = [
		'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
	];

	private $_target;

	public function set_target($_target) {
		$this->_target = $_target;
	}

	public function exportWord() {

		$fontStyle['name'] = 'ＭＳ ゴシック';
		$fontStyle['size'] = 9;
		$fontStyle['alignment'] = 'right';

		if (!count($_POST['app_id'])) {
			throw new Exception("書き出すデータがありません", 1);
		}
// 注文IDを変数に設定
		$app_ids = array_map('intval', $_POST['app_id']);

		if (count($app_ids) < 1) {
			throw new Exception("書き出すデータがありません", 1);
		}

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		foreach ($app_ids as $key => $this->_app_id) {
			$order = $this->getEntry4Export();

			$regist_code = $infocode . ":" . date('Ymd', strtotime($order['regist_date'])) . "-" . sprintf("%04d", $order['app_count']);
//受付番号の番号作成
			$this->_smarty->assign('regist_code', $regist_code);

			$regist_date = $order["regist_date"];

			$this->_smarty->assign('view_order_id', $this->_app_id);

			$order_list = $this->_smarty->fetch('show_order_word.tpl');
			$order_list = mb_ereg_replace("\n\n", "\n", $order_list);
			$order_list = mb_ereg_replace("\n", "<w:br></w:br>", $order_list);

//word書き込み

// New portrait section
			$section = $phpWord->addSection();

			$sectionStyle = $section->getSettings();
			$sectionStyle->setMarginTop(567);
			$sectionStyle->setMarginBottom(567);

// Simple text
			$section->addText('受注確認書', 1);
// Two text break
			$section->addTextBreak();

// Defined style
			$section->addText($regist_date, $fontStyle);

			$section->addTextBreak();

			$section->addText($order["namef"] . ' ' . $order["nameg"] . '様', $fontStyle);

			$section->addTextBreak();
			$section->addText($order_list, $fontStyle);

		}

		$outputfile = $regist_code . '.docx';
		$outputdir = $this->_smarty->getCompileDir();
		$phpWord->save($outputdir . $outputfile, 'Word2007');

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $outputfile . '"');
		header('Content-Length: ' . filesize($outputdir . $outputfile));
		readfile($outputdir . $outputfile);

		unlink($outputdir . $outputfile);

	}

	private function replaceAppExported() {

		if (!is_array($this->_app_ids)) {
			return;
		}
		if (!count($this->_app_ids)) {
			return;
		}

		$now = date('Y:m:d H-i-s');

		$fields_exported = array(
			'date' => 'text',
			'id' => 'integer',
		);

		$this->set_tbl('app_exported');
		$this->set_fields($fields_exported);

		$exportdata['date'] = $now;

		foreach ($this->_app_ids as $id) {
			$exportdata['id'] = $id;
			$this->set_postdata($exportdata);
			$this->replaceTable();
		}

	}

	public function exportSpreadSheet() {

		switch ($this->_target) {

		case 'ymt':
			$xl = $this->readySpreadSheet('format4ymt.xls');
			$xl = $this->writeSpreadSheetYmt($xl);

			$this->replaceAppExported();

			$outputfile = 'shopping_customer' . $now . '.xls';

			header('Content-Type: application/vnd.ms-excel');

			header('Content-Disposition: attachment;filename="' . $outputfile . '"');
			header('Cache-Control: public, must-revalidate');
			header('Pragma: hack');

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($xl);

			$writer->save('php://output');
			break;
		case 'jp':
			$xl = $this->readySpreadSheet('format4jp.xlsx');
			$xl = $this->writeSpreadSheetJp($xl);

			$this->replaceAppExported();

			$outputfile = 'shopping_customer4jp' . $now . '.csv';

// Excel2007
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Type: text/csv');

			header('Content-Disposition: attachment;filename="' . $outputfile . '"');
			header('Cache-Control: public, must-revalidate');
			header('Pragma: hack');

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($xl);
			$writer->save('php://output');

			break;
		case 'paid':
			$xl = $this->readySpreadSheet('template_paid.xlsx');
			$xl = $this->writeSpreadSheetPaid($xl);

			$outputfile = 'shopping_paid' . $term1 . '-' . $term2 . '.xlsx';

// Excel2007
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $outputfile . '"');
			header("Cache-Control: public, must-revalidate");
			header("Pragma: hack");

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xl);
			$writer->save('php://output');

		default:
			break;
		}

		exit();

	}

	private function writeSpreadSheetPaid($xl) {
		$paymentAdminList = $this->_smarty->getTemplateVars('paymentAdminList');

		$xl->setActiveSheetIndex(0);
		$sheet = $xl->getActiveSheet();
		$sheet->setTitle(COMPONENT);

		$sheet->getParent()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

		$ids = [];
		$ymts = [];
		$row = 3;
		$odd = 0;

		$entries = $this->getEntries4Export();

		$sql_log = <<< HERE
SELECT * FROM payment_log WHERE app_id = :app_id
AND process = "payment_confirmed"

HERE;

		try {
			$res2 = $this->_pdo->prepare($sql_log);
		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('db_error', 1);
			return;
		}

		foreach ($entries as $entry) {
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

			$res2->bindValue(':app_id', $entry['id'], PDO::PARAM_INT);
			$res2->execute();

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
				$ymt[11] = self::transHyfun($entry['pref'] . self::han2zen($entry['addressf'] . $entry['addresss']));

				$ymt[11] .= self::transHyfun(self::han2zen($entry['addresst']));
				$ymt[11] = mb_convert_kana($ymt[11], "ak", 'UTF-8');

				$ymt[9] = self::zen2han($entry['phonenumber']);

			} else {

				$ymt[10] = sprintf("%03d", $entry['new_zipcodef']) . '-' . sprintf("%04d", $entry['new_zipcodes']);
				$ymt[11] = self::transHyfun($entry['new_pref'] . self::han2zen($entry['new_addressf'] . $entry['new_addresss']));

				$ymt[11] .= self::transHyfun(self::han2zen($entry['new_addresst']));

				$ymt[11] = mb_convert_kana($ymt[11], "ak", 'UTF-8');

				if ($entry['student_phone']) {
					$ymt[9] = self::zen2han($entry['student_phone']);
				} else {
					$ymt[9] = self::zen2han($entry['mobilephone']);
				}

			}

			$ymt[3] = $entry['namef'] . $entry['nameg'];
			$ymt[2] = $entry['kanaf'] . $entry['kanag'];
			$ymt[2] = self::zen2han($ymt[2]);

			foreach ($ymt as $k => $v) {
				if (is_numeric($v)) {

					$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

				} else {
					$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				}

			}
			$row++;
		}
		return $xl;
	}

	private function writeSpreadSheetJp($xl) {
		$shiptimeKeyList = $this->_smarty->getTemplateVars('shiptimeKeyList');

		$xl->setActiveSheetIndex(0);
		$sheet = $xl->getActiveSheet();
		$sheet->setTitle(COMPONENT);

		$sheet->getParent()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

		$ids = [];
		$ymts = [];
		$row = 2;
		$odd = 0;

		$entries = $this->getEntries4Export();

		foreach ($entries as $entry) {
			$ymt = array_fill(1, 21, null);

			$tp = new paymentDB();
			$tp->set_app_id($entry['id']);

			$entry['num_amount_price'] = $tp->getPayment();
			$entry['num_amount_price'] = str_replace(',', '', $entry['num_amount_price']);

			array_push($ids, $entry['id']);

			$ymt[1] = $entry['regist_id'];

//依頼主系
			if ($entry['ship_from']) {
				$ymt[9] = sprintf('%03d', $entry['ship_from_zipcodef']);
				$ymt[10] = sprintf('%04d', $entry['ship_from_zipcodes']);
				$ymt[11] = self::transHyfun($entry['ship_from_pref'] . han2zen($entry['ship_from_addressf'] . $entry['ship_from_addresss']));

				if (mb_strlen($ymt[11]) > 32) {
					$ymt[11] = mb_convert_kana($ymt[11], 'ak', 'UTF-8');
				}

				$ymt[12] = self::transHyfun(han2zen($entry['ship_from_addresst']));

				if (mb_strlen($ymt[12]) > 16) {
					$ymt[12] = mb_convert_kana($ymt[12], 'ak', 'UTF-8');
				}

				$ymt[13] = self::zen2han($entry['ship_from_phonenumber']);
				$ymt[8] = $entry['ship_from_name'];
//		$ymt[26] = $entry['ship_from_kana'];
				//		$ymt[26] = zen2han_more($ymt[26]);

			} else if (!$entry['new_add'] || $entry['new_add'] == 3) {

				$ymt[9] = sprintf('%03d', $entry['zipcodef']);
				$ymt[10] = sprintf('%04d', $entry['zipcodes']);
				$ymt[11] = self::transHyfun($entry['pref'] . self::han2zen($entry['addressf'] . $entry['addresss']));

				if (mb_strlen($ymt[11]) > 32) {
					$ymt[11] = mb_convert_kana($ymt[11], 'ak', 'UTF-8');
				}

				$ymt[12] = self::transHyfun(self::han2zen($entry['addresst']));

				if (mb_strlen($ymt[12]) > 16) {
					$ymt[12] = mb_convert_kana($ymt[12], 'ak', 'UTF-8');
				}

				$ymt[13] = self::zen2han($entry['phonenumber']);
				$ymt[8] = $entry['namef'] . ' ' . $entry['nameg'];
				//		$ymt[26] = zen2han_more($ymt[26]);

			} else {

				$ymt[9] = sprintf('%03d', $entry['new_zipcodef']);
				$ymt[10] = sprintf('%04d', $entry['new_zipcodes']);
				$ymt[11] = self::transHyfun($entry['new_pref'] . self::han2zen($entry['new_addressf'] . $entry['new_addresss']));

				if (mb_strlen($ymt[11]) > 32) {
					$ymt[11] = mb_convert_kana($ymt[11], 'ak', 'UTF-8');
				}

				$ymt[12] = self::transHyfun(self::han2zen($entry['new_addresst']));

				if (mb_strlen($ymt[12]) > 16) {
					$ymt[12] = mb_convert_kana($ymt[12], 'ak', 'UTF-8');
				}
				if ($entry['student_phone']) {
					$ymt[13] = self::zen2han($entry['student_phone']);
				} else {
					$ymt[13] = self::zen2han($entry['mobilephone']);
				}
				$ymt[8] = $entry['namef'] . ' ' . $entry['nameg'];
//		$ymt[26] = $entry['kanaf'] . $entry['kanag'];
				//		$ymt[26] = zen2han_more($ymt[26]);

			}

			$ymt[22] = $entry['postage'];
			$ymt[23] = $entry['reduction'];
			$ymt[25] = $entry['app_count'];

//お届け先系
			$ymt[3] = sprintf('%03d', $entry['ship_zipcodef']);
			$ymt[4] = sprintf('%04d', $entry['ship_zipcodes']);
			$ymt[5] = self::transHyfun($entry['ship_pref'] . self::han2zen($entry['ship_addressf'] . $entry['ship_addresss']));
			if (mb_strlen($ymt[5]) > 32) {
				$ymt[5] = mb_convert_kana($ymt[5], 'ak', 'UTF-8');
			}

			$ymt[6] = self::transHyfun(self::han2zen($entry['ship_addresst']));
			if (mb_strlen($ymt[6]) > 16) {
				$ymt[6] = mb_convert_kana($ymt[6], 'ak', 'UTF-8');
			}
			$ymt[7] = self::zen2han($entry['ship_phonenumber']);
			$ymt[2] = $entry['ship_namef'] . ' ' . $entry['ship_nameg'];
//	$ymt[3] = $entry['ship_kanaf'] .' '. $entry['ship_kanag'];
			//	$ymt[17] = zen2han_more($ymt[17]);

			$ymts[$entry['id']] = $ymt;
//	$srow = $row;
		}

		$ids = array_unique($ids);

//クエリの準備
		$sql2 = <<< HERE
select s.item_id,
s.no,
s.price,
s.num AS num,
s.name,
s.ship_date AS ship_date,
s.ship_time AS ship_time,
s.noshi,
s.noshi_other,
s.extra1,
s.extra2,
s.extra3,
i.weight AS weight
FROM app_sub AS s,sp_item as i
WHERE s.app_id = ? AND i.id = s.item_id

HERE;

		if ($this->_condition['item_id']) {
			$sql2 .= " AND i.id = " . $this->_condition['item_id'];
		} else if ($this->_condition['subcategory_id']) {
			$sql2 .= " AND i.subcategory_id = " . $this->_condition['subcategory_id'];
		}

		$res_os = $this->_pdo->prepare($sql2);

		foreach ($ids as $id) {
			$res_os->execute(array($id));
			$yymt = $ymts[$id];

			mb_convert_variables('CP932', 'UTF-8', $yymt);

			while ($suborder = $res_os->fetch()) {
//		$yymt[27] = $suborder['no'];
				$yymt[14] = $suborder['name'];
				$yymt[14] = mb_convert_encoding($yymt[14], 'CP932', 'UTF-8');

				if (mb_strlen($yymt[14]) > 25) {
					$yymt[14] = mb_convert_kana($yymt[14], 'ak', 'CP932');
				}
				$yymt[15] = intval($suborder['num']);
				$yymt[16] = substr($suborder['ship_date'], 0, 4);
				$yymt[17] = substr($suborder['ship_date'], 5, 2);
				$yymt[18] = substr($suborder['ship_date'], 8, 2);

				$yymt[19] = $shiptimeKeyJPList[$suborder['ship_time']];

				if ($suborder['weight'] > 0 && $suborder['weight'] < 10) {
					$yymt[20] = ceil($suborder['num'] / 2);
				} else {
					$yymt[20] = intval($suborder['num']);
				}

				$yymt[21] = $suborder['price'] * $suborder['num'] + $entry['postage'] - $entry['reduction'];

				$yymt[24] = $suborder['price'] * $suborder['num'] + $yymt[22] - $yymt[23];

				foreach ($yymt as $k => $v) {

					$sheet->getCellByColumnAndRow($k, $row)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

				}
				++$row;
			}
			++$odd;
		}

		$header_list = [
			'customer_id', '配送者氏名', '配送先〒3桁', '配送先〒4桁', '配送先住所1', '配送先住所2', '配送先電話番号', '注文者氏名', '〒3', '〒4', '注文者住所1', '注文者住所2', '注文者電話番号', '品名', '個数', '年', '月', '日', '時間指定', '個口', '商品計', '送料', '値引', '合計', '申込番号',
		];

		mb_convert_variables('CP932', 'UTF-8', $header_list);

		$k = 1;
		foreach ($header_list as $v) {

			$sheet->getCellByColumnAndRow($k, 1)->setValueExplicit(($v), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

			$k++;
		}

		$this->_app_ids = $ids;
		return $xl;
	}

	private function writeSpreadSheetYmt($xl) {

		$shiptimeKeyList = $this->_smarty->getTemplateVars('shiptimeKeyList');

		$xl->setActiveSheetIndex(0);
		$sheet = $xl->getActiveSheet();
		$sheet->setTitle(COMPONENT);

		$sheet->getParent()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

		$ids = [];
		$ymts = [];
		$row = 2;
		$odd = 0;

		$entries = $this->getEntries4Export();

		foreach ($entries as $entry) {

			$ymt = array_fill(1, 75, null);

			$tp = new paymentDB();
			$tp->set_app_id($entry['id']);

			$entry['num_amount_price'] = $tp->getPayment();
			$entry['num_amount_price'] = str_replace(',', '', $entry['num_amount_price']);

			array_push($ids, $entry['id']);

//(4)セルの値を設定

//	$ymt[1] = sprintf("%04d", $entry['order_count']);
			$ymt[30] = sprintf('%04d', $entry['app_count']);
			$ymt[33] = self::zen2han_more($entry['memo']);

//依頼主系
			if ($entry['ship_from']) {
				$ymt[22] = sprintf('%03d', $entry['ship_from_zipcodef']) . '-' . sprintf('%04d', $entry['ship_from_zipcodes']);
				$ymt[23] = self::transHyfun($entry['ship_from_pref'] . self::han2zen($entry['ship_from_addressf'] . $entry['ship_from_addresss']));

				if (mb_strlen($ymt[23]) > 32) {
					$ymt[23] = mb_convert_kana($ymt[23], 'ak', 'UTF-8');
				}

				$ymt[24] = self::transHyfun(han2zen($entry['ship_from_addresst']));

				if (mb_strlen($ymt[24]) > 16) {
					$ymt[24] = mb_convert_kana($ymt[24], 'ak', 'UTF-8');
				}

				$ymt[20] = self::zen2han($entry['ship_from_phonenumber']);
				$ymt[25] = $entry['ship_from_name'];
				$ymt[26] = $entry['ship_from_kana'];
				$ymt[26] = self::zen2han_more($ymt[26]);

			} else if (!$entry['new_add'] || $entry['new_add'] == 3) {

				$ymt[22] = sprintf('%03d', $entry['zipcodef']) . '-' . sprintf('%04d', $entry['zipcodes']);
				$ymt[23] = self::transHyfun($entry['pref'] . self::han2zen($entry['addressf'] . $entry['addresss']));

				if (mb_strlen($ymt[23]) > 32) {
					$ymt[23] = mb_convert_kana($ymt[23], 'ak', 'UTF-8');
				}

				$ymt[24] = self::transHyfun(self::han2zen($entry['addresst']));

				if (mb_strlen($ymt[24]) > 16) {
					$ymt[24] = mb_convert_kana($ymt[24], 'ak', 'UTF-8');
				}

				$ymt[20] = self::zen2han($entry['phonenumber']);
				$ymt[25] = $entry['namef'] . $entry['nameg'];
				$ymt[26] = $entry['kanaf'] . $entry['kanag'];
				$ymt[26] = self::zen2han_more($ymt[26]);

			} else {

				$ymt[22] = sprintf('%03d', $entry['new_zipcodef']) . '-' . sprintf('%04d', $entry['new_zipcodes']);
				$ymt[23] = self::transHyfun($entry['new_pref'] . self::han2zen($entry['new_addressf'] . $entry['new_addresss']));

				if (mb_strlen($ymt[23]) > 32) {
					$ymt[23] = mb_convert_kana($ymt[23], 'ak', 'UTF-8');
				}

				$ymt[24] = self::transHyfun(self::han2zen($entry['new_addresst']));

				if (mb_strlen($ymt[24]) > 16) {
					$ymt[24] = mb_convert_kana($ymt[24], 'ak', 'UTF-8');
				}
				if ($entry['student_phone']) {
					$ymt[20] = self::zen2han($entry['student_phone']);
				} else {
					$ymt[20] = self::zen2han($entry['mobilephone']);
				}
				$ymt[25] = $entry['namef'] . $entry['nameg'];
				$ymt[26] = $entry['kanaf'] . $entry['kanag'];
				$ymt[26] = self::zen2han_more($ymt[26]);

			}

//お届け先系
			$ymt[11] = sprintf('%03d', $entry['ship_zipcodef']) . '-' . sprintf('%04d', $entry['ship_zipcodes']);
			$ymt[12] = self::transHyfun($entry['ship_pref'] . self::han2zen($entry['ship_addressf'] . $entry['ship_addresss']));
			if (mb_strlen($ymt[12]) > 32) {
				$ymt[12] = mb_convert_kana($ymt[12], 'ak', 'UTF-8');
			}

			$ymt[13] = self::transHyfun(self::han2zen($entry['ship_addresst']));
			if (mb_strlen($ymt[13]) > 16) {
				$ymt[13] = mb_convert_kana($ymt[13], 'ak', 'UTF-8');
			}
			$ymt[9] = self::zen2han($entry['ship_phonenumber']);
			$ymt[16] = $entry['ship_namef'] . $entry['ship_nameg'];
			$ymt[17] = $entry['ship_kanaf'] . $entry['ship_kanag'];
			$ymt[17] = self::zen2han_more($ymt[17]);

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

		if ($this->_condition['item_id']) {
			$sql2 .= " AND i.id = " . $this->_condition['item_id'];
		} else if ($this->_condition['subcategory_id']) {
			$sql2 .= " AND i.subcategory_id = " . $this->_condition['subcategory_id'];
		}

		$res_os = $this->_pdo->prepare($sql2);

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

				}
				++$row;
			}
			++$odd;
		}
		$this->_app_ids = $ids;

		return $xl;
	}

	private function readySpreadSheet($_format = null) {

		if (preg_match('/\.xlsx$/', $_format)) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$format = ETC_DIR . ADM_DIR . "templates/" . COMPONENT . "/template.xlsx";
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			$format = ETC_DIR . ADM_DIR . "templates/" . COMPONENT . "/template.xls";
		}

		if ($_format) {
			$format = ETC_DIR . ADM_DIR . "templates/" . COMPONENT . "/" . $_format;
		}

		$xl = $reader->load($format);
		return $xl;
	}

	public function getEntry4Export() {

// SQLを作成する
		$where = [];
		$data = [];
		$sql = <<< HERE
SELECT app.*
,regist.namef as namef
,regist.nameg as nameg
FROM app,regist
WHERE app.regist_id = regist.id AND app.id = :app_id

HERE;

// クエリを実行する

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':app_id', $this->_app_id, PDO::PARAM_INT);
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("DataBase Error " . $e->getMessage(), 1);
		}

		$entry = $res->fetch();

		if (!count($entry)) {
			throw new Exception("書き出すデータがありません", 1);
		}

		return $entry;
	}

	public function getEntries4Export() {

		$shipTypeList = $this->_smarty->getTemplateVars('shipTypeList');

// SQLを作成する
		$where = [];
		$data = [];

		if ($this->_target == 'paid') {

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

		} else {

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

		}
		$fields = [
			'status' => 'integer',
			'item_id' => 'integer',
			'subcategory_id' => 'integer',
			'category_id' => 'integer',
			'term1' => 'text',
			'term2' => 'text',
			'ship' => 'integer',
			'paid' => 'integer',
			'date_paid1' => 'text',
			'date_paid2' => 'text',
		];

		$this->_condition = $this->execSanitize($fields, []);

		if (isset($this->_condition['status'])) {
			array_push($data, $this->_condition['status']);
			array_push($where, 'IFNULL(om.status,0) = ?');
		}

		if ($this->_condition['item_id']) {
			array_push($data, $this->_condition['item_id']);
			array_push($where, 'sub.item_id = ?');
		} else if ($this->_condition['subcategory_id']) {
			array_push($data, $this->_condition['subcategory_id']);
			array_push($where, 's.id = ?');
		} else if ($this->_condition['category_id']) {
			array_push($data, $this->_condition['category_id']);
			array_push($where, 'om.category_id = ?');
		}

		if ($this->_condition['term1']) {
			array_push($data, $this->_condition['term1']);
			array_push($where, 'om.regist_date >= ?');
		}
		if ($this->_condition['term2']) {
			array_push($data, $this->_condition['term2']);
			array_push($where, '( om.regist_date - INTERVAL 1 DAY ) < ?');
		}
		if (isset($this->_condition['paid'])) {
			array_push($data, $this->_condition['paid'] - 1, $this->_condition['paid'] - 1);
			array_push($where, "((IFNULL(om.status,0) <=1  AND SIGN(IFNULL(om.payment_confirmed,0) - IFNULL(om.total_price,0) - IFNULL(om.postage,0) + IFNULL(om.reduction,0)) = ?)
OR (om.status = 9  AND SIGN(IFNULL(om.payment_confirmed,0) - IFNULL(om.price_cancelled,0) = ?)))");
		}

		if ($this->_condition['date_paid1']) {
			array_push($data, $this->_condition['date_paid1']);
			array_push($where, "l.memo >= ?");
		}
		if ($this->_condition['date_paid2']) {
			array_push($data, $this->_condition['date_paid2']);
			array_push($where, " (l.memo - INTERVAL 1 DAY) < ?");
		}

		if ($this->_condition['ship']) {
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

		array_push($data, 'shopping');
		array_push($where, 'om.component = ?');

		if (count($where)) {
			$sql .= ' WHERE ' . implode("\nAND ", $where) . "\n";
		}

		$sql .= ' GROUP BY om.id ';
		$sql .= "\n";
		$sql .= ' ORDER BY om.id ';
		$sql .= ($params['sort_order'] == 'ascend') ? 'asc' : 'desc';
		$sql .= "\n";

// クエリを実行する

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("DataBase Error " . $e->getMessage(), 1);
		}

		$entries = $res->fetchAll();

		if (!count($entries)) {
			throw new Exception("書き出すデータがありません", 1);
		}

		return $entries;
	}

	private function getRegistKeys() {

		$regist_keys = [];

		if ($this->_condition['opt_regist']) {
			$sql = "SHOW COLUMNS FROM regist";

			try {
				$res = $this->_pdo->prepare($sql);
				$res->execute();
			} catch (PDOException $e) {
				throw new Exception("DataBase Error", 1);
			}
			while ($column = $res->fetch()) {
				array_push($regist_keys, $column['Field']);
			}
		}
		return $regist_keys;
	}

}
?>