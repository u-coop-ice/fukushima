<?php
trait checkExportEntries {

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

	public function exportSpreadSheet() {

		$vars = array_merge($this->_fields_extension, $this->_fields_extension_app);

		foreach ($this->_fields_phonenumber as $field) {
			$vars[$field] = null;
		}

		$vars['membership'] = null;
		unset($vars['bank']['bank']);
		$xl = $this->readySpreadSheet();

//(3)シートの設定
		$xl->setActiveSheetIndex(0);
		$sheet = $xl->getActiveSheet();
		$sheet->setTitle(COMPONENT);

		$sheet->getParent()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

		$codes = $this->getInitCodes();
		$entries = $this->getEntries4Export();
		$regist_keys = $this->getRegistKeys();

		$row = 2;

		foreach ($entries as $entry) {

			$list = [];
			$entry['extra'] = json_decode($entry['extra'], true);
			$entry['methods'] = json_decode($entry['methods'], true);

			$list['category_denomination'] = $entry['category_denomination'];
			$list['app_count'] = $entry['app_count'];
			$list['app_regist_date'] = $entry['app_regist_date'];
			$list['email'] = $entry['email'];

			switch ($entry['component']) {
			case 'reserve':
				$list['comedate'] = $entry['comedate'];
				$list['cometime'] = $entry['cometime'];
				break;
			case 'bicycle':
				$list['許可番号'] = $entry['holdername'];
				$list['登録料'] = $entry['cvc'];
				break;
			}

			$method = [];

			if (count($entry['methods'])) {

				foreach ($entry['methods'] as $key => $ary) {
					if ($key == 'extra') {
						if (count($ary)) {

							foreach ($ary as $i => $ar) {
								if ($ar['use']) {
									if (isset($ar['sort'])) {
										$method[$key . $i] = $ar['sort'];
									}
								}
							}

						}
					} else {
						if ($ary['use']) {
							if (isset($ary['sort'])) {
								$method[$key] = $ary['sort'];
							}
						}
					}
				}

				asort($method);

				foreach ($method as $key => $v) {
					if (preg_match('/^extra/', $key)) {
						$k = intval(substr($key, 5));
						if (is_array($entry['extra'][$k])) {
							$entry['extra'][$k] = implode("/", $entry['extra'][$k]);
						}
						$list[$key] = $entry['extra'][$k];

					} else {

						if ($key == "age") {
							$list['birthday'] = $entry['birthday'];
						} else if ($vars[$key]) {
							if (is_array($vars[$key])) {
								foreach (array_keys($vars[$key]) as $k) {
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
			$list['app_status'] = $entry['app_status'];

			if ($this->_condition['opt_cancelled'] == 0) {
				$list['app_cancelled'] = $entry['app_cancelled'];
			}

//(4)セルの値を設定

			if ($list['dept']) {
				$list['dept'] = $codes[23][$list['dept']];
			}

			if ($this->_condition['opt_regist']) {
				foreach ($regist_keys as $key) {
					if ($key == "password") {continue;}
					if ($key == "dept") {$entry[$key] = $codes[23][$entry[$key]];}
					$list['regist_' . $key] = $entry[$key];
				}

			}

			$col = 0;
			foreach ($list as $key => $value) {

				if ($format["$key"] && $value) {$value = sprintf($format["$key"], $value);}
				$sheet->getCellByColumnAndRow($col, $row)->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

				if ($list['app_cancelled']) {
					$sheet->getStyleByColumnAndRow($col, $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99999999');
				} else if ($row % 2 == 0) {
					$sheet->getStyleByColumnAndRow($col, $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F8FF');

				}

				$col++;

			}
			$row++;
		}

// エクセルのヘッダー書き出し
		$row = 1;
		$col = 0;
		$keys = array_keys($list);
		foreach ($keys as $value) {
			$sheet->setCellValueByColumnAndRow($col, $row, $value);
			$col++;
		}

		$outputfile = COMPONENT . date('Ymd_H-i-s') . '.xlsx';

// Excel2007
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $outputfile . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xl);
		$writer->save('php://output');

		exit();

	}

	public function exportSpreadSheet4Transition() {

		$vars = array_merge($this->_fields_extension, $this->_fields_extension_app);

		foreach ($this->_fields_phonenumber as $field) {
			$vars[$field] = null;
		}

		$vars['membership'] = null;

		$xl = $this->readySpreadSheet('format_transition.xlsx');

//(3)シートの設定
		$xl->setActiveSheetIndex(0);

//		$sheet = $xl->getActiveSheet();
		//		$sheet->setTitle(COMPONENT);

//		$sheet->getDefaultStyle()->getFont()->setName(mb_convert_encoding('MS PGothic', 'UTF-16LE', 'UTF-8'));

		$codes = $this->getInitCodes();
		$entries = $this->getEntries4Export();
		$regist_keys = $this->getRegistKeys();

		foreach ($entries as $entry) {

			$list = [];

			$list['namef'] = $entry['namef'];
			$list['nameg'] = $entry['nameg'];
			$list['kanaf'] = $entry['kanaf'];
			$list['kanag'] = $entry['kanag'];

			if ($entry['birthday']) {
				$list['birthday'] = substr($entry['birthday'], 0, 4) . '/' . substr($entry['birthday'], 4, 2) . '/' . substr($entry['birthday'], 6, 2);
			}
			$list['number'] = $entry['number'];
//	$list['memberhsip2'] = substr($entry['membership'], 3, 4);
			//	$list['memberhsip3'] = substr($entry['membership'], 7, 4);
			$list['membership'] = strval($entry['membership']);
			$list['graduateyear'] = $entry['graduateyear'];
			$list['email'] = $entry['email'];
			$list['dept'] = $codes[23][$entry['dept']];
			$list['major'] = $entry['major'];

			if ($entry['new_zipcodef'] && $entry['new_zipcodes']) {
				$list['new_zipcodef'] = sprintf('%03d', $entry['new_zipcodef']);
				$list['new_zipcodes'] = sprintf('%04d', $entry['new_zipcodes']);

				$list['new_zipcode'] = '〒' . $list['new_zipcodef'] . '-' . $list['new_zipcodes'];
			}
			$list['new_address'] = $entry['new_pref'] . $entry['new_addressf'];
			if ($entry['new_addresss']) {
				$list['new_address'] .= $entry['new_addresss'];
			}
			if ($entry['new_addresst']) {
				$list['new_address'] .= $entry['new_addresst'];
			}
			$list['mobilephone'] .= $entry['mobilephone'];

			if ($entry['zipcodef'] && $entry['zipcodes']) {
				$list['zipcodef'] = sprintf('%03d', $entry['zipcodef']);
				$list['zipcodes'] = sprintf('%04d', $entry['zipcodes']);

				$list['zipcode'] = '〒' . $list['zipcodef'] . '-' . $list['zipcodes'];
			}
			$list['address'] = $entry['pref'] . $entry['addressf'];
			if ($entry['addresss']) {
				$list['address'] .= $entry['addresss'];
			}
			if ($entry['addresst']) {
				$list['address'] .= $entry['addresst'];
			}

			$list['phonenumber'] = $entry['phonenumber'];

			$list['app_regist_date'] = date('Y-m-d', strtotime($entry['app_regist_date']));

			if ($opt_cancelled == 0) {
				$list['app_cancelled'] = $entry['app_cancelled'];
			}

			$list['no'] = sprintf('%04d', intval($entry['app_count']));

			$list['memo'] = $entry['memo'];

			$list['extra'] = json_decode($entry['extra'], true);

			$template = $xl->getSheet(0)->copy();

			$template->setTitle($list['no']);

			$xl->addSheet($template, $si + 1);
			$xl->setActiveSheetIndex($si + 1);
			$sheet[$si] = $xl->getActiveSheet();

//	$sheet[$si]->getDefaultStyle()->getFont()->setName('ＭＳ 明朝');
			//	$sheet[$si]->getDefaultStyle()->getFont()->setSize(10);

			$sheet[$si]->getCell('AN1')->setValue($list['app_regist_date']);
			$sheet[$si]->getCell('H5')->setValue($list['kanaf']);
			$sheet[$si]->getCell('R5')->setValue($list['kanag']);
			$sheet[$si]->getCell('H7')->setValue($list['namef']);
			$sheet[$si]->getCell('R7')->setValue($list['nameg']);
			$sheet[$si]->getCell('AN5')->setValue($list['birthday']);
			$sheet[$si]->getCell('AN8')->setValue($list['number']);
			$sheet[$si]->getCell('H11')->setValue($list['membership']);
			$sheet[$si]->getCell('AN11')->setValue($list['graduateyear']);
			$sheet[$si]->getCell('H14')->setValue($list['email']);
			$sheet[$si]->getCell('H16')->setValue($list['dept']);
			$sheet[$si]->getCell('H19')->setValue($list['major']);

			$sheet[$si]->getCell('H22')->setValue($list['new_zipcode']);
			$sheet[$si]->getCell('H24')->setValue($list['new_address']);
			$sheet[$si]->getCell('AN22')->setValue($list['mobilephone']);

			$sheet[$si]->getCell('H28')->setValue($list['zipcode']);
			$sheet[$si]->getCell('H30')->setValue($list['address']);
			$sheet[$si]->getCell('AN28')->setValue($list['phonenumber']);
			$sheet[$si]->getCell('AF38')->setValue($list['memo']);
			if ($list['extra'][1]) {
				$sheet[$si]->getCell('Z38')->setValue($list['extra'][1]);
			}
			$si++;

		}

		$outputfile = COMPONENT . date('Ymd_H-i-s') . '.xlsx';

// Excel2007
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $outputfile . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xl);
		$writer->save('php://output');

	}

	private function readySpreadSheet($_format = null) {

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		$format = ETC_DIR . ADM_DIR . "templates/" . COMPONENT . "/template.xlsx";
		if ($_format) {
			$format = ETC_DIR . ADM_DIR . "templates/" . COMPONENT . "/" . $_format;
		}

		$xl = $reader->load($format);

		return $xl;
	}

	public function getEntries4Export() {

// SQLを作成する
		$where = [];
		$data = [];
		$sql = <<< HERE
SELECT
a.*,
a.regist_date as app_regist_date,
a.cancelled as app_cancelled,
a.status as app_status,
r.*,
c.denomination as category_denomination
 FROM app AS a, entry_category AS c,regist AS r
WHERE a.category_id = c.id AND r.id = a.regist_id

HERE;

		if ($this->_condition['category_id']) {
			$data[':category_id'] = $this->_condition['category_id'];
			array_push($where, "a.category_id = :category_id");
		}

		if ($this->_condition['opt_cancelled']) {
			$data[':cancelled'] = 0;
			array_push($where, "IFNULL(a.cancelled,0) = :cancelled");
		}
		if ($this->_condition['opt_archived']) {
			$data[':archived'] = 0;
			array_push($where, "IFNULL(a.archived,0) = :archived");
		}
		if ($this->_condition['opt_set_year']) {
			$data[':set_year'] = $this->_condition['opt_set_year'];
			array_push($where, " SUBSTRING(a.holdername,1,2) = :set_year");
		}
		if ($this->_condition['opt_status']) {
			$data[':status'] = $this->_condition['opt_status'];
			array_push($where, "IFNULL(a.status,0) = :status");
		}

		if ($this->_condition['opt_component']) {
			$data[':component'] = $this->_condition['opt_component'];
			array_push($where, "a.component = :component");
		} else {
			$data[':component'] = COMPONENT;
			array_push($where, "a.component = :component");
		}

		if ($this->_condition['comedate']) {
			$data[':comedate'] = $this->_condition['comedate'];
			array_push($where, "a.comedate = :comedate");
		}

		if (isset($this->_condition['opt_status'])) {
			$data[':status'] = $this->_condition['opt_status'];
			array_push($where, "IFNULL(a.status,0) = :status");
		}

		if (count($where)) {
			$sql .= " AND " . implode("\nAND ", $where) . " \n ";
		}

// order句を連結する
		$sql .= "ORDER BY a.id ";
		$sql .= ($params['sort_order'] == 'descend') ? 'DESC' : 'ASC';
		$sql .= "\n";

// クエリを実行する

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("DataBase Error", 1);
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