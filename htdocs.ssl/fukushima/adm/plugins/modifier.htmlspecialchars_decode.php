<?php

function smarty_modifier_htmlspecialchars_decode($string) {

	$string = htmlspecialchars_decode($string, ENT_QUOTES);
	// 結果の文字列を返す
	return $string;
}
?>
