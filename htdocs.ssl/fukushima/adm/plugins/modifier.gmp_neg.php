<?php
function smarty_modifier_gmp_neg($string) {
	$string = intval($string);
	$string = $string * (-1);
	// 結果の文字列を返す
	return $string;
}
?>
