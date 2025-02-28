<?php
class ua {
//	private $ua;
	//	private $device;
	public static function getUA($useragent) {
		$useragent = mb_strtolower($useragent);
		if (strpos($useragent, 'iphone') !== false) {
			$device = 'iPhone';
		} elseif (strpos($useragent, 'ipod') !== false) {
			$device = 'iPod';
		} elseif ((strpos($useragent, 'android') !== false) && (strpos($useragent, 'mobile') !== false)) {
			$device = 'Android';
		} elseif ((strpos($useragent, 'windows') !== false) && (strpos($useragent, 'phone') !== false)) {
			$device = 'Windows Phone';
		} elseif ((strpos($useragent, 'firefox') !== false) && (strpos($useragent, 'mobile') !== false)) {
			$device = 'Firefox OS mobile';
		} elseif (strpos($useragent, 'blackberry') !== false) {
			$device = 'blackberry';
		} elseif (strpos($useragent, 'ipad') !== false) {
			$device = 'iPad';
		} elseif ((strpos($useragent, 'windows') !== false) && (strpos($useragent, 'touch') !== false)) {
			$device = 'Windows Tablet';
		} elseif ((strpos($useragent, 'android') !== false) && (strpos($useragent, 'mobile') === false)) {
			$device = 'Android Tablet';
		} elseif ((strpos($useragent, 'firefox') !== false) && (strpos($useragent, 'tablet') !== false)) {
			$device = 'Firefox OS Tablet';
		} elseif ((strpos($useragent, 'kindle') !== false) || (strpos($useragent, 'silk') !== false)) {
			$device = 'Kindle';
		} elseif ((strpos($useragent, 'playbook') !== false)) {
			$device = 'playbook';
		} elseif ((strpos($useragent, 'windows') !== false)) {
			$device = 'Windows';
		} elseif ((strpos($useragent, 'os x') !== false)) {
			$device = 'Mac';
		} else {
			$device = 'others';
		}
		return $device;
	}
}