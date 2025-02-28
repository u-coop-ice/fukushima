<?php
if (!function_exists('include_file')):
	function include_file($fn) {
		// ファイル名とキャリア
		global $career, $career2, $breadcrumb, $focus, $is_login, $auth_username, $charset, $doctype, $GA, $title_text, $wp_text, $self;
		global $emoji_array, $app_add;
		$ext = substr($fn, strrpos($fn, '.') + 1);
		$filename = str_replace('.' . $ext, '', $fn);

		$nwfn = NULL;
		if ($career == "pc") {$nwfn = $fn;} else if ($career == "sp") {$nwfn = $filename . '_s.' . $ext;} else if ($career == "mobile") {$nwfn = $filename . '_m.' . $ext;} else { $nwfn = $fn;}
	if (file_exists($nwfn)) {include $nwfn;}
}
endif;

if (!function_exists('autoLink')):
	function autoLink($url, $txt, $cls = "link") {
		// キャリア判定でリンクを作成
		global $career;

		if ($career == "mobile") {echo $txt . $url . '<img src="/common/images/icon/only_pc.jpg" />';} else {echo '<a href="' . $url . '" class="' . $cls . '" rel="external">' . $txt . '</a>';}
	}
endif;
?>



<?php
//ブラウザのキャッシュを無効化
header('Etag:' . time());
?>

<?php
//ブラウザのキャッシュをさせない
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<?php
//クエリ文字列自動生成(substr使用)、ft(ファイルの更新時間でクエリ文字列追加:filemtime)
//例) ft('ファイルのパス');
function ft($file) {
if(substr($file, 0, 1) === "/"){
$dirfile = $_SERVER['DOCUMENT_ROOT'].$file;
} else {
$dirfile = $file;
}
echo '?' . date('YmdHis', filemtime($dirfile));
//echo $dirfile;
}
?>

<?php
//クエリ文字列自動生成(substr使用)、fp_ft(ファイルのパスとファイルの更新時間でクエリ文字列追加:file path and filemtime)
//例) fp_ft('ファイルのパス');
function fp_ft($file) {
if(substr($file, 0, 1) === "/"){
$dirfile = $_SERVER['DOCUMENT_ROOT'].$file;
} else {
$dirfile = $file;
}
echo $file . '?' . date('YmdHis', filemtime($dirfile));
//echo $dirfile;
}
?>
