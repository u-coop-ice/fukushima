<?php

namespace shopping;

abstract class priceBase {

	protected $_pref;
	protected $_area;
	protected $_postdata;
	protected $_cart;
	protected $_postage;
	protected $_price;
	protected $_error;
	protected $areaList;
	protected $_reduction = 0;

	public function __construct() {
		$areaList["北海道"] = "北海道";
		$areaList["青森県"] = "東北";
		$areaList["秋田県"] = "東北";
		$areaList["山形県"] = "東北";
		$areaList["宮城県"] = "東北";
		$areaList["福島県"] = "東北";
		$areaList["岩手県"] = "東北";

		$areaList["栃木県"] = "関東";
		$areaList["群馬県"] = "関東";
		$areaList["茨城県"] = "関東";
		$areaList["埼玉県"] = "関東";
		$areaList["東京都"] = "関東";
		$areaList["神奈川県"] = "関東";
		$areaList["千葉県"] = "関東";

		$areaList["山梨県"] = "中部";
		$areaList["新潟県"] = "中部";
		$areaList["石川県"] = "中部";
		$areaList["富山県"] = "中部";
		$areaList["福井県"] = "中部";
		$areaList["静岡県"] = "中部";
		$areaList["愛知県"] = "中部";
		$areaList["長野県"] = "中部";
		$areaList["岐阜県"] = "中部";

		$areaList["大阪府"] = "関西";
		$areaList["兵庫県"] = "関西";
		$areaList["京都府"] = "関西";
		$areaList["滋賀県"] = "関西";
		$areaList["奈良県"] = "関西";
		$areaList["和歌山県"] = "関西";
		$areaList["三重県"] = "関西";

		$areaList["岡山県"] = "中国";
		$areaList["広島県"] = "中国";
		$areaList["鳥取県"] = "中国";
		$areaList["島根県"] = "中国";
		$areaList["山口県"] = "中国";

		$areaList["香川県"] = "四国";
		$areaList["徳島県"] = "四国";
		$areaList["高知県"] = "四国";
		$areaList["愛媛県"] = "四国";

		$areaList["福岡県"] = "九州";
		$areaList["佐賀県"] = "九州";
		$areaList["長崎県"] = "九州";
		$areaList["大分県"] = "九州";
		$areaList["宮崎県"] = "九州";
		$areaList["熊本県"] = "九州";
		$areaList["鹿児島県"] = "九州";
		$areaList["沖縄県"] = "沖縄";

		$this->areaList = $areaList;
	}

	public function set_postdata($_postdata) {
		return $this->_postdata = (object) $_postdata;
	}

	public function set_cart($_cart) {
		return $this->_cart = (object) $_cart;
	}
	public function get_cart() {
		return (array) $this->_cart;
	}
	public function get_postage() {
		return $this->_postage;
	}
	public function get_price() {
		return $this->_price;
	}
	public function get_error() {
		return $this->_error;
	}
	public function get_reduction() {
		return $this->_reduction;
	}

	public function get_pref() {
		if ($this->_postdata->ship_flag == 1) {
			if ($this->_postdata->postage_pref) {
				$this->_pref = $this->_postdata->postage_pref;
			} else {
				$this->_pref = $this->_postdata->ship_pref;
			}
		} else {
			if ($this->_postdata->postage_pref) {
				$this->_pref = $this->_postdata->postage_pref;
			} else {
				$this->_pref = $this->_postdata->pref;
			}
		}
		return;
	}

	public function get_area() {
		$this->get_pref();
		$areaList = $this->areaList;
		$this->_area = $areaList[$this->_pref];
		return;
	}

}

?>