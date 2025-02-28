<?php
function smarty_block_groups($params, $content, &$smarty, &$repeat) {
	$groups = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	$view_group_id = $smarty->getTemplateVars('view_group_id');

	if ($smarty->getTemplateVars('view_archived')) {
		$view_archived = intval($smarty->getTemplateVars('view_archived'));
	}

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_group', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if ($smarty->getTemplateVars('new_group') && !$params['all']) {
			// 並び順の最大値を求める
			$sql = "SELECT MAX(sort_order) AS ct FROM mail_group";

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
			$group = array('id' => 0,
				'name' => '',
				'memo' => '',
				'sort_order' => $data['ct'] + 1);
			array_push($groups, $group);
		}
		// カテゴリーを読み込む場合
		else {
			// カテゴリーをデータベースから読み込む
			$type = array();
			$data = array();
			$where = array();
			$or = array();
			$sql = <<< HERE
SELECT mg.* FROM mail_group AS mg

HERE;

			if (!$params['all']) {
				if ($params['id']) {
					array_push($type, 'integer');
					array_push($data, $params['id']);
					array_push($where, "mg.id in (?)\n");
				} elseif ($view_group_id) {
					array_push($type, 'integer');
					array_push($data, $view_group_id);
					array_push($where, "mg.id in (?)\n");
				}

			}

			if (!$view_group_id) {
				if (!$view_archived) {
					array_push($data, 0);
					array_push($where, "IFNULL(mg.archived,0) = ?");
				}
			}

			if (count($where)) {
				$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
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
			while ($group = $res->fetch()) {
				array_push($groups, $group);
			}
			// カテゴリーがない場合
			if (count($groups) == 0) {
				$smarty->assign('no_group', 1);
				$repeat = false;
				return;
			} else {
				$smarty->assign('no_group', 0);
			}
		}
		// カテゴリーをSmartyの変数に保存
		$smarty->assign('groups', $groups);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('ctr_mg', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$groups = $smarty->getTemplateVars('groups');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('ctr_mg');
	}

	// 個々のカテゴリーを読み込む
	$group = $groups[$ctr];

	if ($group['condition']) {
		$group['condition'] = json_decode($group['condition'], true);
		$smarty->assign('condition', $group['condition']);
	}

	// カテゴリーの各フィールドをSmartyの変数に設定する
	$smarty->assign('group', $group);

	$smarty->assign('group_header', ($ctr == 0));
	$smarty->assign('group_footer', ($ctr == count($groups) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));

	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('ctr_mg', $ctr);
	$repeat = ($ctr <= count($groups));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}

	// ブロック内の出力
	return $content;
}
?>
