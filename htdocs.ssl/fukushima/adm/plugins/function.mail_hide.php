<?php
function smarty_function_mail_hide($params, &$smarty) {

	extract($params);

	if ($mail_address != "") {

		if ($link_str == "") {
			$link_str = "≪こちらをクリック\<i class=\'fa fa-fw fa-envelope\'\>\<\/i\>≫"; //リンク文字列初期値
		}

		$ofset_var = rand(1, 100);

		$char_small = range('a', 'z');

		$func_length = rand(5, 10);

		$char_length1 = rand(3, 5);
		$char_length2 = rand(3, 5);

		$func_name = "a";

		for ($i = 0; $i < $func_length; $i++) {
			$func_name = $func_name . "" . $char_small[rand(0, 25)];
		}

		$func_name = $func_name . "Bc";

		for ($i = 0; $i < $char_length1; $i++) {
			$ofset_char = $ofset_char . "" . $char_small[rand(0, 25)];
		}

		$ofset_char = $ofset_char . "_";

		for ($i = 0; $i < $char_length2; $i++) {
			$ofset_char = $ofset_char . "" . $char_small[rand(0, 25)];
		}

		$result_char = "location.href='mailto:$mail_address'; ";

		$result_char_arr = str_split($result_char);

		for ($i = 0; $i < count($result_char_arr); $i++) {

			$result_char_arr[$i] = ord($result_char_arr[$i]) + $ofset_var;

		}

		$result_char = implode(" - $ofset_char,", $result_char_arr);
		$result_char = "$result_char - $ofset_char";

		$result_code = "<script type='text/javascript'>
function $func_name()
{
var $ofset_char = $ofset_var;
eval(String.fromCharCode($result_char));
}
document.write('<a href=\"javascript:void(0)\" onclick=\"$func_name(); return false;\">$link_str</a>');
</script>";

		return $result_code;

	}

	// 枠に収まる最大のサイズを変数に設定する
	//	$smarty->assign('image_calc_width', $calc_width);
	//	$smarty->assign('image_calc_height', $calc_height);
}
?>
