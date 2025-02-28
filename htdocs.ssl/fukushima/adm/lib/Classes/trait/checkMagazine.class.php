<?php
trait checkMagazine {

	protected $_adminAuth;
	protected $_authority;

	public function getMagazineGroup() {

		$this->_tbl = "mail_group";
		$this->_where = ['id' => 'integer'];

		if ($this->_params['group_id']) {
			$this->_postdata['id'] = $this->_params['group_id'];
		} else if ($this->_mail_group_id) {
			$this->_postdata['id'] = $this->_mail_group_id;
		} else {
			return;
		}
		$mgdata = $this->selectTable();

		if ($mgdata) {
			if ($mgdata['condition']) {
				$mgdata['condition'] = json_decode($mgdata['condition'], true);
			}

			$this->_mgdata = $mgdata;
			return $mgdata;
		}
	}

	public function getMagazine() {

		if ($this->_params['magazine_id']) {
			$postdata[':id'] = $this->_params['group_id'];
		} else if ($this->_mail_magazine_id) {
			$postdata[':id'] = $this->_mail_magazine_id;
		} else {
			return;
		}

		$sql = <<< HERE
SELECT
mm.*,
mg.signature AS signature,
mg.main_email AS main_email,
mg.unsubscribe AS group_unsubscribe,
mg.condition AS group_condition,
mm.admin_user_id AS admin_user_id,
iu.email AS admin_user_email
 FROM mail_magazine AS mm
LEFT JOIN mail_group AS mg ON mm.group_id = mg.id
LEFT JOIN init_user AS iu ON iu.id = mm.admin_user_id
WHERE mm.id = :id

HERE;
		$this->_postdata = $postdata;
		$this->_sql = $sql;

		$magazinedata = $this->selectTable();

		if ($magazinedata['group_id']) {
			$magazinedata['condition'] = [];
			if ($magazinedata['group_condition']) {
				$magazinedata['condition'] = json_decode($magazinedata['group_condition'], true);
			}
			$magazinedata['unsubscribe'] = $magazinedata['group_unsubscribe'];

		} else if ($magazinedata['condition']) {
			$magazinedata['condition'] = json_decode($magazinedata['condition'], true);
		} else {
			$magazinedata['condition'] = [];
		}

		return $magazinedata;
	}

}
?>