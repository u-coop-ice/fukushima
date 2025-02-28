<?php
/* クラスローダー */

class classLoader {

//ディレクトリ格納
	private $dirs = array();

//コンストラクタ
	public function __construct() {
		spl_autoload_register(array($this, 'loader'));
	}

//ディレクトリを登録
	public function registerDir($dir) {
		$this->dirs[] = $dir;
	}
//コールバック
	public function loader($classname) {

		foreach ($this->dirs as $dir) {
			$file = $dir . '/' . $classname . '.class.php';
			if (is_readable($file)) {
				require $file;
				return;
			}
		}
	}
}
?>