<?php
Trait baseSendmail {

	static function send_mail($name, $address, $to, $subject, $body, $arg = null) {
		require_once 'composer/vendor/autoload.php';

		$mail = new SendGrid\Mail\Mail();

		$subject = $subject;

		$tos = explode(',', $to);
		$toss = array_unique($tos);
		foreach ($toss as $to) {
			$mail->addTo((string) $to);
		}

		if (isset($arg['cc']) && $arg['cc']) {
			$ccs = explode(',', $arg['cc']);
			$ccss = array_unique($ccs);
			$ccss = array_diff($ccss, $toss);
			if (count($ccss)) {
				foreach ($ccss as $cc) {
					$mail->addCc((string) $cc);
				}
			}
		}
		if (isset($arg['bcc']) && $arg['bcc']) {
			$bccs = explode(',', $arg['bcc']);
			$bccss = array_unique($bccs);

			$bccss = array_diff($bccss, $toss);

			if (count($bccss)) {
				foreach ($bccss as $bcc) {
					$mail->addBcc((string) $bcc);
				}
			}
		}

		if (isset($arg['regist_id']) && $arg['regist_id']) {
			$mail->addCustomArg("regist_id", (string) $arg['regist_id']);
		}
		if (isset($arg['univ_id']) && $arg['univ_id']) {
			$mail->addCustomArg("univ_id", (string) $arg['univ_id']);
		}

		if (isset($arg['category_id']) && $arg['category_id']) {
			$mail->addCustomArg("category_id", (string) $arg['category_id']);
		}
		if (isset($arg['component']) && $arg['component']) {
			$mail->addCustomArg("component", (string) $arg['component']);
			if (isset($arg['part']) && $arg['part']) {
				$mail->addCustomArg("part", (string) $arg['part']);
			}
		}

		if (isset($arg['add_code']) && $arg['add_code']) {
			$mail->addCustomArg("add_code", (string) $arg['add_code']);
		}

		if (isset($arg['admin_user_id']) && $arg['admin_user_id']) {
			$mail->addCustomArg("admin_user_id", (string) $arg['admin_user_id']);
		}

		if (isset($arg['magazine_id']) && $arg['magazine_id']) {
			$mail->addCustomArg("magazine_id", (string) $arg['magazine_id']);
		}

		if (!preg_match('/@u-coop\.or\.jp$/', $address)) {
			$address = "DO_NOT_REPLY@u-coop.or.jp";
		}

		$mail->setFrom($address, $name);
		$mail->setSubject($subject);
		$mail->addContent("text/plain", $body);

		$apiKey = SENDGRID_API_KEY;

		$sg = new \SendGrid($apiKey);

		$response = $sg->send($mail);
	}

/*

static function send_mail($name, $address, $to, $subject, $body, $cc = null, $bcc = null, $return = null, $comment = null) {
global $init_errormail;
mb_language("Ja");
mb_internal_encoding("UTF-8");
$from = "From:" . mb_encode_mimeheader($name) . "<" . $address . ">";
if ($cc) {
$from .= "\n";
$from .= "Cc:" . $cc;
}
if ($bcc) {
$from .= "\n";
$from .= "Bcc:" . $bcc;
}
$add = null;
if ($return) {
$add = '-f ' . $return;
} else if ($init_errormail) {
$add = '-f ' . $init_errormail;
} else if ($_SESSION['config']['error_email']) {
$add = '-f ' . $_SESSION['config']['error_email'];
}
if ($comment) {
$from .= "\n";
$from .= "Comments:" . $comment;
}

$body = mb_convert_encoding($body, 'iso-2022-jp', 'UTF-8');
// メールのヘッダー
$header = $from;

return mb_send_mail($to, $subject, $body, $from, $add);
}
 */
}
?>
