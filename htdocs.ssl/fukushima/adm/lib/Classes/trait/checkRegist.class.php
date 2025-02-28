<?php
trait checkRegist {

	protected $_regist_id;

	public function set_regist_id($_regist_id) {$this->_regist_id = $_regist_id;}

	public function getRegistInfo() {

		if (!$this->_regist_id) {
			throw new Exception("Error no regist_id", 1);
		}

		$where = [];

		$sql = <<< HERE
SELECT * FROM regist AS r

HERE;

		array_push($where, 'r.id = :id');
		$data[':id'] = $this->_regist_id;

		if ($_SESSION['mode']) {
			if (!$data[':id']) {
				throw new Exception("Error no regist_id", 1);
			}
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

		$registinfo = $res->fetch();

//電話番号変換
		//		$fields = ['telephone', 'fax', ''];
		foreach ($this->_fields_phonenumber as $field) {

			if ($registinfo[$field]) {
				$tmp = self::explodePhonenumber($registinfo[$field], $field);
				if (is_array($tmp)) {
					$registinfo = array_merge($registinfo, $tmp);
				}
			}
		}

		if ($registinfo['membership']) {
			$registinfo['membership1'] = substr($registinfo['membership'], 0, 4);
			$registinfo['membership2'] = substr($registinfo['membership'], 4, 4);
			$registinfo['membership3'] = substr($registinfo['membership'], 8, 4);
		}

		if ($registinfo['bithday']) {
			$registinfo['bithday_year'] = substr($registinfo['birthday'], 0, 4);
			$registinfo['bithday_month'] = substr($registinfo['birthday'], 4, 2);
			$registinfo['bithday_day'] = substr($registinfo['birthday'], 6, 2);
		}

		return $registinfo;

	}
}
?>