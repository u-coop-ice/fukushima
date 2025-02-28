<?php
Trait baseEntry {

	protected $_entry_code;

	public function get_entry_code() {
		return $this->_entry_code;
	}
	public function set_entry_code($_entry_code) {
		$this->_entry_code = $_entry_code;
	}

	protected function setTblView() {
		return $this->_view = 1;
	}

	private function saveBaseEntry($_fields, $_fields_must, $_skip_update_regist = null) {

		$postdata = $this->execSanitize($_fields, $_fields_must);

		if (isset($_fields['category_id'])) {
			if (is_array($postdata['category_id'])) {

				if (count($postdata['category_id']) > 2) {
					throw new Exception("業種の設定は2個までです", 1);
				}

				$postdata['category_id'] = json_encode(["category_id" => $postdata['category_id']]);
			} else {
				$postdata['category_id'] = null;
			}
			$_fields['category_id'] = 'text';
		}
		if (isset($_fields['area'])) {
			$this->_flag_area = 1;
			unset($_fields['area']);
			unset($_fields_must['area']);
		}

		if ($this->_add_title_arbeit) {
			$postdata['title'] .= "のお仕事";
		}

		if ($this->_entry_code) {
//募集情報更新データ
			$postdata['code'] = $this->_entry_code;
			$this->set_postdata($postdata);
			$this->set_tbl($this->_pfx . 'entry');
			$this->set_fields($_fields);
			$this->set_where(['code' => 'text']);
			$this->updateTable();

			if (is_null($_skip_update_regist)) {
				if ($this->_regist_status == -9) {

					$this->_fields_regist['email'] = 'text';
					$this->_skip_emailcfrm = 1;
					$registdata = $this->execSanitize($this->_fields_regist, $this->_fields_regist_must);
					$registdata['id'] = $this->_regist_id;
					$this->set_postdata($registdata);
					$this->set_tbl($this->_pfx . 'regist');
					$this->set_fields($this->_fields_sql);
					$this->set_where(['id' => 'integer']);
					$this->updateTable();

				}
			}
//ログの書き込み
			$this->_kind = "update_entry";
			$logdata['process'] = $this->_kind;
			$logdata['kind'] = $this->_kind;
			$logdata['component'] = COMPONENT;
			$logdata['app_id'] = null;
			$logdata['value'] = json_encode($postdata);
			$logdata['username'] = $this->_auth->getUsername();
			$logdata['auth_username'] = $this->_auth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();
		} else {

//管理画面での新規ユーザー

			$this->_fields_regist['email'] = 'text';
			$this->_skip_emailcfrm = 1;

			$registdata = $this->execSanitize($this->_fields_regist, $this->_fields_regist_must);

			$registdata['username'] = md5($this->_regist_id . COMPONENT . time() . $this->_smarty->getConfigVars('salt'));

			$registdata['password'] = sha1($this->_regist_id . time() . $this->_smarty->getConfigVars('salt') . COMPONENT);
			$registdata['status'] = -9;
			$registdata['regist_date'] = date("Y-m-d H:i:s");

//emailを解決
			if ($_POST['email']) {
				$registdata['email'] = strip_tags($_POST['email']);
			} else {
				$registdata['email'] = self::generateUuid();
			}

			$_fields_regist = $this->_fields_sql;
			$_fields_regist['username'] = 'text';
			$_fields_regist['password'] = 'text';
			$_fields_regist['status'] = 'integer';
			$_fields_regist['regist_date'] = 'text';
			$_fields_regist['email'] = 'text';

			$this->set_postdata($registdata);
			$this->set_tbl($this->_pfx . 'regist');
			$this->set_fields($_fields_regist);
			$this->insertTable();

			$postdata['regist_id'] = $this->get_last_insertId();

//管理画面での新規登録
			$_fields['regist_id'] = 'integer';

			$_fields['code'] = 'text';
			$postdata['code'] = Text_Password::create(8, 'unpronounceable', 'alphanumeric');
			$this->_entry_code = $postdata['code'];
			$_fields['regist_date'] = 'text';
			$postdata['regist_date'] = date("Y-m-d H:i:s");

			$this->set_postdata($postdata);
			$this->set_tbl($this->_pfx . 'entry');
			$this->set_fields($_fields);
			$this->insertTable();

			$postdata['entry_id'] = $this->get_last_insertId();

			$statdata = ['id' => $postdata['entry_id'], 'status' => 0, 'paid' => -9, 'status_payment' => 0];

			$fields_stat = ['id' => 'integer', 'status' => 'integer', 'paid' => 'integer', 'status_payment' => 'integer'];

			$this->set_fields($fields_stat);
			$this->set_postdata($statdata);
			$this->set_tbl($this->_pfx . 'entry_status');
			$this->insertTable();

//areaの登録
			if ($this->_flag_area) {
				if (is_array($postdata['area'])) {
					$fields_area = ['entry_id' => 'integer', 'area_id' => 'integer'];
					$this->set_fields($fields_area);
					$this->set_tbl($this->_pfx . 'entry_area');
					foreach ($postdata['area'] as $area_id) {
						$this->set_postdata(['entry_id' => $postdata['entry_id'], 'area_id' => $area_id]);
						$this->insertTable();
					}
				}

			}

//ログの書き込み
			$this->_kind = "entry_admin";
			$logdata['process'] = $this->_kind;
			$logdata['kind'] = $this->_kind;
			$logdata['component'] = COMPONENT;
			$logdata['app_id'] = null;
			$logdata['value'] = json_encode($postdata);
			$logdata['username'] = $this->_auth->getUsername();
			$logdata['auth_username'] = $this->_auth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();

		}
	}

	private function saveBaseEntryStatus($_fields, $_fields_must) {

		$this->checkPostEntryCode();

		$statusdata = $this->execSanitize($_fields, $_fields_must);
		$statusdata['id'] = $this->_entry_id;

		$this->set_postdata($statusdata);
		$this->set_tbl($this->_pfx . 'entry_status');
		$this->set_fields($_fields);
		$this->set_where(['id' => 'integer']);
		$this->updateTable();

//ログの書き込み
		$this->_kind = "update_entry_status";
		$logdata['process'] = $this->_kind;
		$logdata['kind'] = $this->_kind;
		$logdata['component'] = COMPONENT;
		$logdata['app_id'] = null;
		$logdata['value'] = json_encode($statusdata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

		return $statusdata;
	}

	private function deleteBaseEntry() {
		if ($this->_regist_status != -9) {
			throw new Exception("Error", 1);
		}

		$this->set_tbl($this->_pfx . 'entry_status');
		$this->set_fields(['id' => 'integer']);
		$this->set_postdata(['id' => $this->_entry_id]);
		$this->deleteTable();

		if ($this->_delete_entry_area) {

			$this->set_tbl($this->_pfx . 'entry_area');
			$this->set_fields(['entry_id' => 'integer']);
			$this->set_postdata(['entry_id' => $this->_entry_id]);
			$this->deleteTable();

		}

		$this->set_tbl($this->_pfx . 'entry');
		$this->set_fields(['id' => 'integer']);
		$this->set_postdata(['id' => $this->_entry_id]);
		$this->deleteTable();

		$this->set_tbl($this->_pfx . 'regist');
		$this->set_fields(['id' => 'integer']);
		$this->set_postdata(['id' => $this->_regist_id]);
		$this->deleteTable();

//ログの書き込み
		$this->_kind = "delete_entry";
		$logdata['process'] = $this->_kind;
		$logdata['kind'] = $this->_kind;
		$logdata['component'] = COMPONENT;
		$logdata['app_id'] = null;
		$logdata['value'] = json_encode($statusdata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

	}

	private function searchBaseEntry() {

		$searchword = $_REQUEST['term'];

		$searchword = preg_replace('/　/', ' ', $searchword);
		$searchword = trim($searchword);

		if (!$searchword) {
			return;
		} else if (mb_strlen($searchword) < 1) {
			return;
		}

		$searchword = mb_convert_kana($searchword, "a");
		$searchword = preg_replace('/\s+/', ' ', $searchword);
		$words = explode(' ', $searchword);

		$where = [];
		$data = [];

		foreach ($words as $word) {
			array_push($data, '%' . $word . '%', '%' . $word . '%');
			array_push($where, " (r.cmp_name LIKE ? OR r.cmp_kana LIKE ?) ");
		}

		$sql = <<< HERE
SELECT e.id,
e.code as code,
YEAR(e.regist_date) as y,
LPAD(MONTH(e.regist_date),2,"0") as m,
LPAD(DAY(e.regist_date),2,"0") as d,
e.title,r.cmp_name
	FROM {$this->_pfx}entry AS e
	LEFT JOIN {$this->_pfx}regist AS r ON r.id = e.regist_id
HERE;

		if (count($where)) {
			$sql .= " WHERE " . implode(" \nAND ", $where) . "\n";
		}

		$sql .= " ORDER BY e.id DESC";

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("Error", 1);
		}

		$users = $res->fetchAll();
		echo json_encode($users);
	}

	private function getBaseEntryData(string $_code = null, int $_regist_id = null) {

		$tbl = $this->_pfx . 'entry';
		if ($this->_view) {
			$tbl .= '_view';
		}
		try {
			$sql = <<< HERE
SELECT e.*,
 count(r.id) AS ct,
IFNULL(s.status_payment,0) AS status_payment,
s.status AS status,
s.mailed AS mailed,
s.paid AS paid,
r.cmp_name AS regist_cmp_name,
r.cmp_kana AS regist_cmp_kana,
r.cover AS regist_cover,
r.email AS regist_email,
r.zipcodef AS regist_zipcodef,
r.zipcodes AS regist_zipcodes,
r.pref AS regist_pref,
r.addressf AS regist_addressf,
r.addresss AS regist_addresss,
r.addresst AS regist_addresst,
r.telephone AS regist_telephone,
r.fax AS regist_fax,
r.business AS regist_business,
r.url AS regist_url,
r.category AS regist_category,
r.status AS regist_status

FROM {$tbl} AS e,{$this->_pfx}entry_status AS s,{$this->_pfx}regist AS r

WHERE r.id = e.regist_id AND e.id = s.id

HERE;

			if ($this->_entry_id) {
				$sql .= " AND e.id = :entry_id";
			} else if ($_code) {
				$sql .= " AND e.code = :code";
			} else {
				throw new Exception("パラメータが不正です", 1);
			}

			if ($_regist_id) {
				$sql .= " AND r.id = :regist_id";
			}

			$res = $this->_pdo->prepare($sql);

			if ($this->_entry_id) {
				$res->bindValue(':entry_id', $this->_entry_id, PDO::PARAM_INT);
			} else {
				$res->bindValue(':code', $_code, PDO::PARAM_STR);
			}

			if ($_regist_id) {
				$res->bindValue(':regist_id', $_regist_id, PDO::PARAM_INT);
			}

			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("データベース処理が正しく行われませんでした。" . $e->getMessage(), 1);
		}
		$entrydata = $res->fetch();
		if (!$entrydata['id']) {
			throw new Exception("データ取得に失敗しました。", 1);
		}

		//公開非公開

		$term1 = strtotime($entrydata['term1']);
		$term2 = strtotime($entrydata['term2']);

		if (time() < $term1) {
			$entrydata['visible'] = 0;
		} else if (($entrydata['status'] == 1 && time() >= $term1) && (time() < $term2 + 24 * 60 * 60) || ($entrydata['status'] == -1 && time() >= $term1)) {
			$entrydata['visible'] = 1;
		} else {
			$entrydata['visible'] = 2;
		}

		return $entrydata;
	}

}
?>