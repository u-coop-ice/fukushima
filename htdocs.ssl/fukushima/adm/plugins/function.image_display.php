<?php
function smarty_function_image_display($params, &$smarty) {

	$calc_width = intval($params['calc_width']);
	$im = array();

	if (array_key_exists('image', $params)) {
		$item['image'] = $params['image'];
	} else if ($smarty->getTemplateVars('itm')) {
		$im = $smarty->getTemplateVars('itm');
		$item['image'] = $im['image'];
	} else if ($smarty->getTemplateVars('item')) {
		$im = $smarty->getTemplateVars('item');
		$item['image'] = $im['image'];
	}

	// 画像のファイルパスを取得
	if ($item["image"]) {
		$image_name = $item["image"];
	} else {
		$image_name = "no_image.jpg";
	}
	$image = '/' . APP_DIR . COMPONENT . '/images/';

	if ($calc_width) {
		$image2 = $image . $calc_width * 2 . '_';
		$image .= $calc_width . '_';
	}

	$image .= $image_name;
	$image2 .= $image_name;

	if (file_exists(ROOT_DIR . $image)) {
		$img = new Imagick();
		$img->readImage(ROOT_DIR . $image);
		$fileinfo = $img->identifyImage();
		$image_width = $fileinfo['geometry']['width'];
		$image_height = $fileinfo['geometry']['height'];
	}

	if (file_exists(ROOT_DIR . $image2)) {
		$image_srcset = $image . " 1x," . $image2 . " 2x";
	}

	$image_src = $image;

	$image_attr = 'width="' . $image_width . '" height="' . $image_height . '" ';
	// 枠に収まる最大のサイズを変数に設定する

	$smarty->assign('image_attr', $image_attr);
	$smarty->assign('image_src', $image_src);
	$smarty->assign('image_srcset', $image_srcset);

}
?>
