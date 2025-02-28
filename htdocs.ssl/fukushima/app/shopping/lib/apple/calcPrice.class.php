<?php

namespace shopping\apple;

require_once "Classes/priceBase.class.php";

class price extends \shopping\priceBase {

	private $_weights;
	const REDUCTION = 500;
//	const REDUCTION_CREDITCARD = 300;

	public function __construct() {

		parent::__construct();

		$postageList['北海道'] = 0;
		$postageList['東北'] = 0;
		$postageList['関東'] = 0;
		$postageList['中部'] = 0;
		$postageList['関西'] = 0;
		$postageList['中国'] = 0;
		$postageList['四国'] = 0;
		$postageList['九州'] = 900;
		$postageList['沖縄'] = 900;

		$this->reduceList = [3, 5];

		$this->postageList = $postageList;

	}

	public function calc_price() {
		if (!count($this->_cart->items)) {return;}

		$weights = array();
		$tmp = array();
		$price = 0;
		$reduction = 0;

		foreach ($this->_cart->items as $i => $item) {

//			if ($item['postage'] == 1) {
			array_push($weights, intval($item['num']));
//			}
			if (in_array($item['weight'], $this->reduceList)) {
				$this->_reduction += intval($item['num']);
			}

			$item['total_price'] = intval($item['price']) * intval($item['num']);
			$tmp[$i] = $item;
			$price += $item['total_price'];
		}

		$this->_reduction = intval($this->_reduction / 2) * SELF::REDUCTION;

//クレカ値引き
		//		if ($this->_postdata->payment == 4) {
		//			$this->_reduction += SELF::REDUCTION_CREDITCARD;
		//		}

		$this->_weights = $weights;

		$this->_postage = $this->calc_postage();
		$this->_cart->items = $tmp;
		$this->_price = $price;
		$this->_cart;
		return;
	}

	private function calc_postage() {

		$ship_flag = $this->_postdata->ship_flag;

		$postageList = $this->postageList;
		if ($ship_flag == 2) {
			$this->_postage = 0;
		} else {

			$this->get_area();

			if (!$this->_area) {
				$this->_error = 1;
			}

			if (count($this->_weights)) {

				$ww = array_sum($this->_weights);
				$this->_postage = $postageList[$this->_area] * $ww;
			}
		}
		return $this->_postage;
	}

}
?>
