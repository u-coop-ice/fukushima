<?php
trait baseFunction {

//トップに戻す
	static function return2First() {
		HTTP_Session2::set('postdata', []);
		global $init_url;
		header("Location: " . $init_url);
	}

	static function initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket = null) {
		if ($dbsocket) {
			$dsn = 'mysql:unix_socket=' . $dbsocket . ';dbname=' . $database;
		} else {
			$dsn = 'mysql:host=' . $dbhost . ';dbname=' . $database . ';';
		}
		$driver_options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		);

		try {
			$pdo = new PDO($dsn, $dbuser, $dbpass, $driver_options);

		} catch (PDOException $e) {
			exit('データベースに接続できませんでした。' . $e->getMessage());
		}

		return $pdo;
	}

	protected $_tmpl;
	protected $_condition;

	public function setTmpl(string $_tmpl) {
		return $this->_tmpl = $_tmpl;
	}

	public function set_condition(array $_condition) {
		$this->_condition = $_condition;
	}

	private $_fields_phonenumber = [
		'mobilephone',
		'student_phone',
		'phonenumber',
		'parent_mobile',
		'parent_com_phone',
		'fax',
		'telephone',
		'ship_from_phonenumber',
		'ship_phonenumber',
	];

	private $_fields_extension = [

		'email' => ['email' => 'text', 'emailcfrm' => 'text'],
		'name' => ['namef' => 'text', 'nameg' => 'text', 'kanaf' => 'text', 'kanag' => 'text'],

		'mobilephone' => ['mobilephone1' => 'text', 'mobilephone2' => 'text', 'mobilephone3' => 'text'],
		'student_phone' => ['student_phone1' => 'text', 'student_phone2' => 'text', 'student_phone3' => 'text'],

		'parent_name' => ['parent_namef' => 'text', 'parent_nameg' => 'text', 'parent_kanaf' => 'text', 'parent_kanag' => 'text'],

		'phonenumber' => ['phonenumber1' => 'text', 'phonenumber2' => 'text', 'phonenumber3' => 'text'],
		'parent_mobile' => ['parent_mobile1' => 'text', 'parent_mobile2' => 'text', 'parent_mobile3' => 'text'],
		'parent_com_phone' => ['parent_com_phone1' => 'text', 'parent_com_phone2' => 'text', 'parent_com_phone3' => 'text'],

		'telephone' => ['telephone1' => 'text', 'telephone2' => 'text', 'telephone3' => 'text'],
		'fax' => ['fax1' => 'text', 'fax2' => 'text', 'fax3' => 'text'],

		'membership' => ['membership1' => 'text', 'membership2' => 'text', 'membership3' => 'text'],

		'age' => ['birth_year' => 'text', 'birth_month' => 'text', 'birth_day' => 'text'],

		'address' => ['zipcodef' => 'integer', 'zipcodes' => 'integer', 'pref' => 'text', 'addressf' => 'text', 'addresss' => 'text', 'addresst' => 'text',
		],

		'new_add' => ['new_add' => 'integer', 'new_zipcodef' => 'integer', 'new_zipcodes' => 'integer', 'new_pref' => 'text', 'new_addressf' => 'text', 'new_addresss' => 'text', 'new_addresst' => 'text',
		],

		'dept' => ['dept' => 'integer'],
		'major' => ['major' => 'text'],

		'number' => ['number' => 'text'],
		'sex' => ['sex' => 'integer'],

	];

	private $_fields_extension_must = [
		'email' => ['email' => 'text', 'emailcfrm' => 'text'],
		'name' => ['namef' => 'text', 'nameg' => 'text', 'kanaf' => 'text', 'kanag' => 'text'],

		'mobilephone' => ['mobilephone1' => 'text', 'mobilephone2' => 'text', 'mobilephone3' => 'text'],
		'student_phone' => ['student_phone1' => 'text', 'student_phone2' => 'text', 'student_phone3' => 'text'],

		'phonenumber' => ['phonenumber1' => 'text', 'phonenumber2' => 'text', 'phonenumber3' => 'text'],
		'parent_mobile' => ['parent_mobile1' => 'text', 'parent_mobile2' => 'text', 'parent_mobile3' => 'text'],
		'parent_com_phone' => ['parent_com_phone1' => 'text', 'parent_com_phone2' => 'text', 'parent_com_phone3' => 'text'],
		'telephone' => ['telephone1' => 'text', 'telephone2' => 'text', 'telephone3' => 'text'],
		'fax' => ['fax1' => 'text', 'fax2' => 'text', 'fax3' => 'text'],

		'membership' => ['membership1' => 'text', 'membership2' => 'text', 'membership3' => 'text'],
		'birthday' => ['birth_year' => 'text', 'birth_month' => 'text', 'birth_day' => 'text'],

		'address' => ['zipcodef' => 'integer', 'zipcodes' => 'integer', 'pref' => 'text', 'addressf' => 'text'],
		'new_add' => ['new_add' => 'integer',
		],
	];

	private $_fields_extension_app = [
		'schoolyear' => ['schoolyear' => 'text'],
		'graduateyear' => ['graduateyear' => 'text'],
//		'bank' => ['bankname' => 'text', 'branch' => 'text', 'banksort' => 'text', 'code_bank' => 'integer', 'code_branch' => 'integer', 'account' => 'integer', 'holder' => 'text', 'holderk' => 'text'],
		'bank' => [
			'bank' => 'integer',
			'bank_name' => 'text',
			'bank_branch' => 'text',
			'bank_sort' => 'text',
//			'code_bank' => 'integer',
			'code_branch' => 'integer',
			'bank_account' => 'integer',
//			'bank_holder' => 'text',
			'bank_holder_kana' => 'text',
		],
		'memo' => ['memo' => 'text'],
		'subject' => ['subject' => 'text'],
		'agree' => ['agree' => 'text'],
		'stock_multi' => ['stock_multi' => 'text'],
		'comedate' => ['comedate' => 'text'],
		'cometime' => ['cometime' => 'text'],
		'store' => ['store' => 'text'],

		'ship_to' => [
			'ship_namef' => 'text',
			'ship_nameg' => 'text',
			'ship_kanaf' => 'text',
			'ship_kanag' => 'text',
			'ship_zipcodef' => 'integer',
			'ship_zipcodes' => 'integer',
			'ship_pref' => 'text',
			'ship_addressf' => 'text',
			'ship_addresss' => 'text',
			'ship_addresst' => 'text',
		],

		'ship_address' => [
			'ship_zipcodef' => 'integer',
			'ship_zipcodes' => 'integer',
			'ship_pref' => 'text',
			'ship_addressf' => 'text',
			'ship_addresss' => 'text',
			'ship_addresst' => 'text',
		],

		'ship_phonenumber' => [
			'ship_phonenumber1' => 'text',
			'ship_phonenumber2' => 'text',
			'ship_phonenumber3' => 'text',
		],

		'ship_from' => [
			'ship_from' => 'integer',
			'ship_from_name' => 'text',
			'ship_from_kana' => 'text',
			'ship_from_zipcodef' => 'integer',
			'ship_from_zipcodes' => 'integer',
			'ship_from_pref' => 'text',
			'ship_from_addressf' => 'text',
			'ship_from_addresss' => 'text',
			'ship_from_addresst' => 'text',
		],

		'ship_from_phonenumber' => [
			'ship_from_phonenumber1' => 'text',
			'ship_from_phonenumber2' => 'text',
			'ship_from_phonenumber3' => 'text',
		],
	];

	private $_fields_extension_app_must = [
		'ship_from' => [
			'ship_from' => 'integer',
			'ship_from_zipcodef' => 'integer',
			'ship_from_zipcodes' => 'integer',
			'ship_from_pref' => 'text',
			'ship_from_addressf' => 'text',
		],
		'ship_to' => [
			'ship_namef' => 'text',
			'ship_nameg' => 'text',
			'ship_kanaf' => 'text',
			'ship_kanag' => 'text',
			'ship_zipcodef' => 'integer',
			'ship_zipcodes' => 'integer',
			'ship_pref' => 'text',
			'ship_addressf' => 'text',
		],

		'ship_address' => [
			'ship_zipcodef' => 'integer',
			'ship_zipcodes' => 'integer',
			'ship_pref' => 'text',
			'ship_addressf' => 'text',
		],

	];

	static function explodePhonenumber(string $_number, string $_field) {
		if (!$_number) {return;}

		$tmp = explode('-', $_number);
		if (count($tmp) == 3) {
			foreach ($tmp as $i => $v) {
				$tmp[$_field . ($i + 1)] = $v;
			}
		}
		return $tmp;

	}

	static function formatPhonenumber(string $_field, array $_values) {
		if (!$_field) {return;}

		if ($_values[$_field . '1'] && $_values[$_field . '2'] && $_values[$_field . '3']) {
			$tmp = mb_convert_kana($_values[$_field . '1'], 'rn') . '-' . mb_convert_kana($_values[$_field . '2'], 'rn') . '-' . mb_convert_kana($_values[$_field . '3'], 'rn');
		}
		return $tmp;

	}

	static function formatMembership(array $_values) {

		if ($_values['membership1'] && $_values['membership2'] && $_values['membership3']) {
			$tmp = mb_convert_kana($_values['membership1'], 'n') . mb_convert_kana($_values['membership2'], 'n') . mb_convert_kana($_values['membership3'], 'n');
		}
		return $tmp;

	}

	static function formatBirthday(array $_values) {
		if ($_values['birth_year'] && $_values['birth_month'] && $_values['birth_day']) {
			$tmp = mb_convert_kana($_values['birth_year'], 'n') . sprintf('%02d', mb_convert_kana($_values['birth_month'], 'n')) . sprintf('%02d', mb_convert_kana($_values['birth_day'], 'n'));
		}
		return $tmp;

	}

	static function checkPhonenumber($_string) {
		if (!preg_match('/^([0-9]{2,})\-([0-9]{2,})\-([0-9]{4,})$/', $_string)) {
			return false;
		} else if (strlen($_string) > 13) {
			return false;
		}
		return true;
	}

	static function checkNumber($_string) {
		if (!preg_match('/^[0-9]+$/', $_string)) {
			return false;
		}
		return true;
	}

	static function checkStringAlnum($_string) {

		if (!preg_match("/^[a-zA-Z0-9]+$/", $_string)) {
			return false;
		}
		return true;
	}

	static function checkStringLength($_string, $_min = null, $_max = null) {

		$length = mb_strlen($_string);

		if ($_min) {
			if ($length < $_min) {
				return false;
			}
		}

		if ($_max) {
			if ($length > $_max) {
				return false;
			}
		}
		return true;
	}

	static function checkFreshness($_date) {
		if (!$_date) {return true;}

		if (strtotime($_date) < time() - 60 * 60 * 1) {
			return false;
		}
		return true;
	}

	static public function calc_age($by = null, $bm = null, $bd = null) {
		if (!$by) {return;}
		if (strlen($by) == 8) {
			$bm = intval(substr($by, 4, 2));
			$bd = intval(substr($by, 6, 2));
			$by = intval(substr($by, 0, 4));
		}
		if (!$bm) {return;}
		if (!$bd) {return;}

		$ty = date("Y");
		$tm = date("m");
		$td = date("d");
		$age = $ty - $by;

		if ($tm * 100 + $td < $bm * 100 + $bd) {
			$age--;
		}

		return $age;
	}

	static function my_htmlspecialchars(string $_string = null) {
		if (!is_string($_string)) {return;}
		$_string = mb_convert_kana($_string, 'rnKV');
		$_string = htmlspecialchars($_string, 3, 'UTF-8');
		return $_string;
	}

//日数計算
	static function calcNights($_t1, $_t2) {
		$night = intval(abs(strtotime($_t2) - strtotime($_t1)) / 24 / 60 / 60);
		return $night;
	}

	private function execSanitize($_fields, $_fields_must) {

		$this->_input_error = [];
		$postdata = $this->baseSanitize($_fields, $_fields_must);

		if (count($this->_input_error) > 0) {
			$this->_smarty->assign('post', $postdata);
			$this->_smarty->assign('error', $this->_input_error);
			throw new Exception("入力エラー", 9);
		}

		return $postdata;
	}

	private function fields_transform(array $_fields, array $_fields_must = null) {
		$this->_fields = [];
		$this->_fields_must = [];
		$this->_fields_sql = [];
		$this->_fields_sql_app = [];

		if ($this->_simple_name) {
			$this->_fields_extension['name'] = ['name' => 'text'];
			$this->_fields_extension_must['name'] = ['name' => 'text'];
		}

		if ($this->_skip_emailcfrm) {
			$this->_fields_extension['email'] = ['email' => 'text'];
			$this->_fields_extension_must['email'] = ['email' => 'text'];
		}

		foreach ($_fields as $field => $v) {
			if ($this->_fields_extension[$field]) {
				$this->_fields = array_merge($this->_fields, $this->_fields_extension[$field]);
				if ($_fields_must[$field]) {
					if (is_array($this->_fields_extension_must[$field])) {
						$this->_fields_must = array_merge($this->_fields_must, $this->_fields_extension_must[$field]);
					} else {
						$this->_fields_must = array_merge($this->_fields_must, $this->_fields_extension[$field]);
					}
				}
				switch ($field) {
				case 'address';
				case 'new_add';
				case 'name';
				case 'parent_name';
					$this->_fields_sql = array_merge($this->_fields_sql, $this->_fields_extension[$field]);
					break;
				case 'age';
					$this->_fields_sql = array_merge($this->_fields_sql, ['birthday' => 'text']);
					break;

				default:
					if ($v == 1) {
						$this->_fields_sql[$field] = "text";
					} else {
						$this->_fields_sql[$field] = $v;
					}
				}
			} else if (is_array($this->_fields_extension_app[$field])) {

				$this->_fields = array_merge($this->_fields, $this->_fields_extension_app[$field]);

				switch ($field) {
				case 'ship_from_phonenumber':
				case 'ship_phonenumber':
					$this->_fields_sql_app = array_merge($this->_fields_sql_app, [$field => 'text']);
					break;
				default:
					$this->_fields_sql_app = array_merge($this->_fields_sql_app, $this->_fields_extension_app[$field]);
					break;
				}

				if ($_fields_must[$field]) {
					if ($this->_fields_extension_app_must[$field]) {
						$this->_fields_must = array_merge($this->_fields_must, $this->_fields_extension_app_must[$field]);
					} else {
						$this->_fields_must = array_merge($this->_fields_must, $this->_fields_extension_app[$field]);
					}
				}

			} else if (is_string($this->_fields_extension_app[$field])) {
				$this->_fields[$field] = $this->_fields_extension_app[$field];
				$this->_fields_sql_app[$field] = $this->_fields_extension_app[$field];
				if ($_fields_must[$field]) {
					$this->_fields_must[$field] = $_fields_must[$field];
				}

			} else {
				if (is_string($v)) {
					$this->_fields[$field] = $v;
					if ($_fields_must[$field]) {
						$this->_fields_must[$field] = $_fields_must[$field];
					}
					if (preg_match('/^password/', $field)) {continue;}

					$this->_fields_sql[$field] = $v;
				} else if (is_array($v)) {
					foreach ($v as $f => $ex) {
						$this->_fields[$field][$f] = "text";
						if ($_fields_must[$field][$f]) {
							$this->_fields_must[$field][$f] = "text";
						}
					}
				}
			}
		}
	}

	static private function calcPostValue($_v, $_s) {

		if (is_string($_v)) {

			$result = trim($_v);

			switch ($_s) {
			case 'integer':
				$result = intval($result);
				break;
			case 'float':
				$result = floatval($result);
				break;
			case 'double':
				$result = doubleval($result);
				break;
			case 'text':
			default:
				$result = self::my_htmlspecialchars($result);
				break;
			}
		} else if (is_array($_v)) {

			$result = array_map('trim', $_v);
			switch ($_s) {
			case 'integer':
				$result = array_map('intval', $result);
				break;
			case 'float':
				$result = array_map('floatval', $result);
				break;
			case 'double':
				$result = array_map('doubleval', $result);
				break;
			case 'text':
			default:
				$result = array_map('self::my_htmlspecialchars', $result);
				break;
			}
		}
		return $result;
	}

	private function baseSanitize(array $_fields, array $_fields_must = null) {

		$this->_input_error = [];
		$this->fields_transform($_fields, $_fields_must);
		$fields = $this->_fields;

		$values = [];
		if (is_array($this->_postdata) && count($this->_postdata)) {
			$_values = $this->_postdata;
		}

		if (isset($_POST['new_add'])) {
			if (intval($_POST['new_add']) == 3) {
				unset($this->_fields_must['student_phone1']);
				unset($this->_fields_must['student_phone2']);
				unset($this->_fields_must['student_phone3']);
			}
		}

		foreach ($fields as $_field => $_v) {

			if ($_field == "extra") {
				foreach ($_v as $i => $_ex) {

					$_values[$_field][$i] = self::calcPostValue($_POST[$_field][$i], $_ex);

					if ($this->_fields_must[$_field][$i]) {

						if (is_string($_values[$_field][$i]) || is_numeric($_values[$_field][$i])) {

							if ($_ex == 'integer') {
								if ($_values[$_field][$i] == 0) {
									$this->_input_error[$_field][$i] = 1;
								}
							} else if ($_ex != 'integer') {
								if ($_values[$_field][$i] == '') {
									$this->_input_error[$_field][$i] = 1;
								}
							} else if (!isset($_values[$_field][$i])) {
								$this->_input_error[$_field][$i] = 1;
							}
						} else if ($_values[$_field][$i]) {
							if (count($_values[$_field][$i]) == 0) {
								$this->_input_error[$_field][$i] = 1;
							}
						} else {
							$this->_input_error[$_field][$i] = 1;
						}
					}
				}

			} else {
				$_values[$_field] = self::calcPostValue($_POST[$_field], $_v);

				if ($this->_fields_must[$_field]) {

					if (is_string($_values[$_field]) || is_numeric($_values[$_field])) {

						if ($_v == 'integer') {
							if ($_values[$_field] == 0) {
								$this->_input_error[$_field] = 1;
							}
						} else if ($_v != 'integer') {
							if ($_values[$_field] == '') {
								$this->_input_error[$_field] = 1;
							}
						} else if (!isset($_values[$_field])) {
							$this->_input_error[$_field] = 1;
						}

					} else if (is_array($_values[$_field])) {
						if (!isset($_values[$_field]) || count($_values[$_field]) == 0) {
							$this->_input_error[$_field] = 1;
						}

					} else {
						$this->_input_error[$_field] = 1;
					}
				}
			}
		}

//新住所のチェック
		if ($_fields_must['new_add']) {
			switch ($_values['new_add']) {
			case 1:
				foreach (['new_zipcodef' => 'integer', 'new_zipcodes' => 'integer', 'new_pref' => 'text', 'new_addressf' => 'text'] as $_field => $_v) {

					if ($_v == 'integer') {
						if ($_values[$_field] == 0) {
							$this->_input_error[$_field] = 1;
						}
					} else if ($_v != 'integer') {
						if ($_values[$_field] == '') {
							$this->_input_error[$_field] = 1;
						}
					} else if (!isset($_values[$_field])) {
						$this->_input_error[$_field] = 1;
					}

				}
				break;
			case 3:
				foreach (['new_zipcodef' => 'integer', 'new_zipcodes' => 'integer', 'new_pref' => 'text', 'new_addressf' => 'text', 'new_addresss' => 'text', 'new_addresst' => 'text', 'student_phone1' => 'text', 'student_phone2' => 'text', 'student_phone3' => 'text'] as $_field => $_v) {

					$_values[$_field] = '';
				}
				break;
			}
		}

//口座番号のチェック
		if ($_fields_must['bank']) {
			switch ($_values['bank']) {
			case 1: //ゆうちょ
				unset($this->_input_error['code_branch']);
				break;
			}
		}

		foreach ($_fields as $_field => $_v) {

//電話番号の整形
			if (in_array($_field, $this->_fields_phonenumber)) {
				$_values[$_field] = self::formatPhonenumber($_field, $_values);
				if ($_values[$_field]) {
					if (!self::checkPhonenumber($_values[$_field])) {
						$this->_input_error['no_number_' . $_field] = 1;
					}
				}
			}
		}

//組合員番号の整形

		if ($_fields['membership']) {
			$_values['membership'] = self::formatMembership($_values);

			if ($_fields_must['membership']) {
				if (!$_values['membership']) {
					$this->_input_error['membership'] = 1;
				}
			}
		}
//生年月日の整形
		if ($_fields['age']) {
			$_values['birthday'] = self::formatBirthday($_values);
		}

		return $_values;
	}

	public function completeBase() {
		$postdata = HTTP_Session2::get('postdata');

		if (isset($postdata['complete']) && $postdata['complete']) {
			throw new Exception("不正なアクセスです。", 9);
		}

		$this->_smarty->assign('post', $postdata);
		HTTP_Session2::set('postdata', ['complete' => 1]);

		$tmpl = 'complete.tpl';
		if ($this->_tmpl) {
			$tmpl = $this->_tmpl;
		}
		$this->_smarty->display($tmpl);
		exit();
	}

	public static function generateUuid() {
		$uuid = md5(uniqid(mt_rand(), true));
		return $uuid;
	}

	static public function zen2han($string) {
		$string = mb_convert_kana($string, "anr", 'UTF-8');
		$string = mb_ereg_replace("ー", "-", $string);
		return $string;
	}

	static function zen2han_more($string) {
		$string = mb_convert_kana($string, 'anrk', 'UTF-8');
		$string = mb_ereg_replace('ー', '-', $string);

		return $string;
	}

	static public function transHyfun($string) {
		$string = mb_ereg_replace("−", "−", $string);
		return $string;
	}

	static public function my_convert_post($arr) {
		if (is_array($arr)) {
			return array_map('my_convert_kana', $arr);
		} else {
			$chg = trim($arr);
			$chg = mb_convert_kana($arr, 'KV');
			$chg = htmlspecialchars($chg, 3, 'UTF-8');

			return $chg;
		}
	}

	static public function checkFormatEmail(string $string) {

		return preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $string);
	}

	static public function checkFormatPassword($string) {
		$string = mb_convert_kana($string, "anr", 'UTF-8');
		return preg_match("/^[a-zA-Z0-9]{8,16}$/", $string);
	}

	static function email_career(int $rank, int $career = null, string $email) {
//キャリアとrankでメール判定
		$em = array();
		if ($rank == 1) {
			if ($career) {
				$em['student_email'] = $email;
				$em['rc_se'] = 1;
			} else {
				$em['student_email_mobile'] = $email;
				$em['rc_sem'] = 1;
			}
		} elseif ($rank == 2) {
			if ($career) {
				$em['parent_email'] = $email;
				$em['rc_pe'] = 1;
			} else {
				$em['parent_email_mobile'] = $email;
				$em['rc_pem'] = 1;
			}
		}

		return $em;
	}

	static function han2zen($string) {

		$before = array('!', '"', '#', '\$', '%', '&', "'", '\(', '\)', '=', '~', '\|', '-', '\^', '\\\\', '`', '\{', '@', '\[', '\+', '\*', '}', ';', ':', ']', '<', '>', '\?', '_', ',', '\.', '/', '｢', '｣');
		$after = array('！', '”', '＃', '＄', '％', '＆', '’', '（', '）', '＝', '〜', '｜', '−', '＾', '￥', '｀', '｛', '＠', '［', '＋', '＊', '｝', '；', '：', '］', '＜', '＞', '？', '＿', '，', '．', '／', '「', '」');

		mb_regex_encoding('UTF-8');
		foreach ($before as $i => $pattern) {
			$replacement = $after[$i];
			$string = mb_ereg_replace($pattern, $replacement, $string);
		}
		$string = mb_ereg_replace("[-ｰ−‐₋]", "-", $string);
		$string = mb_convert_kana($string, "NRKHSV");
		$string = mb_ereg_replace("[-ー]", "−", $string);
		$string = mb_ereg_replace("−", "－", $string);

		return $string;
	}

	static function explode_cumma(string $s) {

		if (!is_array($s)) {
			$s = trim($s);
			$s = explode(',', $s);
		}
		return $s;
	}

	static function removeLineFeed(string $s) {

		$s = str_replace(array("\r\n", "\r", "\n"), "\n", $s);
		$s = preg_replace("/\n{3,}/", "\n\n", $s);
		return $s;
	}

	static function validateDate($date, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	static function calc_mobilephone($string) {
		if (preg_match('/^050/', $string)) {
			$type = false;
		} elseif (preg_match("/^0\d0/", $string)) {
			$type = true;
		} else {
			$type = false;
		}

		return $type;
	}

}
?>