<?php

$it = new adminReserveDB();

//開設日情報を取得

$set_year = intval($_GET['year']);
$set_month = intval($_GET['month']);
$category_id = intval($_GET['category_id']);

$smarty->assign('view_category_id', $category_id);

$current_year = date('Y');
$current_month = date('m');
$current_day = date('d');

if (!$set_year && !$set_month) {
	$set_year = $current_year;
	$set_month = $current_month;
}

//次月の設定
$next_time = mktime(0, 0, 0, $set_month, 1, $set_year) + 60 * 60 * 24 * 31;
$prev_time = mktime(0, 0, 0, $set_month, 1, $set_year) - 60 * 60 * 24 * 2;

$next_year = date('Y', $next_time);
$next_month = date('m', $next_time);
$prev_year = date('Y', $prev_time);
$prev_month = date('m', $prev_time);

$sds = [];

$it->set_year($set_year);
$it->set_month($set_year);
$it->set_category_id($category_id);

$category = $it->getEntryCategory();

$sds = $it->get_calendar();

if (count($sds)) {

	foreach ($sds as $k => $sd) {
		$mm = substr($sd['date'], 5, 2);
		$mm = intval($mm);
		$dd = substr($sd['date'], 8, 2);
		$dd = intval($dd);
		$yy = intval(substr($sd['date'], 0, 4));
		if ($sd['select_time']) {
			$sd['select_time'] = $sd['select_time'];
			$tp = json_decode($sd['select_time'], true);
			if (is_array($tp[$sd['date']])) {
				$tmp = null;
				foreach ($tp[$sd['date']] as $k => $v) {
					if (in_array('stock', array_keys($v))) {
						$tmp .= $k . ',' . $v['stock'] . "\n";
					}
				}
				$sd['select_time'] = $tmp;
			}
		} else {
			$sd['select_time'] = "";
		}
		$schedule[$yy][$mm][$dd] = $sd;
	}
}

$smarty->assign('schedule', $schedule);

use HolidayJp\HolidayJp;

$month = intval($set_month);
$year = $set_year;
$calendar = new Calendar_Month_Weekdays($year, $month, 0);
$calendar->build();

$week = 0;

while ($day = $calendar->fetch()) {

	if ($day->isFirst()) {
		$week++;
	}
	if ($day->isEmpty()) {
		$calendar_list[$month][$week][$day->thisDay()] = 'brunk';
	} else {
		$target = $day->thisYear() . "-" . sprintf('%02d', $day->thisMonth()) . "-" . sprintf('%02d', $day->thisDay());
		$calendar_list[$month][$week][$day->thisDay()] = HolidayJp\Holidays::$holidays[$target]['name'];
	}

}

$smarty->assign('year', $set_year);
$smarty->assign('month', $set_month);

$smarty->assign('next_year', $next_year);
$smarty->assign('next_month', $next_month);

$smarty->assign('prev_year', $prev_year);
$smarty->assign('prev_month', $prev_month);

$smarty->assign('calendar_list', $calendar_list);

$smarty->assign('category', $category);

$smarty->display('edit_calendar.tpl');
?>
