<?php

//namespace access\sg;

//require_once "composer/vendor/autoload.php";

class setAccessSendgrid {
	public function __construct() {
		global $smarty;
		$this->_smarty = $smarty;
		$this->_sg = new \SendGrid($this->_smarty->getConfigVars('sendgrid_api_key'));
	}
	public function __destruct() { /* デストラクタ */}

	private $_qp = null;
	private $_emails;
	private $_email;

	public function set_qp($_qp) {
		return $this->_qp = $_qp;
	}

	public function set_email($_email) {
		return $this->_email = $_email;
	}

	public function set_emails(array $_emails) {
		return $this->_emails = $_emails;
	}

	public function clearBounces() {
		$response_all = $this->getBounces();
		$bounces = json_decode($response_all->body(), true);

		if (count($bounces)) {

			foreach ($bounces as $bounce) {
				if ($this->_email == $bounce['email']) {
					$this->set_emails([$bounce['email']]);
					if (time() > $bounce['created'] + 20 * 1) {
						$this->deleteBounces();
					}
					break;
				}
			}

		}

	}

	public function getBounces() {
		$responce = $this->_sg->client->suppression()->bounces()->get(null, $this->_qp);
		return $responce;
	}

	public function getBlocks() {
		$responce = $this->_sg->client->suppression()->blocks()->get(null, $this->_qp);
		return $responce;
	}

	public function deleteBounces() {
		$request_body['emails'] = $this->_emails;
		$responce = $this->_sg->client->suppression()->bounces()->delete($request_body);
		return;
	}

}
?>
