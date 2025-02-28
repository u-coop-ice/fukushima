<?php

$ajx = new adminAjaxDB();
$regists = $ajx->searchRegists();

echo json_encode($regists);
exit();

?>
