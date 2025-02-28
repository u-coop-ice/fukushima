<?php
trait execEntryCalendar {

	private $_year;
	private $_month;
	private $_day;
	private $_before;
	private $_open;
	private $_comedate;
	private $_cometime;
	private $_setDayList;
	private $_setOverDay;
	private $_selected;

	public function set_year($_year) {return $this->_year = $_year;}
	public function set_month($_month) {return $this->_month = $_month;}
	public function set_day($_day) {return $this->_day = $_day;}
	public function set_before($_before) {return $this->_before = $_before;}

	public function set_comedate($_comedate) {return $this->_comedate = $_comedate;}
	public function set_cometime($_cometime) {return $this->_cometime = $_cometime;}
	public function set_selected($_selected) {return $this->_selected = $_selected;}

	public function get_setDayList() {return $this->_setDayList;}
	public function get_setOverDay() {return $this->_setOverDay;}

	public function get_calendar() {
		$this->selectCalendar();
		return $this->_calendar;
	}

	private function selectCalendar() {

		$sql = "SELECT * FROM entry_calendar WHERE component = :component AND category_id = :category_id";

		$data[':component'] = COMPONENT;
		$data[':category_id'] = $this->_category_id;

		if ($this->_component) {
			$data[':component'] = $this->_component;
		}
		if ($this->_part) {
			$data[':part'] = $this->_part;
		}

		if ($this->_day) {
			$sql .= " AND `date` = :date";
			$data[':date'] = $this->_day;
		} else if ($this->_before) {
			$sql .= " AND `date` + INTERVAL " . $this->_before . " DAY > CURDATE() ";
		}
		if ($this->_open == 1) {
			$sql .= " AND `open` = 1";
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
			$this->displayError();
		}

		$this->_calendar = $res->fetchAll();
	}

	public function saveSelectTime() {

		$sstdata['component'] = COMPONENT;
		if (defined('PART')) {
			$sstdata['part'] = PART;
		}
		$sstdata['category_id'] = intval($_POST['category_id']);

		$sstdata['special'] = intval($_POST['special']);
		$sstdata['open'] = intval($_POST['open']);

		$sstdata['date'] = htmlspecialchars($_POST["date"], 3, "UTF-8");
		$sstdata['opt_stock'] = intval($_POST["opt_stock"]);

		$select_time = htmlspecialchars(trim($_POST["select_time"]), 3, "UTF-8");

		if ($select_time) {

//select_timeのjson化

			$select_timet = str_replace(array("\r\n", "\r", "\n"), "\t", trim($select_time));
			$select_times = explode("\t", $select_timet);

			$stk = [];
			foreach ($select_times as $time) {
				$times = explode(',', $time);
				$stk[$sstdata['date']][$times[0]] = array('stock' => intval($times[1]));
			}

			$sstdata['select_time'] = json_encode($stk);
		} else {
			$sstdata['special'] = 0;
			$sstdata['opt_stock'] = 0;
			$sstdata['select_time'] = null;
		}

		$this->set_day($sstdata['date']);
		$this->set_category_id($sstdata['category_id']);
		$calendar = $this->get_calendar();

		if (!empty($calendar)) {
			$sstdata['id'] = $calendar[0]['id'];
		}

		$fields = array(
			'open' => 'integer',
			'special' => 'integer',
			'select_time' => 'text',
			'date' => 'text',
			'component' => 'text',
			'part' => 'text',
			'category_id' => 'integer',
			'opt_stock' => 'integer',
			'status' => 'integer',
		);

		$this->set_fields($fields);
		$this->set_tbl('entry_calendar');
		$this->set_postdata($sstdata);

//一旦入力内容を保存
		if (isset($sstdata['id'])) {
			$this->set_where(['id' => 'integer']);
			$this->updateTable();
		} else {
			$this->insertTable();
		}

//在庫の更新
		$this->set_comedate($sstdata['date']);
		$this->updateSelectTime();

		$sstdata['select_time'] = $select_time;
		return $sstdata;
	}

	public function checkReserveRest() {

		$scd = $this->getSpecialTime();

		if ($this->_opt_stock) {

			if ($scd["special"]) {
				$tp = json_decode($scd["select_time"], true);

				$stks = $tp[$this->_comedate][$this->_cometime];
				if (!isset($stks['ct'])) {
					$stks['ct'] = 0;
				}
				if (is_numeric($this->_pre_count)) {
					$stks['ct'] = $this->_pre_count;
				}
//在庫判定

				$rest_error = $stks['stock'] - $stks['ct'];
				$rest_error += -1;
				if ($rest_error < 0) {
					throw new Exception("申し訳ございません。予定数を超過しましたので、選択された日時でのお申込みはできません。他の時間・日程で選択してください", 6);
				}
			}
		}

	}

	public function updateSelectTime() {
		$data = [];
		$where = [];

		$scd = $this->getSpecialTime();

		$st = json_decode($scd['select_time'], true);

		$this->_select_time = $st;

		$select_time = $this->getSelectTime();

		$sql = <<< HERE
UPDATE entry_calendar SET `select_time`= :select_time,`status`= :status

HERE;

		$data[':select_time'] = $select_time;
		$data[':status'] = $this->_status;

		array_push($where, "date = :date", "component = :component");
		$data[':date'] = $this->_comedate;
		$data[':component'] = COMPONENT;

		if (defined('PART')) {
			array_push($where, "part = :part");
			$data[':part'] = PART;
		}

		if ($this->_component) {
			$data[':component'] = $this->_component;
		}
		if ($this->_part) {
			$data[':part'] = $this->_part;
		}

		array_push($where, "category_id = :category_id");
		$data[':category_id'] = $this->_category_id;

		if (count($where)) {
			$sql .= ' WHERE ' . implode(' AND ', $where);
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("Database Error", 1);
		}
		return;
	}

	public function getSelectTime() {

		$ct = $this->getCountReserveApp();
		$stk = $this->_select_time;

		$result = null;
		$this->_status = null;

//status更新

		if (is_array($ct)) {
			$result = $ct;
			if (is_array($stk)) {
				$this->_status = -9;
				foreach ($stk as $d => $st) {
					foreach ($st as $t => $v) {
						if (intval($stk[$d][$t]['stock']) - intval($ct[$d][$t]['ct']) > 0) {
							$this->_status = null;
						}
						unset($stk[$d][$t]['ct']);
					}
				}

//				$result = array_merge_recursive($ct, $stk);
				$result = array_merge_recursive($stk, $ct);
			}
		} else {

			if (is_array($stk)) {
				$this->_status = -9;
				foreach ($stk as $d => $st) {
					foreach ($st as $t => $v) {
						if ($stk[$d][$t]['stock'] > 0) {
							$this->_status = null;
						}
					}
				}
				$result = $stk;
			} else {
				$result = null;
			}

		}
		if (!$this->_opt_stock) {
			$this->_status = null;
		}

//		if (is_array($result)) {
		//			$result = $this->user_ksort($result);
		//		}
		if (count($result)) {
			$result = json_encode($result);
		} else {
			$result = null;
		}
		return $result;
	}

	private function getSpecialTime() {

		if (isset($this->_pre_scd)) {
			return $scd = $this->_pre_scd;
		}

		$where = [];
		$data = [];

		array_push($where, "`date` = :date");
		$this->_day = $this->_comedate;

		$scd = $this->get_calendar();
		$this->_opt_stock = $scd[0]['opt_stock'];
		return $scd[0];
	}

	public function getSetDays() {

//サポセン営業日の取得

		$scds = array();

		$this->_open = 1;

		$scds = $this->get_calendar();

		$ct = $this->getDefaultTime();

		$setDay = [];
		$setOverDay = [];
		$setDayList = [];

		foreach ($scds as $key => $sc) {
			if (time() + 60 * 60 * intval($ct["limit_time"]) > strtotime($sc["date"])) {continue;}

			array_push($setDay, "'" . $sc["date"] . "'");
			if (isset($this->_pre_comedate) && $sc["date"] == $this->_pre_comedate) {
				array_push($setDayList, $sc["date"]);
			} else if ($sc["status"] == -9) {
				array_push($setOverDay, "'" . $sc["date"] . "'");
			} else {
				array_push($setDayList, $sc["date"]);
			}
		}
		asort($setDay);
		$this->_setDayList = $setDayList;
		$this->_setOverDay = $setOverDay;

		if (!count($setDay)) {
			throw new Exception("選択可能日がありません。", 1);
		}

		return $setDay;
	}

	private function getDefaultTime() {

		$where = array();
		$data = array();

		$sql = "SELECT select_time,date_limit,limit_time FROM entry_category";

		array_push($where, "id = :category_id");
		$data[':category_id'] = $this->_category_id;

		array_push($where, "component = :component");
		$data[':component'] = COMPONENT;

		if (defined('PART')) {
			array_push($where, "part = :part");
			$data[':part'] = PART;
		}

		if (count($where)) {
			$sql .= ' WHERE ' . implode(' AND ', $where);
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error" . $e->getMessage(), 1);
		}

		$scb = $res->fetch();
		return $scb;
	}

	public function getOptionTime() {

		$scb = $this->getDefaultTime();
		$scd = $this->getSpecialTime();

		$tmp = array();
		$disabled = array();
		if ($scd["special"]) {
			$tp = json_decode($scd["select_time"], true);
			if (count($tp[$this->_comedate])) {
				foreach ($tp[$this->_comedate] as $t => $v) {
					if (isset($v['stock'])) {
						array_push($tmp, $t);
						if ($this->_opt_stock) {
							if (!isset($v['ct'])) {$v['ct'] = 0;}
							if (intval($v['ct']) - intval($v['stock']) >= 0) {
								$disabled[$t] = 1;
							}
						}
					}
				}
			}
		} else {
			$tmp = json_decode($scb["select_time"], true);
		}

		if (count($tmp) == 1) {
			if (isset($disabled[$tmp[0]]) && $disabled[$tmp[0]]) {
				$select = '<p class="form-control-static">【終了】' . $tmp[0] . '</p>';
				if ($this->_admin) {
					$select .= '<input type="hidden" name="cometime" value="' . $tmp[0] . '"/>';
				}
				$ck = 0;
			} else {
				$select = '<p class="form-control-static">' . $tmp[0] . '</p><input type="hidden" name="cometime" value="' . $tmp[0] . '"/>';
				$ck = 1;
			}
		} else {

			$ov = array();
			$stock_error = 0;
			if (count($tmp)) {
				$select = '<select	name="cometime" id="cometime" class="form-control input-lg validate[required]">';
				$select .= "<option value=''></option>";
				foreach ($tmp as $time) {
					if (isset($disabled[$time]) && $disabled[$time]) {
						if ($this->_admin) {
//					$select .= '<option disabled="disabled">' . '【満席】' . $time . '</option>';
							$select .= '<option value="' . $time . '">' . '【終了】' . $time . '</option>';
						} else {
							$select .= '<option disabled="disabled">' . '【終了】' . $time . '</option>';
						}
						array_push($ov, 0);
					} else {
						if ($time == $this->_selected) {
							$select .= "<option value='" . $time . "' selected='selected'>" . $time . "</option>";
						} else {
							$select .= "<option value='" . $time . "'>" . $time . "</option>";
						}
						array_push($ov, 1);
					}
					$ck = array_sum($ov);
				}
				$select .= '</select>';
			}
		}

		if ($ck == 0) {$stock_error = 1;}
		$result = array('stock_error' => $stock_error, 'select' => $select);
		return json_encode($result);

	}

	public function getCountReserveApp() {
		$data = [];
		$where = [];
		$sql = <<< HERE
SELECT COUNT(id) AS ct,comedate,cometime FROM app

HERE;

		if (!$this->_category_id) {
			throw new Exception("NO category_id", 1);
		}
		array_push($where, " `category_id` = :category_id ");
		$data[':category_id'] = $this->_category_id;

		if ($this->_comedate) {
			array_push($where, " `comedate` = :comedate ");
			$data[':comedate'] = $this->_comedate;
		}

		array_push($where, "component = :component");
		$data[':component'] = COMPONENT;

		if (defined('PART')) {
			array_push($where, "part = :part");
			$data[':part'] = PART;
		}

// クエリを実行する
		if ($this->_component) {
			$data[':component'] = $this->_component;
		}
		if ($this->_part) {
			$data[':part'] = $this->_part;
		}

		array_push($where, " IFNULL(cancelled,0) < 1 ");

		$sql .= ' WHERE ' . implode(' AND ', $where);

		$sql .= ' GROUP BY `comedate`,`cometime`';

		$sql .= " FOR UPDATE";

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$this->_smarty->assign('db_error', 1);
			return;
		}
		$reserves = array();
		while ($r = $res->fetch()) {
			$reserves[$r['comedate']][$r['cometime']] = array('ct' => $r['ct']);

		}
		return $reserves;
	}

}
?>