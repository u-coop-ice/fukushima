<?php
try {

	$refferdata = HTTP_Session2::get('refferdata');

	if ($refferdata["reffer"] == "user") {
		$referdata = [];
	}

	$smarty->assign("reffer", $refferdata);

	unset($refferdata["reffer"]);
	if (is_array($refferdata)) {
		if (count($refferdata)) {
			$queries = array();
			foreach ($refferdata as $k => $v) {
				array_push($queries, $k . '=' . $v);
			}
			$query = implode('&', $queries);
			$smarty->assign("query_reffer", $query);
		}
	}
	HTTP_Session2::set('refferdata', $refferdata);

	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->completeAppCreateRegist();

} catch (Exception $e) {
	$appCreateRegist::return2First();
}
exit();
?>
