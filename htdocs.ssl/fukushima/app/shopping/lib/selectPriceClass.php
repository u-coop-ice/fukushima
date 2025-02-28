<?php

$priceLibFile = __dir__ . "/common/calcPrice.class.php";

if (file_exists(__dir__ . PART . "/calcPrice.class.php")) {
	$priceLibFile = __dir__ . PART . "/calcPrice.class.php";
}

require_once $priceLibFile;

?>
