<?php
class adminMmDB extends commonDB {

	use adminAuth;
	use baseSendmail;
	use basefunction;
	use checkRegists;
	use checkMagazine;
	use execAppAdd;
	use execAdminLog;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	const _range = 1000;

	protected $_mail_group_id;
	protected $_mail_magazine_id;

	public function get_mail_group_id() {return $this->_mail_group_id;}
	public function get_mail_magazine_id() {return $this->_mail_magazine_id;}

	public function set_mail_group_id(int $_mail_group_id) {$this->_mail_group_id = $_mail_group_id;}
	public function set_mail_magazine_id(int $_mail_magazine_id) {$this->_mail_magazine_id = $_mail_magazine_id;}

	public function deleteMailMagazine() {

		if (!$this->_mail_magazine_id) {
			throw new Exception("no magazine_id", 1);
		}

		$this->set_where(['id' => 'integer']);
		$this->set_postdata(['id' => $this->_mail_magazine_id]);
		$this->set_tbl('mail_magazine');
		$this->deleteTable();

		$logdata['process'] = 'delete_magazine';
		$logdata['value'] = json_encode($this->_postdata);
		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteMailGroup() {

		if (!$this->_mail_group_id) {
			throw new Exception("no group_id", 1);
		}

		$this->set_where(['id' => 'integer']);
		$this->set_postdata(['id' => $this->_mail_group_id]);
		$this->set_tbl('mail_group');
		$this->deleteTable();

		$logdata['process'] = 'delete_mail_group';
		$logdata['value'] = json_encode($this->_postdata);
		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteMailMagazineAll() {

		if (!$this->_mail_group_id) {
			throw new Exception("no group_id", 1);
		}

		$this->set_where(['group_id' => 'integer']);
		$this->set_postdata(['group_id' => $this->_mail_group_id]);
		$this->set_tbl('mail_magazine');
		$this->deleteTable();

		$logdata['process'] = 'delete_magazine_all';
		$logdata['value'] = json_encode($this->_postdata);
		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	private function sanitizeCondition() {

		$fields_condition = [
			'component' => 'text',
			'forced' => 'integer',
			'year' => 'integer',
		];

		$condition = $this->baseSanitize($fields_condition, []);

		if (isset($_POST['category_id'])) {
			$condition['category_id'] = intval($_POST['category_id']);
		}

		if (isset($_POST['comedate'])) {
			$condition['comedate'] = addslashes($_POST['comedate']);
		}

		if (is_array($_POST['cometime'])) {
			$condition['cometime'] = array_map('addslashes', $_POST['cometime']);
		}

		if (is_array($_POST['item_id'])) {
			$condition['item_id'] = array_map('intval', $_POST['item_id']);
		}
		return $condition;
	}

	public function saveMailGroup() {

		$fields_sql_mg = array(
			'denomination' => 'text',
			'main_email' => 'text',
			'test_email' => 'text',
			'signature' => 'text',
			'memo' => 'text',
			'unsubscribe' => 'integer',
			'sort_order' => 'integer',
			'archived' => 'integer',
		);

		$postdata = $this->baseSanitize($fields_sql_mg, []);

		$condition = $this->sanitizeCondition();

		if (count($condition)) {
			$postdata['condition'] = json_encode($condition);
			$fields_sql_mg['condition'] = 'text';
		}

		if ($_POST['id']) {
			$postdata['id'] = intval($_POST['id']);
		}

		$this->set_fields($fields_sql_mg);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl('mail_group');

		if ($postdata['id']) {
			$this->set_postdata($postdata);
			$this->updateTable();
		}
// 既存コードの場合
		else {
			$this->set_postdata($postdata);
			$this->insertTable();
			$postdata['id'] = $this->get_last_insertId();
		}

		if (!$postdata['id']) {
			throw new Exception("データの処理に失敗しました。", 1);
		}

		$this->_mail_group_id = $postdata['id'];

		$logdata['process'] = 'save_mail_group';
		$logdata['value'] = $this->_mail_group_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function saveMailMagazine() {

		$fields_sql_mm = array(
			'group_id' => 'integer',
			'onetime' => 'integer',
			'subject' => 'text',
			'body' => 'text',
			'test_date' => 'text',
			'reserve' => 'text',
			'onreserve' => 'integer',
			'sent' => 'integer',
			'draft' => 'integer',
			'unsubscribe' => 'integer',
			'admin_user_id' => 'integer',
		);

		$postdata = $this->baseSanitize($fields_sql_mm, []);

		$condition = $this->sanitizeCondition();

		if (!$postdata['group_id'] && count($condition)) {
			$postdata['condition'] = json_encode($condition);
			$fields_sql_mm['condition'] = 'text';
		}

		if ($_POST['id']) {
			$postdata['id'] = intval($_POST['id']);
		}

		if (!$postdata['onreserve']) {
			$postdata['draft'] = 1;
		}

		$postdata['admin_user_id'] = $this->_adminAuth->getAuthData("id");

		$this->set_fields($fields_sql_mm);
		$this->set_postdata($postdata);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl('mail_magazine');

		if ($postdata['id']) {
			$this->updateTable();
		}
// 既存コードの場合
		else {
			$this->insertTable();
			$postdata['id'] = $this->get_last_insertId();
		}

		if (!$postdata['id']) {
			throw new Exception("データの処理に失敗しました。", 1);
		}

		$this->_mail_magazine_id = $postdata['id'];
		$this->_mail_group_id = $postdata['group_id'];

		$logdata['process'] = 'save_mail_magazine';
		$logdata['value'] = $this->_mail_magazine_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	private function getMagazines2send() {

		$sql = <<< HERE
SELECT
mm.*,
mg.signature AS signature,
mg.main_email AS main_email,
mg.unsubscribe AS group_unsubscribe,
mg.condition AS group_condition,
mm.admin_user_id AS admin_user_id,
iu.email AS admin_user_email
 FROM mail_magazine AS mm
LEFT JOIN mail_group AS mg ON mm.group_id = mg.id
LEFT JOIN init_user AS iu ON iu.id = mm.admin_user_id
WHERE mm.onreserve = 1 AND mm.reserve < NOW() GROUP BY mm.id

HERE;

		$this->_sql = $sql;
		$this->_fetchall = 1;

		$mags = $this->selectTable();

//送信済みにupdate
		$this->_magazines = $mags;

		if (count($mags)) {
			foreach ($mags as $mag) {
				$this->_fields = ['onreserve' => 'integer'];
				$this->_postdata = ['id' => $mag['id'], 'onreserve' => 0];
				$this->_where = ['id' => 'integer'];
				$this->_tbl = "mail_magazine";
				$this->updateTable();
			}
		}

	}

	public function sendMagazines() {
		global $etc_dir;
		$this->getMagazines2send();

		if (!is_array($this->_magazines)) {
			throw new Exception("error magaines is null.", 1);
		}
		if (!count($this->_magazines)) {
			throw new Exception("error magaines is null.", 1);
		}

		require_once 'composer/vendor/autoload.php';

		define('SENDGRID_API_KEY', $this->_config['sendgrid_api_key']);

		$sendgrid_api_key = SENDGRID_API_KEY;
		$sg = new \SendGrid($sendgrid_api_key);

		foreach ($this->_magazines as $magazine) {

			$params = [];
			if ($magazine['group_id']) {
				$params['group_id'] = $magazine['group_id'];
				$this->set_params($params);
//unsubscribeを上書き
				$magazine['unsubscribe'] = $magazine['group_unsubscribe'];

			} else if ($magazine['onetime']) {
				$params['condition'] = json_decode($magazine['condition'], ture);
				$this->set_params($params);
			} else {
				continue;
			}

			$this->setExcludeErrorMail();
			$regists = $this->getRegists();

			$sent_count = count($regists);

			if ($sent_count == 0) {
				continue;
			}

//メルマガ送信準備

			//エンティティ化解除
			$subject = $magazine['subject'];
			$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
			$body = $magazine['body'];
			$body = htmlspecialchars_decode($body, ENT_QUOTES);
			$signature = $magazine['signature'];
			$signature = htmlspecialchars_decode($signature, ENT_QUOTES);

			$maildata['noreply'] = 9;
			$maildata['subject'] = $subject;
			$maildata['send'] = 1;
			$maildata['add'] = 'magazine';

			if ($magazine['main_email']) {
				$from = $magazine['main_email'];
			} else {
				$from = "DO_NOT_REPLY@u-coop.or.jp";
			}

			$mbody = self::magazine_body($body, $this->_config, $signature, $magazine['unsubscribe']);

			foreach ($regists as $j => $regist) {

				if ($j % self::_range == 0) {

					$mail = new \SendGrid\Mail\Mail(
						new \SendGrid\Mail\From($from, $this->_config['init_coopname'])
					);
					$mail->addContent("text/plain", $mbody);
					$mail->setSubject($subject);
				}

				if ($regist['namef']) {
					$name = $regist['namef'] . " " . $regist['nameg'];
				} else {
					$name = $regist['username'];
				}

				$to = $regist['email'];

				if (!$to) {
					continue;
				}

				if (!$name) {
					continue;
				}

				if (!self::checkFormatEmail($to)) {
					continue;
				}

				$maildata['code'] = self::generateUuid();
				$maildata['regist_id'] = $regist['id'];
				$maildata['univ_id'] = $regist['univ_id'];
				$maildata['date'] = date('Y-m-d H:i:s');

				$maildata['memo'] = $name . "さま\n\n" . $body;

//app_addへ登録

				$this->set_postdata($maildata);
				$this->saveAppAdd();

				$personalization1 = new \SendGrid\Mail\Personalization();

				$tmp_email = new \SendGrid\Mail\To($to, $name);

				$personalization1->addTo($tmp_email);

				$personalization1->addSubstitution("%code%", $maildata['code']);
				$personalization1->addSubstitution("%name%", $name);
				$personalization1->addSubstitution("%urlencode_email%", urlencode($regist['username']));

				$personalization1->addCustomArg(new \SendGrid\Mail\CustomArg("regist_id", $maildata['regist_id']));
				$personalization1->addCustomArg(new \SendGrid\Mail\CustomArg("univ_id", $maildata['univ_id']));
				$personalization1->addCustomArg(new \SendGrid\Mail\CustomArg("admin_user_id", $magazine['admin_user_id']));
				$personalization1->addCustomArg(new \SendGrid\Mail\CustomArg("add_code", $maildata['code']));
				$personalization1->addCustomArg(new \SendGrid\Mail\CustomArg("magazine_id", $magazine['id']));

				$mail->addPersonalization($personalization1);

				if (($j > 0 && $j % (self::_range - 1) == 0) || ($j + 1) == $sent_count) {
					$response = $sg->send($mail);
				}

			}

			$mbody = "（メール配信システムからの配信が完了しました。）\n\n総配信数: $sent_count\n----------------------------------------------------\n（配信内容のコピー）\n\n" . $mbody;

			$this->sendMagazine2admin($mbody, $subject, $from, $magazine['admin_user_email']);

			$this->_fields = ['onreserve' => 'integer', 'sent_count' => 'integer', 'sent' => 'integer'];
			$this->_postdata = ['id' => $magazine['id'], 'onreserve' => 0, 'sent_count' => $sent_count, 'sent' => 1];
			$this->_where = ['id' => 'integer'];
			$this->_tbl = "mail_magazine";
			$this->updateTable();

		}

	}

	private function sendMagazine2admin($body, $subject, $from, $to) {
		$body = preg_replace("/%name%/", '生協管理者', $body);
		$body = preg_replace("/%code%/", 'XXXXXXXXXXXXXXXXXXXXXXXXXX', $body);
		$body = preg_replace("/%urlencode_email%/", 'XXXXXXXXXXXXXXXXXX', $body);

		$init_config = $this->getInitConfig();

		$arg = null;

		if (!$to) {
			$to = $init_config['email'];
		} else {
			$arg['cc'] = $init_config['email'];
		}
		self::send_mail($this->_config['init_coopname'], $from, $to, '【配信完了】' . $subject, $body, $arg);

	}

	static function magazine_body($body, $config, $signature = null, $unsubscribe) {

		$mbody = <<< HERE
%name%さま


{$body}

---------------------

【送信専用】当メールは送信専用ですので、当メールには返信できません。

このメールはサインイン後、以下URLでも確認できます。
{$config['init_url']}/app/user/?mode=show_mail&adic=%code%

HERE;

		if ($unsubscribe) {

			$mbody .= <<< HERE

---------------------

※当メールは、{$config["init_coopname"]}にユーザー登録された方に対してお送りしております。
今後、このようなお知らせが不要な方は、大変お手数ですが下記のURLより
配信停止処理（要サインイン）をお願いいたします。
{$config['init_url']}app/user/?mode=unsubscribe_mail&username=%urlencode_email%


HERE;

		}

		$mbody .= <<< HERE

---------------------
{$signature}

---------------------
{$config["init_coopname"]} {$config['init_url']}
HERE;

		return $mbody;
	}

	public function truncateSendgridLogs() {

		$sql = <<< HERE
DELETE FROM webhook_sendgrid
WHERE `date` + INTERVAL 1 MONTH < NOW()

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("DB ERROR" . $e->getMessage(), 1);
		}

		$logdata['process'] = 'truncate_log_sendgrid';
		$logdata['value'] = $res->rowCount();
		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

}
