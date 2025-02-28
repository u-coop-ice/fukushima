<?php
function smarty_function_get_regist_count($params, &$smarty) {
	// paramsから登録者数を取り出す
	$sq = new adminRegistDB;
	$sq->set_params($params);
	$sq->set_flag_count(1);
	$sq->skip_regist_id();
	$regist_count = $sq->getRegists();
	return $regist_count;
}
?>
