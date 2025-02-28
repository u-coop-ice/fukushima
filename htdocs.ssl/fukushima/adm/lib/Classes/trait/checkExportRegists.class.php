<?php
trait checkExportRegists {

	public function exportSpreadSheet() {

		$this->sanitizeCondition();

		$regists = $this->getRegists();

		if (!$regists) {
			throw Exception('書き出すデータはありません。');
		}

		ini_set('default_charset', 'UTF-8');

		$xl = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$xl->getDefaultStyle()->getFont()->setName('MS PGothic');
		$xl->getDefaultStyle()->getFont()->setSize(11);

		$sheet = $xl->getActiveSheet();
		$sheet->setTitle('regist');

		$row = 2;

		foreach ($regists as $regist) {

//(4)セルの値を設定
			$col = 0;
			foreach ($regist as $key => $value) {

				if ($key == "rank") {$value = $rankList[$value];}

				if ($key == 'dept') {
					$value = $codes[23][$value];
				}

				if ($key == "extra") {

					$extras = json_decode($value, true);
					if (count($extras)) {
						foreach ($extras as $k => $extra) {
							if (is_array($extra)) {$extra = implode('/', $extra);}

							$sheet->getCellByColumnAndRow($col, $row)->setValueExplicit($extra, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

							$col++;
						}

					}
				} else {
					if ($format["$key"] && $value) {$value = sprintf($format["$key"], $value);}
					$sheet->getCellByColumnAndRow($col, $row)->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$col++;
				}
			}

			$keys = array_keys($regist);

			$row++;
		}

		if ($row == "2") {
			throw Exception('書き出すデータはありません。');
		}

// エクセルのヘッダー書き出し
		$row = 1;
		$col = 0;
		foreach ($keys as $value) {
			$sheet->setCellValueByColumnAndRow($col, $row, $value);

			$sheet->getStyleByColumnAndRow($col, $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFCC33');
			$col++;
		}

		$outputfile = 'entry' . date('Ymd_H-i-s') . '.xlsx';

// Excel2007
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $outputfile . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xl);
		$writer->save('php://output');

	}

}