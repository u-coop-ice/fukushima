<?php
function smarty_modifier_add_quote($string) {
	// 元の文字列をいったんEUCに変換する
	$string = preg_replace("/\n/", "\n&gt; ", $string);
//	$string = preg_replace("/&gt; &gt; /", "&gt;&gt; ", $string);
	$string = "> " . $string;
	return $string;
}
?>
