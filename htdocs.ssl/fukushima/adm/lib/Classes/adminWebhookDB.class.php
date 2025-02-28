<?php
class adminWebhookDB extends commonDB {

	use baseFunction;
	use baseSendmail;
	use baseApp;
	use execApp;
	use execAdminCreditCard;
	use execPayment;
	use execShoppingCategories;
	use execShoppingItems;
	use execShoppingApp;
	use checkInitConfig;
	use checkRegist;
	use checkApp;
	use execAppAdd;
	use execLog;
//	use execThrowAtSlack;

	const _admin_email = 'shirota.kiyohiro@u-coop.jp';

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	protected $_config;

	public function set_config(array $_config) {$this->_config = $_config;}

	/**
	 * Hmacのハッシュを比較する
	 * @static
	 * @param array $key_pair
	 * @param string $content_hmac
	 * @param string $messagebody
	 * @return 求めたHmacハッシュ値と$content_hmacの比較結果
	 */

	public static function getHmac(array $key_pair, string $content_hmac, string $messagebody) {

		if (empty($messagebody)) {
			throw new Exception("パラメーターが不正です", 1);
		}

		$content_hmac = self::getSecret($content_hmac);

		$secretKey = $key_pair[$content_hmac['merchant_ccid']];

		if (empty($secretKey)) {
			throw new Exception("パラメーターが不正です", 1);
		}

		// バイナリ文字列に変更
		$encryptionKeyBytes = pack('H*', $secretKey);

		// ハッシュ生成
		$hash = hash_hmac("sha256", $messagebody, $encryptionKeyBytes);

		return $hash;
	}

	public static function checkHmac(array $key_pair, string $content_hmac, string $messagebody) {

		if (empty($messagebody)) {
			throw new Exception("パラメーターが不正です", 1);
		}

		$content_hmac = self::getSecret($content_hmac);

		$secretKey = $key_pair[$content_hmac['merchant_ccid']];

		if (empty($secretKey)) {
			throw new Exception("パラメーターが不正です", 1);
		}

		// バイナリ文字列に変更
		$encryptionKeyBytes = pack('H*', $secretKey);

		// ハッシュ生成
		$hash = hash_hmac("sha256", $messagebody, $encryptionKeyBytes);

		if ($hash != $content_hmac['hmac']) {
			throw new Exception("パラメーターが不正です(hmac)", 1);
		}
		return;
	}

	private static function getSecret($sContentHmac) {
		// パラメータ【$sContentHmac】の入力チェック
		if (empty($sContentHmac)) {
			throw new Exception("パラメーターが不正です", 1);
		}

		// 区切り文字列
		$delimiterS = ";s=";
		$delimiterV = ";v=";

		// 区切り文字の位置を算出
		$posS = strpos($sContentHmac, $delimiterS);
		$posV = strpos($sContentHmac, $delimiterV);

		// 区切り文字が見つからない場合
		if ($posS == FALSE) {
			throw new Exception("パラメーターが不正です", 1);
		}
		if ($posV == FALSE) {
			throw new Exception("パラメーターが不正です", 1);
		}

		// パラメータからシークレット部分の文字列のみを取得する
		$s_pos = $posS + strlen($delimiterS);
		$l_pos = $posV - $posS - strlen($delimiterS);
		$content_hmac['merchant_ccid'] = substr($sContentHmac, $s_pos, $l_pos);

		if (empty($content_hmac['merchant_ccid'])) {
			throw new Exception("パラメーターが不正です", 1);
		}

		// パラメータからHmac部分の文字列のみを取得する
		$h_pos = $posV + strlen($delimiterV);
		$content_hmac['hmac'] = substr($sContentHmac, $h_pos);

		if (empty($content_hmac['hmac'])) {
			throw new Exception("パラメーターが不正です", 1);
		}
		return $content_hmac;
	}

	public function setSessionConfig() {
		$this->selectInitConfig();
	}

	public function saveWebHook() {

		if ($_SERVER["REQUEST_METHOD"] === "POST") {
// 受信したPOSTの内容をログファイルに記録
			$body = file_get_contents('php://input');
		}

		if (!$body) {
			throw new Exception("NO Webhook Body!!", 1);
		}

		$json = json_decode($body);

		$fields = [
			'email' => 'text',
			'smtp_id' => 'text',
			'timestamp' => 'integer',
			'sg_event_id' => 'text',
			'sg_message_id' => 'text',
			'send_at' => 'text',
			'user_id' => 'integer',
			'regist_id' => 'integer',
			'univ_id' => 'integer',
			'magazine_id' => 'integer',
			'component' => 'text',
			'part' => 'text',
			'category_id' => 'integer',
			'add_code' => 'text',
			'event' => 'text',
			'status' => 'text',
			'tls' => 'integer',
			'type' => 'text',
			'response' => 'text',
			'reason' => 'text',
			'ip' => 'text',
			'webhook' => 'text',
		];
		$this->set_fields($fields);
		$this->set_tbl('webhook_sendgrid');

		$data = [];
		foreach ($json as $key => $value) {
			$data[$key] = $value;
		}

		$data['smtp_id'] = $data['smtp-id'];

		$this->set_postdata($data);
		$this->insertTable();

		$this->updateRegistEmailFlag($data);

	}

	private function countSgMessageID($_sg_message_id) {

		$ct = 0;

		if (!$_sg_message_id) {
			return $ct;
		}

		$sql = <<< HERE
SELECT COUNT(id) AS ct FROM webhook_sendgrid WHERE `sg_message_id` = :sg_message_id
HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':sg_message_id', $_sg_message_id, PDO::PARAM_STR);
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("DB ERROR", 1);
		}

		$ct = $res->fetchColumn();
		return $ct;

	}

	private function updateRegistEmailFlag($_data) {

		if ($_SESSION['config']['univ_id'] != $_data['univ_id']) {
			return;
		}

		if (!$_data['regist_id']) {
			return;
		}

		$this->set_regist_id($_data['regist_id']);
		$registinfo = $this->getRegistInfo();

		switch ($_data['event']) {
		case 'bounce':
		case 'dropped':

			if (!$registinfo['email']) {
				return;
			}

			$ct = $this->countSgMessageID($_data['sg_message_id']);

			if ($ct > 1) {
				return;
			}

			$sql = <<< HERE
UPDATE regist SET `send_error` = IFNULL(`send_error`,0) + 1 WHERE `id` = :regist_id
HERE;

			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindValue(':regist_id', $_data['regist_id'], PDO::PARAM_INT);
				$res->execute();
			} catch (PDOException $e) {
				throw new Exception("DB ERROR", 1);
			}

			$this->returnErrorMail($_data, $registinfo);

			break;
		case 'delivered':
			if (intval($registinfo['send_error']) > 0) {

				$sql = <<< HERE
UPDATE regist SET `send_error` = 0 WHERE `id` = :regist_id
HERE;

				try {
					$res = $this->_pdo->prepare($sql);
					$res->bindValue(':regist_id', $_data['regist_id'], PDO::PARAM_INT);
					$res->execute();
				} catch (PDOException $e) {
					throw new Exception("DB ERROR", 1);
				}

			}
			break;
		}

	}

	private function returnErrorMail($_data, $_registinfo) {
		if ($_data['add_code']) {

			$this->set_tbl('app_add');
			$this->set_where(['code' => 'text', 'regist_id' => 'integer']);
			$this->set_postdata(['code' => $_data['add_code'], 'regist_id' => $_data['regist_id']]);
			$return_mail = $this->selectTable();
			$return_mail['body'] = $return_mail['memo'];

		} else if ($_data['magazine_id']) {
			$this->set_tbl('magazine');
			$this->set_where(['id' => 'integer']);
			$this->set_postdata(['id' => $_data['magazine_id']]);
			$return_mail = $this->selectTable();
		}

//メーラーデーモンを各生協に配信

		$subject = 'システムメール配信エラー';
		$init_ordermail = $_SESSION['config']['email'];
		$init_replymail = $_SESSION['config']['donotreply_email'];

		if ($_registinfo['namef']) {

			$name = $_registinfo['namef'] . ' ' . $_registinfo['nameg'];
		} else if ($_registinfo['username']) {
			$name = $_registinfo['username'];
		} else {
			$name = $_data['email'];
		}

		$mailbody = $name . "さま宛へのメールが届いていません。
以下、送信したメールの内容を添付します。

";

		$mailbody .= "---------------------------------------------\n";
		$mailbody .= "宛先: " . $name . "(" . $_data['email'] . "）\n";
		$mailbody .= "---------------------------------------------\n";
		if ($return_mail['subject']) {
			$mailbody .= "件名: " . htmlspecialchars_decode($return_mail['subject']) . "\n";
			$mailbody .= "---------------------------------------------\n";
			$mailbody .= htmlspecialchars_decode($return_mail['body']) . "\n";
		}
		if ($init_ordermail) {
			self::send_mail('メールサーバー', $init_replymail, $init_ordermail, $subject, $mailbody);
		}

	}

}
?>
