<?php

trait execAppAdd {

	private $_fields_add = array(
		'app_id' => 'integer',
		'regist_id' => 'integer',
		'subject' => 'text',
		'memo' => 'text',
		'target' => 'text',
		'purpose' => 'text',
		'add' => 'text',
		'root_id' => 'integer',
		'send' => 'integer',
		'auto_send' => 'integer',
		'noreply' => 'integer',
		'code' => 'text',
		'cover' => 'text',
		'date' => 'text',
		'remote_addr' => 'text',
		'remote_host' => 'text',
		'user_agent' => 'text',
		'admin_user_id' => 'integer',
		'regist_date' => 'text',
	);

	public function saveAppAdd() {

		if (isset($this->_postdata['recieve'])) {
			$this->_fields_add['recieve'] = 'integer';
		}

		if (isset($this->_postdata['category_id'])) {
			$this->_fields_add['category_id'] = 'integer';
		}

		if (!isset($this->_postdata['date'])) {
			$this->_postdata['date'] = date("Y-m-d H:i:s");
		} else if ($this->_postdata['date'] = "") {
			$this->_postdata['date'] = date("Y-m-d H:i:s");
		}

		$this->_postdata['regist_date'] = date('Y-m-d H:i:s');

		$this->set_fields($this->_fields_add);
		$this->set_tbl('app_add');
		$this->insertTable();
		$this->_add_id = $this->_pdo->lastInsertId('id');
		$this->updateNR();
	}

	private function updateNR() {

		if (!isset($this->_postdata['noreply'])) {
			return;
		}

		if ($this->_postdata['add'] == 'magazine') {
			return;
		}

		$data[':noreply'] = $this->_postdata['noreply'];

		if ($this->_postdata['root_id']) {
			$data[':id'] = $this->_postdata['root_id'];
			$data[':root_id'] = $this->_postdata['root_id'];
		} else if ($this->_add_id) {
			$data[':id'] = $this->_add_id;
			$data[':root_id'] = $this->_add_id;
		} else {
			$data[':id'] = $this->_postdata['id'];
			$data[':root_id'] = $this->_postdata['id'];
		}

		$sql = <<< HERE
UPDATE app_add SET noreply = :noreply
 WHERE `id` = :id OR `root_id` = :root_id

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			throw new Exception('データベースへの処理に失敗しました。' . $e->getMessage());
		}
	}

	public function updateRead() {

		$addinfo = $this->getAppAddInfo();

		if ($addinfo['user_read']) {
			return;
		}

		$sql = <<< HERE
UPDATE app_add SET `user_read` = 1
 WHERE `id` = :id

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':id', (int) $addinfo['id'], PDO::PARAM_INT);
			$res->execute();

		} catch (PDOException $e) {
			throw new Exception('データベースへの処理に失敗しました。' . $e->getMessage());
		}
	}

	private function updateAddNoreply() {

		$data = $this->_postdata;

		$sql = <<< HERE
UPDATE app_add SET `noreply` = :noreply
 where `id` = :id OR `root_id` = :root_id

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("データベース処理が正しく行われませんでした。", 1);
		}
	}

	private function convertPost() {

		if (!isset($_POST)) {return;}
		if (!is_array($_POST)) {return;}

		if ($_POST['mail_body']) {
			$en = mb_detect_encoding($_POST['mail_body'], "EUC-JP,UTF-8,SJIS,SHIFT_JIS");
		} else if ($_POST['mail_subject']) {
			$en = mb_detect_encoding($_POST['mail_subject'], "EUC-JP,UTF-8,SJIS,SHIFT_JIS");
		}

		if ($en && $en != "UTF-8") {
			mb_convert_variables('UTF-8', $en, $_POST);
		}

	}

}
?>