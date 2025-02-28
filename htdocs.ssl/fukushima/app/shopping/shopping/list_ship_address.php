<?php

if (intval($_GET['deleted'])) {
	$smarty->assign("deleted", 1);
}
if (intval($_GET['saved'])) {
	$smarty->assign("saved", 1);
}

$tmpl = 'list_ship_address.tpl';

?>
