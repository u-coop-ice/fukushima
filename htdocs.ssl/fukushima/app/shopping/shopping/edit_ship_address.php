<?php

$refferdata = [];

if (isset($_GET['cmp'])) {
	$refferdata['component'] = addslashes($_GET['cmp']);
	if (isset($_GET['part'])) {
		$refferdata['part'] = addslashes($_GET['part']);
	}
}

if (isset($_GET['md'])) {
	$refferdata['mode'] = addslashes($_GET['md']);
}
$smarty->assign("reffer", $refferdata);
HTTP_Session2::set('refferdata', $refferdata);

$view_ship_address_id = intval($_GET['address_id']);
$smarty->assign("view_ship_address_id", $view_ship_address_id);

$tmpl = 'edit_ship_address.tpl';

$return_url = $self . "?mode=list_ship_address";

if ($refferdata["component"]) {
	$return_url = "/app/" . $refferdata["component"] . "/";
	if ($refferdata["part"]) {
		$return_url .= $refferdata["part"] . "/";
	}
	if ($refferdata["mode"]) {
		$return_url .= "?mode=" . $refferdata["mode"];
	}
}

$smarty->assign("return_url", $return_url);

if (!$view_ship_address_id) {
	$smarty->assign("new_address", 1);
}

?>
