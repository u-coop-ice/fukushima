<?php
if (isset($_GET['username'])) {
	$entrydata['email'] = urldecode($_GET['username']);
	$entrydata['email'] = htmlspecialchars($entrydata['email'], 3, 'UTF-8');
	$smarty->assign('post', $entrydata);
}

$postdata = [];
HTTP_Session2::set('postdata', $postdata);
$smarty->display('remind.tpl');
?>
