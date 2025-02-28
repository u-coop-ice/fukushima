<?php

namespace shopping\common;

require_once "Classes/priceBase.class.php";

class price extends \shopping\priceBase {

	public function __construct() {
		parent::__construct();
	}

	public function calc_price() {
		if (!count($this->_cart->items)) {return;}

		$tmp = array();
		$price = 0;
		foreach ($this->_cart->items as $i => $item) {

			$item['total_price'] = intval($item['price']) * intval($item['num']);
			$tmp[$i] = $item;
			$price += $item['total_price'];
		}
		$this->_cart->items = $tmp;
		$this->_price = $price;
		$this->_cart;
		return;
	}
}
?>
