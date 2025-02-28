<?php
class checkMembership extends commonDB {

	private $_birthday;
	private $_membership;

	public function set_regist_id($_regist_id) {$this->_regist_id = $_regist_id;}

	public function getRegist() {
		if (!$this->_id) {return;}

		$this->set_tbl('regist');
		$regist = $this->selectTable();

		$this->_birthday = $regist['birthday'];
		$this->_membership = $regist['membership'];
	}

	public function getMembership() {

//IPチェック
		if (!preg_match("/^61\.202\.140/", $_SERVER['SERVER_ADDR'])) {
			return;
		}

		$this->getRegist();
		if (!$this->_membership) {return;}
		if (!$this->_birthday) {return;}
		global $idms_salt, $idms_serviceID, $idms_base_url;
		$coopID = $_SESSION['config']['membershipfirst4'];
		//$idms_salt = '8yMUeDJtDy3v6kg3XmFC';
		//$idms_serviceID = 'DdKgAAfsvH';
		//$idms_base_url = 'https://kapi.seikyou.jp/kapi/kumiaiCheck';
		//$coopID = '2105';

		$time = date("YmdHi");
		$hash = hash("sha512", $idms_salt . $time, false); // hash計算

		$membershipNumber = $this->_membership;
		$birthday = $this->_birthday;

/* query sample
/kapi/kumiaiCheck?serviceId=p2ksample&serviceToken=1a2B3c4D5e6F7g8H9i0JakbLcmdNeo&tankyoCd=5101&kumiaiNo=999999999999&birthday=20000101
 */

		$data = array(
			'serviceId' => $idms_serviceID,
			'serviceToken' => $hash,
			'tankyoCd' => $coopID,
			'kumiaiNo' => $membershipNumber,
			'birthday' => $birthday,
		);

		$query = "?" . http_build_query($data);

//		echo $idms_base_url . $query;

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $idms_base_url . $query);
//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		//curl_setopt($curl, CURLOPT_POST, true);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // jsonデータを送信
		//curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // リクエストにヘッダーを含める
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);

		$response = curl_exec($curl);
		curl_close($curl);
		return simplexml_load_string($response);
	}
}
?>