<?php

class createDate {

	private $start;
	private $date;

// 各変数を取得
	public function getDate($n) {
		return $this->calcDate($n);
	}

// 各変数を設定
	public function setStart($start) {
		return $this->start = $start;
	}

	private function calcDate($num) {

		$weekday = array("日", "月", "火", "水", "木", "金", "土");

		$st = strtotime($this->start);
		$st = $st + $num * 24 * 60 * 60;
		$year = date("Y", $st);
		$month = date("n", $st);
		$day = date("j", $st);
		$wday = $weekday[date("w", $st)];
		return $month . '/' . $day . '(' . $wday . ')';
	}

}
?>