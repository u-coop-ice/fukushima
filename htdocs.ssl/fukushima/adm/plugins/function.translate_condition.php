<?php

function smarty_function_translate_condition($params, &$smarty) {

	$translate = [];

	if (is_array($params['condition'])) {

		if ($params['condition']['component']) {
			$translate['component'] = $_SESSION['config']['component'][$params['condition']['component']]['title'];

			$instance = 'admin' . ucfirst($params['condition']['component']) . 'DB';
			$t = new $instance;

			if ($params['condition']['category_id']) {
				switch ($params['condition']['component']) {
				case 'entry':
				case 'reserve':
					$t->set_category_id($params['condition']['category_id']);
					$t->set_component($params['condition']['component']);
					$categoryinfo = $t->getEntryCategory();
					$translate['category_denomination'] = $categoryinfo['denomination'];
					break;
				case 'shopping':
					$t->set_shopping_category_id($params['condition']['category_id']);
					$categoryinfo = $t->getShoppingCategory();
					$translate['category_denomination'] = $categoryinfo['denomination'];
					break;
				}

			}
		}

		if (isset($params['condition']['forced'])) {
			if ($params['condition']['forced'] == 1) {
				$translate['forced'] = '無視する';
			} else {
				$translate['forced'] = '従う';
			}
		}

	}

	$smarty->assign('translate_condition', $translate);

}
?>
