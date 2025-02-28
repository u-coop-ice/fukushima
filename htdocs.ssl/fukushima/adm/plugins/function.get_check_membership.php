<?php
function smarty_function_get_check_membership($params, &$smarty) {
	$regist_id = $params['regist_id'];
	require_once "Classes/checkMembership.class.php";

	$cm = new checkMembership();
	$cm->set_id($regist_id);
	$response = $cm->getMembership();
	if (is_null($response)) {return;}
	$smarty->assign('idms_requestNo', $response->requestNo);
	$smarty->assign('idms_statusCd', $response->status->statusCd);
	$smarty->assign('idms_isExist', intval($response->result->isExist));
//	$smarty->assign('idms_kumiaiKbn', $response->result->kumiaiKbn);

//	$idms_kumiaiKbnList = array(0 => '仮組合員（非組合員）', 1 => '組合員（整理対象組合員、債務整理対象者）', 2 => '脱退者', 3 => '債務整理者');
	$idms_kumiaiKbnList = array(0 => '仮組合員（非組合員）', 1 => '組合員', 2 => '脱退者', 3 => '債務整理者');
	$idms_errorMessageList = array(
		0 => '正常	問合せ検索の結果、正常な結果を応答した。',
		100 => '該当なし	検索条件に該当する組合員が一意に特定できなかった。',
		200 => 'サービス利用不可	サービスIDの認証ができなかった。',
		210 => 'サービスID無効	サービスIDが無効になっている。',
		800 => 'パラメータエラー	不正な問合せにより発生したエラー',
		900 => 'システムエラー	システムの異常により発生したエラー',
	);
	$statusCd = intval($response->status->statusCd);
	if ($statusCd >= 100) {
		$smarty->assign('idms_errormsg', $idms_errorMessageList[$statusCd]);
	}

	$kumiaiKbn = intval($response->result->kumiaiKbn);
	$smarty->assign('idms_kumiaiKbn', $idms_kumiaiKbnList[$kumiaiKbn]);

}
?>
