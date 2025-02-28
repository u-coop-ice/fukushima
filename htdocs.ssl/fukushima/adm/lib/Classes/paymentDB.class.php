<?php
class paymentDB extends commonDB {

	public function __construct() {
		parent::__construct();
	}

	public function __destruct() { /* デストラクタ */}

	private $_app_id;
	public function set_app_id($_app_id) {$this->_app_id = $_app_id;}

	public function getPayment() {
		$app_id = $this->_app_id;

		$sql = <<< HERE
SELECT SUM(s.price * s.num) + a.postage as `total_price`
 FROM app AS a,app_sub AS s
WHERE  a.id = s.app_id AND a.id = ?

HERE;

		$data = array($app_id);

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {

			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('errmsg', 'データベース処理が正しく行われませんでした(pm)。');
			$this->displayError();
		}
		$result = $res->fetch();
		return $result['total_price'];
	}

}