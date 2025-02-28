<?php
function smarty_block_addresses($params, $content, &$smarty, &$repeat) {
	$addresses = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	$view_address_id = $smarty->getTemplateVars('view_address_id');

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_address', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if ($smarty->getTemplateVars('new_address') && !$params['all']) {
			// 並び順の最大値を求める
			$sql = "SELECT MAX(sort_order) AS ct FROM app_ship";

			try {
				$res = &$pdo->query($sql);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// カテゴリーのデータを初期化する
			$data = $res->fetch();
			$address = array('id' => 0,
				'sort_order' => $data['ct'] + 1);
			array_push($addresses, $address);
		}
		// カテゴリーを読み込む場合
		else {

			// カテゴリーをデータベースから読み込む
			$data = array();
			$where = array();
			$or = array();
			$sql = <<< HERE
SELECT * FROM app_ship

HERE;

			if (!$params['all']) {

				if ($params['id']) {
					array_push($data, $params['id']);
					array_push($where, "id in (?)\n");
				} elseif ($view_address_id) {
					array_push($data, $view_address_id);
					array_push($where, "id in (?)\n");
				}

				if ($params['regist_id']) {
					array_push($data, $params['regist_id']);
					array_push($where, "regist_id in (?)\n");
				}

				if (CURRENT == 'app') {
					if (!$params['regist_id']) {
						$smarty->assign('db_error', 1);
						$repeat = false;
						return;
					}
					array_push($where, "IFNULL(invisible,0) = 0  \n");
				}

				if (count($where)) {
					$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
				}

			}

			$sql .= <<< HERE
ORDER BY sort_order

HERE;

			try {
				$res = $pdo->prepare($sql);
				$res->execute($data);
			} catch (PDOException $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// カテゴリーを配列に読み込む
			while ($address = $res->fetch()) {
				array_push($addresses, $address);
			}
			// カテゴリーがない場合
			if (count($addresses) == 0) {
				$smarty->assign('no_address', 1);
				$repeat = false;
				return;
			} else {
				$smarty->assign('no_address', 0);
			}
		}
		// カテゴリーをSmartyの変数に保存
		$smarty->assign('addresses', $addresses);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_address', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$addresses = $smarty->getTemplateVars('addresses');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_address');
	}

	// 個々のカテゴリーを読み込む
	$address = $addresses[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する

	if ($address['ship_phonenumber']) {
		$tmp = explode("-", $address['ship_phonenumber']);
		$address['ship_phonenumber1'] = $tmp[0];
		$address['ship_phonenumber2'] = $tmp[1];
		$address['ship_phonenumber3'] = $tmp[2];
	}

	$smarty->assign('address', $address);

	$smarty->assign('address_header', ($ctr == 0));
	$smarty->assign('address_footer', ($ctr == count($addresses) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));

	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_address', $ctr);
	$repeat = ($ctr <= count($addresses));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}

	// ブロック内の出力
	return $content;
}
?>
