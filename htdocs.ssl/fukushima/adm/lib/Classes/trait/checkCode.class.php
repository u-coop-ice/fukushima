<?php
trait checkCode {

//学部学科取得

	public function getInitCodes() {

		$sql = <<< HERE
SELECT * FROM init_code WHERE univ_id = :univ_id

HERE;

// クエリを実行する

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':univ_id', $this->_smarty->getConfigVars('univ_id'), PDO::PARAM_INT);
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("DataBase Error", 1);
		}

		while ($code = $res->fetch()) {
			$codes[$code['name']][$code['id']] = $code['value'];
		}

		return $codes;

	}
}
?>