<?php
function smarty_block_code($params, $content, &$smarty, &$repeat) {
	$codes = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');
	$view_code_id = $smarty->getTemplateVars('view_code_id');
	$view_univ_id = $smarty->getTemplateVars('view_univ_id');
	$conf_univ_id = $smarty->getConfigVars('univ_id');

	$view_code_name = $smarty->getTemplateVars('view_code_name');

	// ブロックに入る前の処理

	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_code', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if ($smarty->getTemplateVars('new_code')) {

			// codeのデータを初期化する
			//						$code = $res->fetchRow();
			$code = array('id' => 0,
				'univ_id' => '',
				'name' => '',
				'number' => '',
				'value' => '',
				'flag' => 1,
			);
			array_push($codes, $code);
		}
		// カテゴリーを読み込む場合
		else {
			// カテゴリーをデータベースから読み込む
			$type = array();
			$data = array();
			$where = array();
			$sql = <<< HERE
SELECT init_code.* FROM init_code

HERE;

			if ($view_univ_id) {
				array_push($type, 'integer');
				array_push($data, $view_univ_id);
				array_push($where, "init_code.univ_id in (?) ");
			} else if ($conf_univ_id) {
				array_push($type, 'integer');
				array_push($data, $conf_univ_id);
				array_push($where, "init_code.univ_id in (?) ");
			}
			if ($params['name']) {
				array_push($type, 'text');
				array_push($data, $params['name']);
				array_push($where, "init_code.name in (?) ");
			} else if ($view_code_name) {
				array_push($type, 'text');
				array_push($data, $view_code_name);
				array_push($where, "init_code.name in (?) ");
			}
			if ($id) {
				array_push($type, 'integer');
				array_push($data, $id);
				array_push($where, "init_code.id in (?) ");
			} else if ($params['id']) {
				array_push($type, 'integer');
				array_push($data, $params['id']);
				array_push($where, "init_code.id in (?) ");
			} else if ($view_code_id) {
				array_push($type, 'integer');
				array_push($data, intval($view_code_id));
				array_push($where, "init_code.id in (?) ");
			}

			if (is_null($_SESSION["admin_mode"])) {
				array_push($where, "init_code.flag =1");
			} else if ($params["public"]) {
				array_push($where, "init_code.flag =1");
			}

			if (count($where)) {
				$sql .= " WHERE " . implode(' AND ', $where) . "\n";
			}

			$sql .= <<< HERE
ORDER BY init_code.sort_order,init_code.number ASC

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
			while ($code = $res->fetch()) {
				array_push($codes, $code);
			}
			// カテゴリーがない場合
			if (count($codes) == 0) {
				$smarty->assign('no_code', 1);
				$repeat = false;
				return;
			}
		}
		// カテゴリーをSmartyの変数に保存
		$smarty->assign('codes', $codes);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_code', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$codes = $smarty->getTemplateVars('codes');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_code');
	}
	// 個々のカテゴリーを読み込む
	$code = $codes[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する
	$smarty->assign('code', $code);
	$smarty->assign('code_header', ($ctr == 0));
	$smarty->assign('code_footer', ($ctr == count($codes) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_code', $ctr);
	$repeat = ($ctr <= count($codes));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
