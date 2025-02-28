<?php
$magazine_id = intval($_GET['magazine_id']);
$smarty->assign('view_magazine_id', $magazine_id);
$smarty->display('show_magazine.tpl');
?>
