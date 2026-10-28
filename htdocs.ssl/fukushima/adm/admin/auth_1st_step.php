<?php
$result = [];

try {
	$adm = new admin2FactorAuthDB;
	$result = $adm->check2FactorAuth();

} catch (Exception $e) {
	$result['error'] = $e->getMessage();
}

if (isset($result['valid']) && $result['valid'] === true) {

	$_POST['username'] = $result['username'];
	$_POST['password'] = $result['password'];

	$auth = new Auth('PDO', $options, 'loginFunction');
	$auth->setSessionName(DOMAIN . '_adm');
	$auth->start();

	unset($_SESSION["secret_2factor"]);
	unset($_SESSION["secret_pfx2"]);

}

$result['session'] = $_SESSION;

echo json_encode($result);
exit();

?>
