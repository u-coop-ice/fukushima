<?php
Trait execSignOut {

	private function setSignOut(Auth $_auth, string $_kind) {

		if (!$_auth->getAuth()) {
			return;
		}

		$_logdata = [
			'username' => $_auth->getUsername(),
			'kind' => $_kind,
		];

		$this->setLogdata($_logdata);
		$this->setLog();

		$_auth->logout();
		setcookie('_rmbm', '', time() - 3600 * 24 * 30, '/');
		// セッションデータを空にする
		HTTP_Session2::set(COMPONENT . 'data', []);
		HTTP_Session2::destroy();
		$this->_smarty->assign('login', 0);

	}
}
?>
