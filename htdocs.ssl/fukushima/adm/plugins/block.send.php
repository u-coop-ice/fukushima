<?php
function smarty_block_send($params, $content, &$smarty, &$repeat) {
	$sends = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	if ($smarty->getTemplateVars('view_archived')) {
		$view_archived = intval($smarty->getTemplateVars('view_archived'));
	}

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_group', 0);
		$smarty->assign('db_error', 0);
		// カテゴリーをデータベースから読み込む
		$type = array();
		$data = array();
		$where = array();
		$sql = <<< HERE
SELECT mg.*, count(mm.id) as magazine_count
FROM mail_group AS mg
LEFT JOIN mail_magazine AS mm
ON mg.id = mm.group_id

HERE;

		if ($params['id']) {
			array_push($type, 'integer');
			array_push($data, $params['id']);
			array_push($where, "mg.id in (?)\n");
		} else if ($params['not_id']) {
			array_push($type, 'integer');
			array_push($data, $params['not_id']);
			array_push($where, "mg.id not in (?)\n");
		}
		if ($params['sent']) {
			array_push($where, "mm.sent = 1 \n");
		} else if ($params['reserve']) {
			array_push($where, "mm.onreserve = 1 \n");
		} else if ($params['draft']) {
			array_push($where, "mm.draft = 1 \n");
		}

		if (!$params['id']) {
			if (!$view_archived) {
				array_push($data, 0);
				array_push($where, "IFNULL(mg.archived,0) = ?");
			}

		}

		if (count($where)) {
			$sql .= "WHERE " . implode("\nAND ", $where) . "\n";
		}
		$sql .= <<< HERE
GROUP BY mg.id
ORDER BY mg.sort_order

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
		while ($send = $res->fetch()) {
			array_push($sends, $send);
		}
		// カテゴリーがない場合
		if (count($sends) == 0) {
			$smarty->assign('no_send', 1);
			$repeat = false;
			return;
		} else {
			$smarty->assign('no_send', 0);
		}
		// カテゴリーをSmartyの変数に保存
		$smarty->assign('sends', $sends);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_send', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$sends = $smarty->getTemplateVars('sends');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_send');
	}

	// 個々のカテゴリーを読み込む
	$send = $sends[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する
	$smarty->assign('send', $send);
//    $smarty->assign('group_no_class', ($group['id'] == 1));
	$smarty->assign('send_header', ($ctr == 0));
	$smarty->assign('send_footer', ($ctr == count($sends) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_send', $ctr);
	$repeat = ($ctr <= count($sends));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}

	// ブロック内の出力
	return $content;
}
?>
