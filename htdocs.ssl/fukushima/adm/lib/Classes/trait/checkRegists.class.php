<?php
trait checkRegists {

	protected $_mgdata;
	protected $_params;
	protected $_block;
	protected $_cur_page;
	protected $_flag_count;

	protected $_exclude_error_email;

	public function set_mgdata($_mgdata) {$this->_mgdata = $_mgdata;}
	public function get_mgdata() {return $this->_mgdata;}
	public function set_params($_params) {$this->_params = $_params;}

//smartyのblock内の処理として指定
	public function set_block($_block) {$this->_block = $_block;}
	public function set_cur_page($_cur_page) {$this->_cur_page = $_cur_page;}

	public function set_flag_count($_flag_count) {$this->_flag_count = $_flag_count;}

	public function set_regist_id($_regist_id) {$this->_regist_id = $_regist_id;}

	public function setExcludeErrorMail() {
		$this->_exclude_error_email = 1;
	}

	public function skip_regist_id() {
		$this->_skip_regist_id = 1;
	}

	public function getRegists() {

		$result = $this->get_sql_mg();
		$this->_sql = $result['sql'];
		$this->_postdata = $result['data'];

		if (!$this->_sql) {
			throw new Exception("パラメータが不正です", 1);
		}
		if ($this->_flag_count) {
			$this->_rowcount = 1;
			$this->_flag_count = null;
		} else {
			$this->_fetchall = 1;
		}
		$regists = $this->selectTable();
		return $regists;
	}

	public function get_sql_mg() {

		if (isset($this->_params['group_id']) && $this->_params['group_id']) {

			$mgdata = $this->getMagazineGroup();
			if ($mgdata) {
				$this->_mgdata = $mgdata;
			}
		} else if (isset($this->_params['condition']) && is_array($this->_params['condition'])) {
			$this->_mgdata['condition'] = $this->_params['condition'];
		}

		$where = array();
		$awhere = array();
		$or = array();
		$data = array();

		if (isset($_SESSION)) {
			if (!$_SESSION['admin_mode']) {
				array_push($where, "r.status = ?");
				array_push($data, 1);

				if (is_object($this->_smarty)) {
					if ($this->_smarty->getTemplateVars('auth_user_id')) {
						$data[':regist_id'] = $this->_smarty->getTemplateVars('auth_user_id');
						array_push($where, "r.id = :regist_id");
					} else if ($this->_smarty->getTemplateVars('view_regist_id')) {
						$data[':regist_id'] = $this->_smarty->getTemplateVars('view_regist_id');
						array_push($where, "r.id = :regist_id");
					} else {
						throw Exception('不正なアクセスです');
						exit();
					}
				} else {
					if (!$auth_user_id) {
						throw Exception('不正なアクセスです');
						exit();
					}
				}
			}
		}
		if (!$this->_skip_regist_id) {
			if ($this->_params['rid']) {
				$data[':regist_id'] = intval($this->_params['rid']);
				array_push($where, "r.id = :regist_id");
			} else if ($this->_params['regist_id']) {
				$data[':regist_id'] = intval($this->_params['regist_id']);
				array_push($where, "r.id = :regist_id");
			} else if (is_object($this->_smarty) && $this->_smarty->getTemplateVars('view_regist_id')) {
				$data[':regist_id'] = $this->_smarty->getTemplateVars('view_regist_id');
				array_push($where, "r.id = :regist_id");
			}
		}

		if ($this->_params['status']) {
			array_push($where, "r.status = :status");
			$data[':status'] = $this->_params['status'];
		} else if ($this->_status) {
			array_push($where, "r.status = :status");
			$data[':status'] = $this->_status;
		} else if ($this->_mgdata['status']) {
			array_push($where, "r.status = :status");
			$data[':status'] = $this->_mgdata['status'];
		} else {
			if (!$_SESSION['admin_mode']) {
				array_push($where, "r.status = :status");
				$data[':status'] = 1;
			}
		}

		if ($this->_mgdata['condition']['year']) {
			array_push($where, " r.year = :year ");
			$data[':year'] = $this->_mgdata['condition']['year'];
		} else if (is_object($this->_smarty) && $this->_smarty->getTemplateVars('view_year')) {
			array_push($where, " r.year = :year ");
			$data[':year'] = $this->_smarty->getTemplateVars('view_year');
		}

		if ($gdata['tmp_update_password']) {
			array_push($where, " r.tmp_update_password = :tmp_update_password ");
			$data['tmp_update_password'] = 1;
		}

		if (count($this->_mgdata['condition']['dept'])) {
			$ddd = array();
			foreach ($this->_mgdata['condition']['dept'] as $i => $dep) {
				array_push($ddd, "r.dept = :dept" . $i);
				$data[':dept' . $i] = $dep;
			}
			array_push($where, "(" . implode(' OR ', $ddd) . ")");
		}

		if (is_object($this->_smarty)) {
			if ($this->_smarty->getTemplateVars('view_searchword')) {

				$view_searchword = $this->_smarty->getTemplateVars('view_searchword');
				$view_searchword = trim($view_searchword);
				$view_searchword = preg_replace('/　/', ' ', $view_searchword);
				$view_searchword = mb_convert_kana($view_searchword, "a");
				$view_searchword = preg_replace('/\s+/', ' ', $view_searchword);
				$words = explode(' ', $view_searchword);
				foreach ($words as $i => $word) {
					$data[':namef' . $i] = '%' . $word . '%';
					$data[':nameg' . $i] = '%' . $word . '%';
					$data[':kanaf' . $i] = '%' . $word . '%';
					$data[':kanag' . $i] = '%' . $word . '%';
					$data[':email' . $i] = '%' . $word . '%';

					array_push($or, "(r.namef LIKE :namef" . $i . " OR r.nameg LIKE :nameg" . $i . " OR r.kanaf LIKE :kanaf" . $i . " OR r.kanag LIKE :kanag" . $i . " OR r.email LIKE :email" . $i . ")");
				}

				if (count($or)) {
					array_push($where, implode(" AND ", $or));
				}

			}
		}

		if ($this->_mgdata['condition']['component']) {

			switch ($this->_mgdata['condition']['component']) {
			case 'entry':
			case 'reserve':

				if ($this->_mgdata['condition']['category_id']) {

					array_push($awhere, " a.component = :component ");
					$data[':component'] = $this->_mgdata['condition']['component'];

					array_push($awhere, " a.category_id = :category_id ");
					$data[':category_id'] = $this->_mgdata['condition']['category_id'];
					array_push($awhere, " (IFNULL(a.cancelled,0) < 1) ");
				}
				break;

			default:
				array_push($awhere, " a.component = :component ");
				$data[':component'] = $this->_mgdata['condition']['component'];

				if (isset($this->_mgdata['condition']['category_id']) && $this->_mgdata['condition']['category_id']) {
					$data[':category_id'] = $this->_mgdata['condition']['category_id'];
					array_push($awhere, " a.category_id = :category_id ");
				}
				array_push($awhere, " (IFNULL(a.cancelled,0) < 1) ");

				break;
			}

			if ($data[':component'] == "reserve") {

				if ($this->_mgdata['condition']['comedate']) {

					array_push($awhere, " a.comedate = :comedate ");
					$data[':comedate'] = $this->_mgdata['condition']['comedate'];

					if (is_array($this->_mgdata['condition']['cometime'])) {
						$orc = [];
						foreach ($this->_mgdata['condition']['cometime'] as $i => $cometime) {
							$data[':cometime' . $i] = $cometime;
							array_push($orc, "a.cometime = :cometime" . $i);
						}
						if (count($orc)) {
							array_push($awhere, "(" . implode(' OR ', $orc) . ")");
						}

					}
				}
			}

			if (is_array($this->_mgdata['condition']['item_id'])) {
				$ori = [];
				foreach ($this->_mgdata['condition']['item_id'] as $i => $item_id) {
					$data[':item_id' . $i] = $item_id;
					array_push($ori, "aps.item_id = :item_id" . $i);
				}
				if (count($ori)) {
					array_push($awhere, "(" . implode(' OR ', $ori) . ")");
				}
			}

		}

		if (!isset($data[':status'])) {
			if (!isset($data[':regist_id'])) {
				array_push($where, "r.status = :status");
				$data[':status'] = 1;
			}
		}

		if ($data[':status'] == 1) {

			if (!$this->_mgdata['condition']['forced']) {

				if ($this->_params['dm']) {
					array_push($where, " IFNULL(r.dm,0) = :dm ");
					$data[':dm'] = 1;
				} else if ($this->_mgdata['dm']) {
					array_push($where, " IFNULL(r.dm,0) = :dm ");
					$data[':dm'] = 1;
				} else {
					array_push($where, " IFNULL(r.dm,0) = 0 ");
				}
			}
		}

		if ($this->_exclude_error_email) {
			array_push($where, " IFNULL(r.send_error,0) < 4 ");
		}

		$sql = <<< HERE
SELECT r.*
,rl.lab_name as lab_name
,rl.lab_extension_line as lab_extension_line
,rl.lab_faxnumber as lab_faxnumber

 FROM regist AS r
 LEFT JOIN regist_lab AS rl ON r.id = rl.regist_id

HERE;

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where) . "\n";
		}

		if (count($awhere)) {

			array_push($awhere, " IFNULL(a.archived,0) = 0 ");

			$sql .= <<< HERE
AND r.id

HERE;

/*
未申込条件を廃止
if ($this->_mgdata['oncategory'] == -1) {
$sql .= " NOT ";
}
 */

			$sql .= <<< HERE
IN (SELECT a.regist_id FROM app AS a

HERE;

			$sql .= " WHERE " . implode(' AND ', $awhere);

			$sql .= " GROUP BY a.regist_id";
			$sql .= " )";
		}

		$sql .= "\nORDER BY r.id ";

		$sql .= ($this->_params['sort_order'] == 'ascend') ? 'ASC' : 'DESC';
		$sql .= "\n";

		if ($this->_block) {
			if ($this->_params['all']) {
				$limit = intval($this->_params['limit']);
				if ($limit < 1) {
					$limit = 10;
				}
				$sql .= " LIMIT 0, " . $limit;
			}
			// 変数$per_pageが定義されているときは、1ページ分の記事を読み込む
			else if ($this->_params['per_page']) {
				$cur_page = $this->_cur_page;

				$offset = ($cur_page - 1) * $this->_params['per_page'];
				$sql .= " LIMIT " . $offset . ", " . $this->_params['per_page'];
			}
		}
		$res['sql'] = $sql;
		$res['data'] = $data;

		return $res;

	}

	public function sanitizeCondition() {

		$condition = [];

//変数の受け取り
		if (isset($_POST['shopping_category_id'])) {
			$condition['category_id'] = intval($_POST['shopping_category_id']);
		} else if (isset($_POST['entry_category_id'])) {
			$condition['category_id'] = intval($_POST['entry_category_id']);
		}
		if (isset($_POST['status'])) {
			$condition['status'] = intval($_POST['status']);
		}
		if (isset($_POST['year'])) {
			$condition['year'] = intval($_POST['year']);
		}
		if (isset($_POST['component'])) {
			$condition['component'] = addslashes($_POST['component']);
			if (isset($_POST['part'])) {
				$condition['part'] = addslashes($_POST['part']);
			}
		}
		if (isset($_POST['tmp_update_password'])) {
			$condition['tmp_update_password'] = 1;
		}

		if (is_array($_POST['dept'])) {
			$dept = array_map('intval', $_POST['dept']);
			$condition['dept'] = $dept;
		}
		$this->_mgdata = $condition;

	}

}
?>