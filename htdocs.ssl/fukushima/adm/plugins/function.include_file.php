<?php
function smarty_function_include_file($params, &$smarty) {

	if (!$params['file']) {
		return;
	}

	$include_file = $_SERVER['DOCUMENT_ROOT'] . $params['file'];
	if (file_exists($include_file)) {
		include $include_file;
	}
}
?>
