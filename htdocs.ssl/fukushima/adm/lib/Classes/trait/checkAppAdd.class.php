<?php
trait checkAppAdd {

	private $_add_id;
	private $_root_id;
	private $_add_code;

	public function set_add_id(int $_add_id) {
		$this->_add_id = $_add_id;
	}

	public function set_root_id(int $_root_id) {
		$this->_root_id = $_root_id;
	}

	public function get_root_id() {
		return $this->_root_id;
	}

	public function get_add_id() {
		return $this->_add_id;
	}

	public function set_add_code(string $_add_code) {
		$this->_add_code = $_add_code;
	}

	public function getReturnAddInfo() {

		$where = [];
		$data = [];

		if ($this->_root_id) {
			array_push($where, 'ad.`root_id` = :root_id');
			$data[':root_id'] = $this->_root_id;
		} else if ($this->_add_id) {
			array_push($where, 'ad.`id` = :add_id');
			$data[':add_id'] = $this->_add_id;
		} else if ($this->_regist_id) {
			$registinfo = $this->getRegistInfo();
			$registinfo['regist_id'] = $registinfo['id'];
			return $registinfo;
		} else {
			throw new Exception("パラメーターが足りません。", 1);
		}

		$sql = 'SELECT count(ad.`id`) AS ct FROM app_add AS `ad`';

		if (is_object($this->_auth)) {
			if ($this->_auth->getAuthData('regist_id')) {
				array_push($where, 'ad.`regist_id` = :regist_id');
				$data[':regist_id'] = $this->_auth->getAuthData('regist_id');
			}
		}
		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		try {
			$res = $this->_pdo_repl->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {

			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error", 1);
		}

		$adddata = $res->fetch();
		$ct = $adddata['ct'];

		if (!$ct) {
			$where = ['ad.`id` = :add_id'];
			$data = [':add_id' => $this->_add_id];
		}

		array_push($where, "ad.regist_id = r.id");

		$sql = <<< HERE
SELECT ad.subject,ad.memo,
ad.`add`,
ad.category_id,
r.username AS `username`,
r.email AS `email`,
r.namef AS `namef`,
r.nameg AS `nameg`,
r.`status` AS `status`,
r.`id` AS `regist_id`

FROM app_add AS ad,regist AS r
HERE;

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		$sql .= ' ORDER BY ad.`id` DESC';

		try {
			$res = $this->_pdo_repl->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			var_dump($e);
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error", 1);
		}

		$adddata = $res->fetch();

		$subject = preg_replace('/Re(\(?)(\d*?)(\)?):\s/', '', $adddata['subject']);

		$adddata['subject'] = 'Re';
		if ($this->_root_id) {
			if ($ct >= 1) {
				$adddata['subject'] .= '(' . ($ct + 1) . ')';
			}
		}

		$adddata['subject'] .= ': ' . $subject;

		return $adddata;

	}

	private function getAppAddInfo() {

		if (!$this->_add_id) {
			if (!$this->_add_code) {
				throw new Exception("Error no add_id", 1);
			}
		}

		$where = [];

		$sql = <<< HERE
SELECT * FROM app_add AS ad

HERE;

		if ($this->_add_id) {
			array_push($where, 'ad.id = :id');
			$data[':id'] = $this->_add_id;
		} else if ($this->_add_code) {
			array_push($where, 'ad.code = :code');
			$data[':code'] = $this->_add_code;
		}
		if ($_SESSION['mode']) {
			array_push($where, 'ad.regist_id = :regist_id');
			$data[':regist_id'] = $this->_auth->getAuthData('id');
		}

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error", 1);
		}

		$addinfo = $res->fetch();

		if ($addinfo['root_id']) {
			$this->_root_id = $addinfo['root_id'];
		} else {
			$this->_root_id = $addinfo['id'];
		}

		if (!$this->_add_id) {
			$this->_add_id = $addinfo['id'];
		}

		return $addinfo;

	}

}
?>