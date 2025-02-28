<?php
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/');
global $rootpath;
$rootpath = ROOT_DIR;

$domain = preg_replace("#" . ROOT_DIR . "#", '', getcwd());
//hachiman fixed
//$domain = preg_replace("#" . '/export/home' . ROOT_DIR . "#", '', getcwd());

//$domain = preg_replace("#" . '/mnt/Sites/hirosaki/htdocs.ssl/hirosaki/' . "#", '', getcwd());

$domain = explode('/', $domain);

//define('ETC_DIR', str_replace('htdocs.ssl', 'etc', ROOT_DIR));
define('ETC_DIR', str_replace('htdocs.ssl', 'etc', ROOT_DIR));
//define('ETC_DIR', '/www/etc/');

define('ADM_DIR', 'adm/');
define('APP_DIR', 'app/');
define('CMP_DIR', 'cmp/');
define('LOCAL_DIR', 'app/' . $domain[1] . '/');
define('DOMAIN', 'fukushima');
define('CURRENT', $domain[0]);
define('COMPONENT', $domain[1]);

if ($domain[2]) {
	if (!preg_match('/\.php$/', $domain[2])) {
		define('PART', $domain[2]);
	}
}
//set_include_apth

if ($domain[0] == 'app') {

	set_include_path(
		__DIR__ . PATH_SEPARATOR .
		ROOT_DIR . 'adm/' . COMPONENT . '/lib' . PATH_SEPARATOR .
		ROOT_DIR . 'lib' . PATH_SEPARATOR .
		get_include_path());

} else if ($domain[0] == 'adm') {

	set_include_path('admin' . PATH_SEPARATOR .
		ROOT_DIR . 'adm/' . COMPONENT . '/lib' . PATH_SEPARATOR .
		ROOT_DIR . 'adm/lib' . PATH_SEPARATOR .
		get_include_path());

} else {
	set_include_path(
		ROOT_DIR . '/lib' . PATH_SEPARATOR .
		ROOT_DIR . '/include' . PATH_SEPARATOR .
		__DIR__ . PATH_SEPARATOR .
		ROOT_DIR . '../../php' . PATH_SEPARATOR .
		get_include_path());
}

//pearライブラリの呼び出し
require_once 'pear/vendor/autoload.php';

//composerライブラリの呼び出し
require_once 'composer/vendor/autoload.php';

//smartyライブラリの呼び出し
require_once 'smarty/vendor/autoload.php';

//classLoaderでクラスの自動呼び出し

require_once 'classLoader.class.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(ROOT_DIR . ADM_DIR . 'lib/Classes/');
$classLoader->registerDir(ROOT_DIR . ADM_DIR . 'lib/Classes/trait/');

?>
