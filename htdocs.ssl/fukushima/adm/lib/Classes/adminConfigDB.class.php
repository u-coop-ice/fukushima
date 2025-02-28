<?php
class adminConfigDB extends commonDB {

	use adminAuth;
	use execConfig;
	use baseFunction;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function setSessionAdminConfig() {

		if (!count($_SESSION['config'])) {
			// 初期設定テーブルの読み込み
			$config = $this->getInitConfig();
			$_SESSION['config'] = $config;
		}

		$this->_smarty->assign('init_ordermail', $_SESSION['config']['email']);

		if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
			$this->_smarty->assign('init_ordermail', $_SESSION['config']['component'][COMPONENT]['store_ordermail']);
		}

		$this->_smarty->assign('init_errormail', $_SESSION['config']['error_email']);
		$this->_smarty->assign('infocode', $_SESSION['config']['component'][COMPONENT]['infocode']);
		$this->_smarty->assign('init_pagetitle', $_SESSION['config']['component'][COMPONENT]['title']);
		$this->_smarty->assign('init_inherit', intval($_SESSION['config']['inherit']));

		$this->_smarty->assign('component', $_SESSION['config']);

	}

}
