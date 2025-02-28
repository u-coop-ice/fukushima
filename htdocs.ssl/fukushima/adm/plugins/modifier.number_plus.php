<?php
function smarty_modifier_number_plus($string) {
	if (intval($string) > 0) {
		$string = '+' . number_format($string);
	} else if (intval($string) < 0) {
		$string = number_format($string);
	} else {
		$string = '-';
	}
	// 結果の文字列を返す
	return $string;
}
?>
