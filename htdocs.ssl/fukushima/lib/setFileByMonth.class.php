<?php

class setFileByMonth {

	private $_files = [];
	private $_path;
	private $_dir;
	private $_no_tab;

	public function setAbsolutePath($_path) {
		return $this->_path = $_path;
	}

	public function set_no_tab() {
		return $this->_no_tab = 1;
	}

// 各変数を取得
	private function getFileName($y, $m) {
		$filename = sprintf("%02d", $y) . sprintf("%02d", $m) . '.php';
		return $filename;
	}

	private function getFiles() {
		$dir = scandir($this->_path);

		$dir = array_filter($dir, function ($var) {
			return (preg_match("/^20\d{2}(0[1-9]|1[012])\.php$/", $var));
		});

		sort($dir);
		$this->_dir = $dir;
	}

	private function selectFiles() {

		$this->getFiles();

		$yy = array();
		$mm = array();
		//現在の年月を求める
		$y1 = intval(date('Y'));
		$m1 = intval(date('m'));
		$current = $y1 * 100 + $m1;
		foreach ($this->_dir as $f) {
			$fs = intval(basename($f, ".php"));
			if ($fs >= $current) {
				$files[$fs] = $f;
			}

		}
		$this->_files = $files;
	}

// 各変数を設定
	private function loadFile($h) {
		$files = $this->_files;
		$buffer = '<div class="tab-content">';
		$tab = '<ul class="nav nav-tabs">';
		$n = 0;
		if (count($files)) {
			foreach ($files as $key => $filename) {
				$absolute_filepath = $this->_path . '/' . $filename;
				if (file_exists($absolute_filepath)) {
					$m = substr($key, 4, 2);
					$tab .= '<li><a href="#' . $key . '" data-toggle="tab"';
					$buffer .= '<div class="tab-pane';

					if (!$this->_no_tab) {
						if ($key == date('Ym')) {
							$tab .= ' class="active"';
							$buffer .= ' active';
						}
					} else {
						$buffer .= ' active';
					}
					$tab .= '>' . intval($m) . '月</a></li>';
					$buffer .= '" id="' . $key . '">';

					/*$buffer .= '<' . $h . ' >' . intval($m) . '月</' . $h . '>';*/
					$buffer .= file_get_contents($absolute_filepath);
					$buffer .= '</div>';
				}
			}

			$tab .= '</ul>';
			$buffer .= '</div>';
			if (!$this->_no_tab) {
				echo $tab;
			}
			echo $buffer;
		} else {
			echo '<p class="alert alert-info">表示するデータがありません。</p>';
		}
		return;
	}

	public function includeFile($h = "h3") {
		$this->selectFiles();
		$this->loadFile($h);

	}

}
?>