<?php

class setBanners {

	private $_num = 0;
	private $_start;
	private $_open;
	private $_limit;
	private $_list;

	private $_logs = ["/var/www/data/bannerdata.xml"];

	private $_size = 210;

	private $_sizeList = [
		'tohoku' => '250',
	];

// 各変数を取得
	public function getBannerList() {
//	return $this->list = $this->whatsnewdata();
		return $this->sortBannerList();
	}

// 各変数を設定
	public function setCoop($_coop) {
		return $this->_coop = $_coop;
	}

	public function addLog($_log) {
		array_push($this->_logs, $log);
	}

	private function transformBannerXML() {

		foreach ($this->_logs as $log) {

			$xml = simplexml_load_file($log, 'SimpleXMLElement', LIBXML_NOCDATA);

			$cp = [];

			$cp = explode(",", $this->_coop);

			array_push($cp, 'ALL');

			$cp = array_unique($cp);

			$no_cp = [];

			foreach ($cp as $c) {
				if (preg_match("/^[!]/", $c)) {
					$no_cp[] = preg_replace("/(\!)/", "", $cp);
				}
			}

			$items = $xml;
			$html = "";

			$bannerList = [];

			foreach ($items as $item) {
				$html = "";

				$item_coop = $item->coop;

// グループの変換
				$item_coop = str_replace("MIYAGI_AREA", "tohoku,tohoku-g,tohtech,miyagi,miyakyo,miyagi-g,shokei,icmiyagi,ichome,shirayuri,sendai-ct,miyagi-ct,thkseibun,tohoku-ba,seiwa", $item_coop);

				$item_coop = str_replace("IC_MIYAGI", "icmiyagi,ichome,shirayuri,sendai-ct,miyagi-ct,thkseibun,seiwa", $item_coop);

				$item_coop = str_replace("MEAL", "hirosaki,akita,iwate,morioka,yamagata,miyakyo,fukushima,shirayuri,ipu,tohoku", $item_coop);

				$coops = explode(",", $item_coop);
				$coops = array_unique($coops);

				if (in_array('tohoku', $coops)) {
					//東北大独自変換
					$item_key = str_replace('store', 'katahira,kawauchi,bunkei,kogakubu,riyaku,seiryo,amamiya', $item_key);
				}

				$no_coops = [];

				foreach ($coops as $cs) {
					if (preg_match("/^[!]/", $cs)) {
						$no_coops[] = preg_replace("/(\!)/", "", $cs);
					}
				}

				if (count(array_intersect($no_cp, $coops)) || count(array_intersect($cp, $no_coops))) {continue;} // !$coopsで表示しない

				if ($item->start) {
					if (time() < strtotime($item->start)) {continue;}
				} else if ($item->open) {
					if (time() < strtotime($item->open)) {continue;}
				}

				if ($item->limit) {
					// 掲載期限の評価
					if (time() > strtotime($item->limit)) {continue;}
				}

				if (isset($item->subaru) && $item->subaru == 1) {
					$item = self::calcSubaru($item);
				}

				if (count(array_intersect($cp, $coops))) {
					// coopの評価

					$html .= '<dt><a ';

					if (isset($item->link['href'])) {
						if (preg_match('/^http/', $item->link['href'])) {
							$html .= 'href="' . $item->link['href'] . '"';
						} else {
							$html .= 'href="' . $item->link['href'] . '"';

						}
					}

					if (isset($item->link['rel'])) {
						$html .= ' rel="' . $item->link['rel'] . '"';
					}

					if (isset($item->link['target'])) {
						$html .= ' target="' . $item->link['target'] . '"';
					}

					if (isset($item->title)) {
						$html .= ' title="' . $item->title . '"';
					}

					$html .= '>';

					$html .= '<img src="' . $this->transSrc($item->img['src']) . '"';

					if (isset($item->img['class'])) {
						$html .= ' class="' . $item->img['class'] . '"';
					} else {
						$html .= ' class="img hover img-responsive"';
					}

					$html .= ' /></a></dt>';

					if (intval($item->priority)) {
						$bannerList[$html] = intval($item->priority);
					} else {
						$bannerList[$html] = 0;
					}
				}
			}

		} //foreach
		return $bannerList;
	}

	private function transSrc($_src) {
		if (isset($this->_sizeList[$this->_coop])) {
			$this->_size = $this->_sizeList[$this->_coop];
		}

		$src = preg_replace('/{size}/i', $this->_size, $_src);
		return $src;
	}

	private function calcSubaru($_item) {
		global $rootpath;
		$current_year = date('y', time());
		$current_month = date('m', time());

		$_item->link['href'] = "/home/trustee/subaru/index.php";
		$file_banner = '/home/trustee/subaru/banners/bnr_top_subaru' . $current_year . $current_month . '.jpg';
		if (file_exists($rootpath . $file_banner)) {
			$_item->img['src'] = $file_banner;
			$_item->link['href'] = "/home/trustee/subaru/index.php";
			$_item->title = 'すばる';
			return $_item;
		}
	}

	private function sortBannerList() {

		$bannerList = $this->transformBannerXML();

		arsort($bannerList); //priority順にソート

		$html = '';

		if (count($bannerList)) {
			$html = implode("\n", array_keys($bannerList));
		}

		return $html;
	}

}
?>