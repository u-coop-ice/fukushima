<?php

$authority = $smarty->getTemplateVars('authority');

$user = $auth->getAuthdata();

$smarty->assign('user', $user);

$smarty->assign('saved', $_GET['saved']);

$smarty->display('edit_myself.tpl');
?>
