<?php

set_time_limit(0);

try {
	$pdo->beginTransaction();

	$sqls = [];

	array_push($sqls, "ALTER TABLE `admin_log` ADD `memo` TEXT AFTER `value`;");
	array_push($sqls, "ALTER TABLE `admin_log` ADD `component` VARCHAR(256) AFTER `value`;");

	array_push($sqls, "ALTER TABLE `app` ADD `test_mode` INT(1) AFTER `charged_id`;");

	array_push($sqls, "ALTER TABLE `app` ADD `api_secret_key` VARCHAR(512) AFTER `charged_id`;");

	array_push($sqls, "ALTER TABLE `app` ADD `api_key` VARCHAR(512) AFTER `charged_id`;");

	array_push($sqls, "ALTER TABLE `app` ADD `receipt_number` VARCHAR(32) AFTER `charged_id`;");

	array_push($sqls, "ALTER TABLE `app` CHANGE COLUMN `bankname` `bank_name` VARCHAR(64);");

	array_push($sqls, "ALTER TABLE `app` CHANGE COLUMN `branch` `bank_branch` VARCHAR(64);");
	array_push($sqls, "ALTER TABLE `app` ADD `bank_sort` INT(1) AFTER `bank_branch`;");

	array_push($sqls, "ALTER TABLE `app` CHANGE COLUMN `account` `bank_account` VARCHAR(11);");

	array_push($sqls, "ALTER TABLE `app` CHANGE COLUMN `holder` `bank_holder` VARCHAR(512);");
	array_push($sqls, "ALTER TABLE `app` CHANGE COLUMN `holderk` `bank_holder_kana` VARCHAR(512);");

	array_push($sqls, "ALTER TABLE `app` ADD `opt_auto_sendmail` INT(1) AFTER `sendmail_paid_completed`;");

	array_push($sqls, "ALTER TABLE `app` ADD (`price_cancelled` INT(11),`date_cancelled` VARCHAR(32),`note_cancelled` TEXT,`date_returned` VARCHAR(32),`archived` int(1),`comedate` VARCHAR(256),`cometime` VARCHAR(256));");

	array_push($sqls, "ALTER TABLE `app` ADD `part` VARCHAR(32) AFTER `component`;");

	array_push($sqls, "ALTER TABLE `app` ADD `reduction` INT(11) AFTER `postage`;");

	array_push($sqls, "ALTER TABLE `app_add` ADD `category_id` INT(11) AFTER `regist_id`;");

	array_push($sqls, "ALTER TABLE `app_sub` ADD `noshi_name` VARCHAR(128) AFTER `noshi_other`;");

	array_push($sqls, "ALTER TABLE `app_sub` CHANGE COLUMN `methods` `methods` JSON;");

	array_push($sqls, "CREATE TABLE `entry_calendar` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`component` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
`part` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
`category_id` int(11) DEFAULT NULL,
`date` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
`open` int(1) DEFAULT NULL,
`select_time` text CHARACTER SET utf8,
`special` int(11) DEFAULT NULL,
`opt_stock` int(1) DEFAULT NULL,
`status` int(1) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");

	array_push($sqls, "ALTER TABLE `entry_category` ADD `select_time` JSON AFTER `cat_code`;");

	array_push($sqls, "ALTER TABLE `entry_category` ADD `part` VARCHAR(32) AFTER `code`;");
	array_push($sqls, "ALTER TABLE `entry_category` ADD `component` VARCHAR(32) AFTER `code`;");

	array_push($sqls, "ALTER TABLE `entry_category` ADD `description_closed` TEXT AFTER `description_web`;");

	array_push($sqls, "ALTER TABLE `entry_category` CHANGE COLUMN `method` `method` JSON;");

	array_push($sqls, "ALTER TABLE `entry_category` ADD (`js` TEXT,`set_year` VARCHAR(16),`comedate_title` VARCHAR(256),`cometime_title` VARCHAR(256),`limit_time` INT(11));");

	array_push($sqls, "ALTER TABLE `mail_group` CHANGE COLUMN `name` `denomination` VARCHAR(256);");

	array_push($sqls, "ALTER TABLE `mail_group` ADD `condition` JSON AFTER `denomination`;");

	array_push($sqls, "ALTER TABLE `mail_group` ADD (`unsubscribe` INT(1),`forced` INT(1));");

	array_push($sqls, "ALTER TABLE `mail_group` DROP COLUMN `magazine`,DROP COLUMN `year`,DROP COLUMN `oncategory`,DROP COLUMN `category_id`,DROP COLUMN `component`;");

	array_push($sqls, "ALTER TABLE `mail_magazine` ADD `unsubscribe` INT(1) AFTER `group_id`;");

	array_push($sqls, "ALTER TABLE `mail_magazine` ADD `condition` JSON AFTER `group_id`;");

	array_push($sqls, "ALTER TABLE `mail_magazine` ADD `onetime` INT(1) AFTER `group_id`;");

	array_push($sqls, "ALTER TABLE `regist` ADD `tmp_date` VARCHAR(32) AFTER `tmp_update_password`;");

	array_push($sqls, "ALTER TABLE `regist` ADD `tmp_code` VARCHAR(256) AFTER `tmp_update_password`;");

	array_push($sqls, "ALTER TABLE `regist` ADD `cust_id_veritrans` VARCHAR(100) AFTER `cust_id`;");

	array_push($sqls, "ALTER TABLE `regist_sub` ADD `ssid` VARCHAR(128);");

	array_push($sqls, "ALTER TABLE `sp_category` CHANGE COLUMN `name` `denomination` VARCHAR(256);");

	array_push($sqls, "ALTER TABLE `sp_category` CHANGE COLUMN `component` `part` VARCHAR(256);");

	array_push($sqls, "ALTER TABLE `sp_category` ADD `test_mode` INT(1) AFTER `payment`;");

	array_push($sqls, "ALTER TABLE `sp_category` ADD `autosend_message` TEXT AFTER `sort_order`;");
	array_push($sqls, "ALTER TABLE `sp_category` ADD (`send_date` TEXT,`opt_bill` INT(1),`opt_ship` JSON,`low` TEXT );");

	array_push($sqls, "ALTER TABLE `sp_item` ADD `weight` INT(11) AFTER `size`;");

	array_push($sqls, "ALTER TABLE `sp_item` ADD `uuid` VARCHAR(64);");

	array_push($sqls, "ALTER TABLE `sp_sub2category` CHANGE COLUMN `name` `denomination` VARCHAR(256);");
	array_push($sqls, "ALTER TABLE `sp_subcategory` CHANGE COLUMN `name` `denomination` VARCHAR(256);");
	array_push($sqls, "ALTER TABLE `sp_subcategory` CHANGE COLUMN `parent_id` `category_id` INT(11);");

	array_push($sqls, "UPDATE `entry_category` SET `component`= 'entry';");

//ap_itemにuuidハッシュを追加

	array_push($sqls, "UPDATE `sp_item` SET `uuid`= md5(CONCAT(id,name,IFNULL(regist_date,0),IFNULL(image,0)))");

	array_push($sqls, "CREATE TABLE `regist_lab` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`regist_id` int(11) NOT NULL,
`lab_name` varchar(512) COLLATE utf8_bin DEFAULT NULL,
`lab_extension_line` varchar(256) COLLATE utf8_bin DEFAULT NULL,
`lab_faxnumber` varchar(128) COLLATE utf8_bin DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");

	array_push($sqls, "CREATE TABLE `ask_category` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`denomination` varchar(255) NOT NULL DEFAULT '',
`ordermail` varchar(256) DEFAULT NULL,
`description` text,
`sort_order` int(11) NOT NULL,
`color` varchar(128) DEFAULT NULL,
`visible` int(1) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `name` (`denomination`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

	array_push($sqls, "UPDATE `app_add` SET `category_id`= 1,`date`=`date` WHERE `add` = 'ask';");

	array_push($sqls, "UPDATE `app` SET `part`= 'fruits',`date`=`date` WHERE `component` = 'shopping';");
	array_push($sqls, "INSERT INTO `ask_category` (`denomination`,`sort_order`,`visible`) VALUES ('生協全体',1,1);");

	array_push($sqls, "CREATE TABLE `payment_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`app_id` int(11) DEFAULT NULL,
`process` varchar(256) DEFAULT NULL,
`payment` int(11) DEFAULT NULL,
`value` text,
`memo` text,
`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`auth_username` varchar(128) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;");

	foreach ($sqls as $sql) {

		try {
			$res = $pdo->query($sql);

		} catch (PDOException $e) {
			echo $e->getMessage();
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("データベースの処理に失敗しました。", 1);
		}
	}

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollback();
	// データベースアクセスに失敗したらエラーとする
	throw new Exception("データベースの処理に失敗しました。", 1);
}

exit;
?>
