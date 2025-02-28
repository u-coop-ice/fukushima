<?php
Trait execRememberMe {

	private function replaceRememberme() {

		if (!$this->_userAuth->getAuth()) {
			return;
		}

		if (intval($_POST['rememberme'])) {
			$sql = "SELECT username FROM {$this->_pfx}regist_rememberme WHERE `username` = :username";
			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindParam(':username', $this->_userAuth->getUsername(), PDO::PARAM_STR);
				$res->execute($data);
			} catch (PDOException $e) {
//強制サインアウト処理
				$this->setSignOut($this->_userAuth, 'forced_signout');
				header("Location: " . $init_urls . "?signout=1");
				exit();
			}

			$ct = $res->rowCount();

			$rememberme = $this->updateRememberme($ct);
			setcookie('_rmbm', $rememberme, time() + 60 * 60 * 24 * 30, '/');
		}

	}

	private function updateRememberme(int $is_exist) {

		$rememberme = md5($this->_userAuth->getUsername() . time() . $_SESSION['config']['salt']);
		$rememberme .= '_' . md5(mt_rand() . $_SESSION['config']['salt'] . time());

		$fileds = [
			'username' => 'text',
			'rememberme' => 'text',
		];

		$where = [
			'username' => 'text',
		];

		$data = [
			'rememberme' => $rememberme,
			'username' => $this->_userAuth->getUsername(),
		];

		$this->set_postdata($data);
		$this->set_fields($fileds);
		$this->set_where($where);
		$this->set_tbl($this->_pfx . 'regist_rememberme');

		switch ($is_exist) {
		case 1:
			$this->updateTable();
			break;
		case 0:
			$this->insertTable();
			break;
		}

		return $rememberme;
	}

	private function checkRememberme() {

		if (isset($_COOKIE["_rmbm"]) && !$this->_userAuth->getAuth()) {

			$rmbm = htmlspecialchars($_COOKIE["_rmbm"], ENT_QUOTES, 'UTF-8');

			$signin = array();

			$sql = <<< HERE
SELECT COUNT(r.username) AS ct,e.* FROM {$this->_pfx}regist_rememberme AS r
 JOIN {$this->_pfx}regist AS e ON r.username = e.username WHERE r.rememberme = :rememberme
 AND e.`status` = 1 AND r.date > (NOW() - INTERVAL 30 DAY)

HERE;

			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindParam(':rememberme', $rmbm, PDO::PARAM_STR);
				$res->execute();
			} catch (PDOException $e) {
// データベースアクセスに失敗したらエラーとする
				$error = "データ取得失敗";
				return;
			}
			$signin = $res->fetch();

			if ($signin['ct'] == 1 && $signin['username']) {

				$this->_userAuth->setAuth($signin['username']);

				$_SESSION[$this->_pfx . 'mode'] = 1;

				foreach ($signin as $k => $v) {
					if ($k == 'username' || $k == 'password' || $k == 'ct') {continue;}
					$this->_userAuth->setAuthData($k, $v);
				}

				$this->setUserAuthData();

//remebermeの更新
				$rememberme = $this->updateRememberme($signin['ct']);

//cookieの更新
				setcookie('_rmbm', $rememberme, 0, '/');
				setcookie('_rmbm', $rememberme, time() + 60 * 60 * 24 * 30, '/');

// remembermeからの復帰をログに保存
				$logdata['kind'] = 'rememberme';
				$logdata['username'] = $this->_userAuth->getUsername();

				$this->setLogdata($logdata);
				$this->setLog();
			}

		}

	}

}
?>
