<?php
function smarty_modifier_mb_truncate($string, $length, $alt_str = '', $encoding = 'UTF-8') {
	// 元の文字列をいったんEUCに変換する
	$string = mb_convert_encoding($string, 'euc-jp', $encoding);
	// 元の文字列の長さを調べる
	$org_len = mb_strlen($string, 'euc_jp');
	// 指定した長さで文字列を切り取る
	$string = mb_strcut($string, 0, $length, 'euc-jp');
	// 切り取った後の文字列の長さを調べる
	$cut_len = mb_strlen($string, 'euc-jp');
	// 切り取りが行われていて、かつ代替文字列が指定されていたら、
	// 文字列の末尾に代替文字列を付加する
	if ($org_len != $cut_len && $alt_str) {
		$string .= mb_convert_encoding($alt_str, 'euc-jp', $encoding);
	}
	// 元の文字コードに戻す
	$string = mb_convert_encoding($string, $encoding, 'euc-jp');
	// 結果の文字列を返す
	return $string;
}
?>
