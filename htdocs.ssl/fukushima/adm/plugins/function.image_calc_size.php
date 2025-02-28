<?php
function smarty_function_image_calc_size($params, &$smarty) {
	// 画像の元のサイズを得る
	$image_width = $smarty->getTemplateVars('image_width');
	$image_height = $smarty->getTemplateVars('image_height');
	// 枠のサイズを得る
	$calc_width = $params['calc_width'];
	$calc_height = $params['calc_height'];

	// 強制的にリサイズするかどうかを得る
	$force = $params['force'];
	if (empty($force)) {
		$force = true;
	}
	// 枠に収まる最大のサイズを求める
	if ($image_width > $calc_width || $image_height > $calc_height || $force) {
		if (($image_width / $image_height) >= ($calc_width / $calc_height)) {
			$ratio = $calc_width / $image_width;
		} else {
			$ratio = $calc_height / $image_height;
		}
		$calc_width = intval($image_width * $ratio);
		$calc_height = intval($image_height * $ratio);
	} else {
		$calc_width = $image_width;
		$calc_height = $image_height;
	}
	// 枠に収まる最大のサイズを変数に設定する
	$smarty->assign('image_calc_width', $calc_width);
	$smarty->assign('image_calc_height', $calc_height);
}
?>
