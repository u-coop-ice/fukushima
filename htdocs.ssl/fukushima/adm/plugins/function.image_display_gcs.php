<?php
function smarty_function_image_display_gcs($params, &$smarty) {

	// 枠のサイズを得る
	$calc_width = $params['calc_width'];

	// 画像のファイルパスを取得
	if ($params['file_image']) {
		$image_name = $params['file_image'];
	} else {
		$image_name = "no_image.jpg";
	}

	if ($params['image_dir']) {
		$image_dir = $params['image_dir'];
	}

	if ($calc_width) {
		$image_name = $calc_width . '_' . $image_name;
	}

	$image_dir = preg_replace("/^\//", "", $image_dir);

	if ($params['bucket'] == "living") {
		$up = new setUploadGcs4Living();
		$bucket_path = setUploadGcs4Living::GOOGLE_GCS_URL . setUploadGcs4living::BUCKET_NAME;
	} else {
		$up = new setUploadGcs();
		$bucket_path = setUploadGcs::GOOGLE_GCS_URL . setUploadGcs::BUCKET_NAME;
	}

	$up->set_filename($image_dir . $image_name);

//	if ($up->existFile()) {

	$image_src = $bucket_path . "/" . $image_dir . $image_name;
/*
} else {
$no_image = $image . $calc_width . '_' . "no_image.jpg";

$image_src = $bucket_path . "/c/images/" . $no_image;
}
 */
	$smarty->assign('image_src', $image_src);

}
?>
