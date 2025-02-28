<?php

use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;

trait checkGoogleRecaptcha {

	static public function create_assessment(string $token): void {

		if (!$token) {
			throw new Exception("チェックエラー。", 9);
		}

		putenv("GOOGLE_APPLICATION_CREDENTIALS=" . self::GOOGLE_APPLICATION_CREDENTIALS);

		$client = new RecaptchaEnterpriseServiceClient();
		$projectName = $client->projectName(self::PROJECT_ID);

		$event = (new Event())
			->setSiteKey(self::SITEKEY)
			->setToken($token);

		$assessment = (new Assessment())
			->setEvent($event);

		try {
			$response = $client->createAssessment(
				$projectName,
				$assessment
			);

			if ($response->getTokenProperties()->getValid() == false) {
				throw new Exception("重大なエラーが発生しました。", 1);
			} else {
				$score = $response->getRiskAnalysis()->getScore();
				if ($score < 0.5) {
					throw new Exception("しばらく時間をおいてアクセスしてください。", 1);
				}
			}
		} catch (exception $e) {
			throw new Exception("サーバーからの応答がありません。" . $e->getMessage(), 1);
		}
	}

}
?>