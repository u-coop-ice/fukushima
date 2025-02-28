<?php
class commonDB {
	public function __construct() {
		global $smarty, $pdo, $pdo_repl;
		$this->_pdo = $pdo;
		$this->_pdo_repl = $pdo_repl;
		$this->_smarty = $smarty;
		$this->_transaction = $this->_pdo->inTransaction();
	}

	public function __destruct() { /* デストラクタ */}

	protected $_pdo;
	protected $_smarty;

	private $_last_insertId;
	private $_view;

	protected $_transaction;
	protected $_code;
	protected $_id;

	protected $_postdata;
	protected $_fields;
	protected $_tbl;
	protected $_where;
	protected $_sql;

	protected $_fetchall = null;
	protected $_rowcount = null;
	protected $_for_update = null;

	public function set_tbl(string $_tbl) {$this->_tbl = $_tbl;}
	public function set_postdata(array $_postdata) {$this->_postdata = $_postdata;}
	public function set_fields(array $_fields) {$this->_fields = $_fields;}
	public function set_where(array $_where) {$this->_where = $_where;}
	public function set_sql(string $_sql) {$this->_sql = $_sql;}
	public function set_transaction($_transaction) {$this->_transaction = $_transaction;}
	public function set_code($_code) {$this->_code = $_code;}
	public function set_id($_id) {$this->_id = $_id;}
	public function set_view($_view) {$this->_view = $_view;}

	public function set_rowcount($_rowcount) {$this->_rowcount = $_rowcount;}
	public function set_fetchall($_fetchall) {$this->_fetchall = $_fetchall;}

	public function get_last_insertId() {return $this->_last_insertId;}
	public function get_postdata() {return $this->_postdata;}
	public function get_fields() {return $this->_fields;}
	public function get_code() {return $this->_code;}
	public function get_view() {return $this->_view;}

	public function displayError($_error = null) {
		if ($this->_transaction) {
			throw new Exception('return rollBack!!');
			return;
		} else {
			if (is_object($this->_smarty)) {
				$this->_smarty->display('error.tpl');
				exit();
			}
			throw new Exception('database error!!' . $_error->getMessage());
			return;
		}
	}

//汎用テーブル検索

	public function selectTable() {
		$data = array();
		$tbl = $this->_tbl;
		$where = $this->_where;
		$postdata = $this->_postdata;

		if ($this->_sql) {

			$sql = $this->_sql;
			$this->_sql = null;
			$data = $this->_postdata;

		} else {

			$sql = <<< HERE
SELECT * FROM {$tbl}

HERE;

			if ($this->_id) {
				$sql .= " WHERE `id` = ?";
				$data = array($this->_id);

			} else if ($this->_code) {
				$sql .= " WHERE `code` = ?";
				$data = array($this->_code);
			} else if (count($where)) {
				foreach ($where as $k => $wv) {
					array_push($data, $postdata[$k]);
				}

				$where = array_keys($where);
				$where = array_map(array($this, 'transChairs'), $where);

				$wheres = ' WHERE ' . implode(' AND ', $where);
				$sql .= $wheres;
			}
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'データベースへの処理に失敗しました(s)。' . $e->getMessage());
			}
			$this->displayError($e);
		}

		if ($this->_rowcount) {
			$dd = $res->rowCount();
			$this->_rowcount = null;
		} else if ($this->_fetchall) {
			$dd = $res->fetchAll();
			$this->_fetchall = null;
		} else {
			$dd = $res->fetch();
		}

		return $dd;
	}

//汎用テーブル追加

	public function insertTable() {
		$postdata = $this->_postdata;
		$fields = $this->_fields;
		$tbl = $this->_tbl;

		$data = array();
		$chiars = array();
		$fds = array();

		foreach ($fields as $key => $value) {
			array_push($chiars, '?');
			if ($value == 'integer') {
				array_push($data, intval($postdata[$key]));
			} else if ($value == 'float') {
				array_push($data, floatval($postdata[$key]));
			} else {
				if ($postdata[$key] == "") {
					array_push($data, NULL);
				} else {
//					array_push($data, addslashes($postdata[$key]));
					array_push($data, $postdata[$key]);
				}
			}
		}
		$fds = array_keys($fields);
		$fds = array_map(array($this, 'transFields'), $fds);

		$field = implode(',', $fds);
		$chiar = implode(',', $chiars);

		$sql = <<< HERE
INSERT INTO {$tbl} ({$field})
	VALUES ({$chiar})

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'データベースの処理に失敗しました(i)。' . $e->getMessage());
			}
			$this->displayError($e);
		}

		$this->_last_insertId = $this->_pdo->lastInsertId();
		return $res;
	}

	static function transChairs($value) {
		$value = '`' . $value . '` = ?';
		return $value;
	}

	static function transChairsPlus($value) {
		$value = '`' . $value . '` = IFNULL(`' . $value . '`,0) + 1 ';
		return $value;
	}

	static function transFields($value) {
		$value = '`' . $value . '`';
		return $value;
	}

	public function updateTable() {

		$postdata = $this->_postdata;
		$fields = $this->get_fields();

		$tbl = $this->_tbl;
		$where = $this->_where;
		$data = array();
		$chairs = array();

		if (count($fields)) {
			$chairs = array_keys($fields);
			$chairs = array_map(array($this, 'transChairs'), $chairs);

			foreach ($fields as $key => $value) {
				if ($value == 'integer') {
					array_push($data, intval($postdata[$key]));
				} else if ($value == 'float') {
					array_push($data, floatval($postdata[$key]));
				} else {
					if ($postdata[$key] == "") {
						array_push($data, NULL);
					} else {
//						array_push($data, addslashes($postdata[$key]));
						array_push($data, $postdata[$key]);

					}
				}
			}

			$chair = implode(',', $chairs);
		}

		if (count($where)) {

			foreach ($where as $k => $v) {
				array_push($data, $postdata[$k]);
			}
			$where = array_keys($where);
			$where = array_map(array($this, 'transChairs'), $where);

			$wheres = ' WHERE ' . implode(' AND ', $where);
		} else {
			$wheres = ' WHERE `id` = ?';
			array_push($data, intval($postdata['id']));
		}

		$sql = <<< HERE
UPDATE {$tbl} SET ${chair} {$wheres}

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				echo $e->getMessage();
				exit;
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'データベースへの処理に失敗しました(u)。');
			}
			$this->displayError($e);
		}

		return $res;
	}

	public function updateTablePlus() {

		$postdata = $this->_postdata;
		$fields = $this->get_fields();

		$tbl = $this->_tbl;
		$where = $this->_where;

		$data = array();
		$chairs = array();

		if (count($fields)) {
			$chairs = array_keys($fields);
			$chairs = array_map(array($this, 'transChairsPlus'), $chairs);

			$chair = implode(',', $chairs);
		}

		if (count($where)) {

			foreach ($where as $k => $v) {
				array_push($data, $postdata[$k]);
			}
			$where = array_keys($where);
			$where = array_map(array($this, 'transChairs'), $where);

			$wheres = ' WHERE ' . implode(' AND ', $where);
		} else {
			$wheres = ' WHERE `id` = ?';
			array_push($data, intval($postdata['id']));
		}

		$sql = <<< HERE
UPDATE {$tbl} SET ${chair} {$wheres}

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'データベースへの処理に失敗しました(up)。');
			}
			$this->displayError($e);
		}

		return $res;

	}

	public function replaceTable() {

//		$this->setPDO();

		$postdata = $this->_postdata;
		$fields = $this->_fields;
		$tbl = $this->_tbl;

		$data = array();
		$chairs = array();
		$fds = array();

		foreach ($fields as $key => $value) {
			array_push($chairs, '?');
			if ($value == 'integer') {
				array_push($data, intval($postdata[$key]));
			} else if ($value == 'float') {
				array_push($data, floatval($postdata[$key]));
			} else {
				if ($postdata[$key] == "") {
					array_push($data, NULL);
				} else {
//					array_push($data, addslashes($postdata[$key]));
					array_push($data, $postdata[$key]);

				}
			}
		}

		$fds = array_keys($fields);
		$fds = array_map(array($this, 'transFields'), $fds);

		$field = implode(',', $fds);
		$chair = implode(',', $chairs);

		$sql = <<< HERE
REPLACE INTO {$tbl} ({$field}) VALUES ({$chair})

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'データベースへの処理に失敗しました(r)。');
			}
			$this->displayError($e);
		}

		return $res;
	}

	public function deleteTable() {

		$postdata = $this->get_postdata();
		$tbl = $this->_tbl;
//		$where = $this->_where;

		$where = array();
		$data = array();

		foreach ($this->_where as $key => $value) {
			if ($value == "integer") {
				array_push($data, intval($postdata[$key]));
			} else if ($value == 'float') {
				array_push($data, floatval($postdata[$key]));
			} else {
				array_push($data, $postdata[$key]);
			}
			array_push($where, $key);
		}

		$where = array_map(array($this, 'transChairs'), $where);
		$wheres = ' WHERE ' . implode(' AND ', $where);

		$sql = <<< HERE
DELETE FROM {$tbl} {$wheres}

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'レコードの削除に失敗しました。');
			}
			$this->displayError($e);
		}

		return $res;
	}

	public function deleteTableAll() {

		$tbl = $this->_tbl;

		$sql = <<< HERE
DELETE FROM {$tbl}

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', '全レコードの削除に失敗しました。');
			}
			$this->displayError($e);
		}

		$sql = "ALTER TABLE {$tbl} AUTO_INCREMENT = 1";

		try {
			$res = $this->_pdo->query($sql);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', '全レコードの削除に失敗しました。');
			}
			$this->displayError($e);
		}

	}

	public function existTable() {
		$data = array($this->_tbl);

		$sql = <<< HERE
SHOW TABLES LIKE ?

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('errmsg', 'データベースへの処理に失敗しました。');
			}
			$this->displayError($e);
		}

		$exist = $res->fetch();
		return count($exist);
	}

	public function dropView() {

		$sql = "DROP VIEW IF EXISTS " . $this->get_view();

		try {
			$this->_pdo->exec($sql);
		} catch (PDOException $e) {
			if (is_object($this->_smarty)) {
				$smarty->assign('page_title', 'エラー');
				$smarty->assign('errmsg', 'データベースへの処理に失敗しました(dv)。');
			}
			$this->displayError($e);
		}
	}

}

?>