<?php
trait execConfig {

	public function saveConfig() {

		$fields_base_config = [
			'store_ordermail' => 'text',
			'store_name' => 'text',
			'store_time' => 'text',
			'store_address' => 'text',
			'store_phonenumber' => 'text',
			'store_faxnumber' => 'text',
		];

		$fields_config = [];

		foreach ($fields_base_config as $_filed => $_value) {
			if (isset($_POST[$_filed])) {
				$fields_config[$_filed] = $_value;
			}
		}

		if (!count($fields_config)) {
			return;
		}

		$postdata = $this->execSanitize($fields_config, []);

		if ($postdata['store_ordermail']) {

			$emails = explode(',', $postdata['store_ordermail']);

			foreach ($emails as $email) {
				if (!self::checkFormatEmail($email)) {
					throw new Exception("Error email format", 1);
				}
			}
		}

		$component = $_SESSION['config']['component'];
		$component[COMPONENT] = array_merge($component[COMPONENT], $postdata);

		$configdata = [
			'component' => json_encode($component),
			'univ_id' => $_SESSION['config']['univ_id'],
		];

		$this->set_postdata($configdata);
		$this->set_fields(['component' => 'text']);
		$this->set_where(['univ_id' => 'integer']);
		$this->set_tbl('init_config');
		$this->updateTable();

		$_SESSION['config']['component'][COMPONENT] = $component[COMPONENT];

		$logdata['process'] = 'save_config';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();
	}

}
?>