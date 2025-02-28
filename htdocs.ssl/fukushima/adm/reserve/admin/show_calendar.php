<?php

//エントリー情報を取得

$category_id = intval($_GET['category_id']);
$smarty->assign('view_category_id', $category_id);

$ach = new adminReserveDB();
$ach->set_category_id($category_id);

$category = $ach->getEntryCategory();
$smarty->assign('category', $category);

$archive = $ach->getArchiveApp();

// アーカイブがない場合
if (count($archive['count']) == 0) {
	$smarty->assign('no_archive', 1);
}

$stks = $ach->get_calendar();
$stocks = [];
$opt_stocks = [];
// 年月を配列に読み込む
foreach ($stks as $stk) {

	if ($stk['select_time']) {
		$stk['select_time'] = json_decode($stk['select_time'], true);
		$opt_stocks[key($stk['select_time'])] = $stk['opt_stock'];
		$stocks += $stk['select_time'];
	}

}

$min_date = $ach->getAppMinDate();

if ($min_date) {
	$min_year = date(Y, strtotime($min_date));
	$min_month = date(n, strtotime($min_date));
}

$smarty->assign('stocks', $stocks);
$smarty->assign('opt_stocks', $opt_stocks);

$set_year = intval($_GET['year']);
$set_month = intval($_GET['month']);

$current_year = date('Y');
$current_month = date('m');
$current_day = date('d');

if (!$set_year && !$set_month) {

	if (strtotime($min_date) > date(time())) {
		$set_year = $min_year;
		$set_month = $min_month;
	} else {
		$set_year = $current_year;
		$set_month = $current_month;
	}
}

//次月の設定
$next_time = mktime(0, 0, 0, $set_month, 1, $set_year) + 60 * 60 * 24 * 31;
$prev_time = mktime(0, 0, 0, $set_month, 1, $set_year) - 60 * 60 * 24 * 2;

$next_year = date('Y', $next_time);
$next_month = date('m', $next_time);
$prev_year = date('Y', $prev_time);
$prev_month = date('m', $prev_time);

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
//		$calendar_list[$month][$week][$day->thisDay()] = HolidayJp\Holidays::$holidays[$target]['name'];
		$calendar_list[$month][$week][$day->thisDay()] = $archive['count'][$target];
		$calendar_list_diff[$month][$week][$day->thisDay()] = $archive['diff'][$target];

	}

}

$smarty->assign('year', $set_year);
$smarty->assign('month', $set_month);

$smarty->assign('next_year', $next_year);
$smarty->assign('next_month', $next_month);

$smarty->assign('prev_year', $prev_year);
$smarty->assign('prev_month', $prev_month);

$smarty->assign('calendar_list', $calendar_list);

$smarty->assign('calendar_list_diff', $archive['diff']);
$smarty->assign('arct', $archive['archive']);
$smarty->assign('item_list', $item_list);

$_SESSION[COMPONENT] = "?mode=show_calendar&year=${set_year}&month=${set_month}";

$smarty->display('show_calendar.tpl');
?>
