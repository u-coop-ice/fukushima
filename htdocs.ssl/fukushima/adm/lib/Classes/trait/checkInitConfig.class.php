<?php
Trait checkInitConfig {

	private function selectInitConfig() {
		if (!$_SESSION['config']) {
			// 初期設定テーブルの読み込み
			$this->set_tbl('init_config');
			$this->set_where(array('univ_id' => "integer"));
			if (is_object($this->_smarty)) {
				$this->set_postdata(['univ_id' => $this->_smarty->getConfigVars('univ_id')]);
			} else if ($this->_config['univ_id']) {
				$this->set_postdata(['univ_id' => $this->_config['univ_id']]);
			}
			$config = $this->selectTable();

			$config['component'] = json_decode($config['component'], true);
			$_SESSION['config'] = $config;
			if (is_object($this->_smarty)) {
				$_SESSION['config']['salt'] = $this->_smarty->getConfigVars('salt');
			}
		}
	}
}
?>
