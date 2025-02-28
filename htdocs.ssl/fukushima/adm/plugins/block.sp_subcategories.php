<?php
function smarty_block_sp_subcategories($params, $content, &$smarty, &$repeat) {
	$subcategories = array();
	// データベース関連の情報を得る
	$pdo = $smarty->getTemplateVars('pdo');

	$authority = $smarty->getTemplateVars('authority');

	// ブロックに入る前の処理
	if (is_null($content)) {
		// 初期化
		$smarty->assign('no_subcategory', 0);
		$smarty->assign('db_error', 0);
		// 新規カテゴリーの場合（カテゴリー新規作成ページ用）
		if (!$params['all'] && $smarty->getTemplateVars('new_scat')) {
			// 並び順の最大値を求める
			$sql = "select max(sort_order) as ct from sp_subcategory";
			try {
				$res = &$pdo->query($sql);
			} catch (Exception $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// カテゴリーのデータを初期化する
			$data = $res->fetch();
			$subcategory = array('id' => 0,
				'name' => '',
				'description' => '',
				'sort_order' => $data['ct'] + 1);
			array_push($subcategories, $subcategory);
		}
		// カテゴリーを読み込む場合
		else {
			// カテゴリーをデータベースから読み込む

			$where = array();

			$type = array();
			$data = array();
			$where = array();

			if (CURRENT == "app") {
				$sql = <<< HERE
SELECT sc.*, count(i.id) AS entry_count
,c.denomination as category_denomination
,c.id as category_id

	FROM  sp_subcategory AS sc
	LEFT JOIN sp_item AS i ON sc.id = i.subcategory_id AND i.visible = 1
	LEFT JOIN sp_category AS c ON sc.category_id = c.id


HERE;

			} else {
				$sql = <<< HERE
SELECT sc.*, count(i.id) AS entry_count
,c.denomination as category_denomination,c.flag_send AS category_flag_send
FROM sp_subcategory AS sc
LEFT JOIN sp_item AS i ON sc.id = i.subcategory_id
LEFT JOIN sp_category AS c ON sc.category_id = c.id

HERE;

			}

			if ($params['part']) {
				array_push($data, $params['part']);
				array_push($where, "c.part = ? \n");
			} else if ($params['category']) {
				array_push($data, $params['category']);
				array_push($where, "c.id = ? \n");
			}

			if ($params['id']) {
				array_push($type, 'integer');
				array_push($data, $params['id']);
				array_push($where, "sc.id in (?)\n");
			}
			if ($params['not_id']) {
				array_push($type, 'integer');
				array_push($data, $params['not_id']);
				array_push($where, "sc.id not in (?)\n");
			}

			// 管理者モードでなければ
			// 非表示のサブカテゴリは出力しない
			if (!$_SESSION['admin_mode'] || CURRENT == "app") {
				array_push($where, "sc.visible = 1\n");
			}

			// 管理者ユーザーの権限整理
			if (CURRENT == "adm") {
				if ($_SESSION['admin_mode']) {

					if ($authority["master"]["master"] == 0) {
						if (is_array($authority["shopping"]["category_id"])) {
							$ors = array();
							foreach ($authority["shopping"]["category_id"] as $ac) {
								array_push($data, $ac);
								array_push($ors, "c.id = ?\n");
							}
							if (count($ors)) {
								$or = implode(" OR ", $ors);
								array_push($where, "( " . $or . ") \n");
							} else {
								$smarty->assign('no_category', 1);
								$repeat = false;
								return;
							}

						} else {
							$smarty->assign('no_category', 1);
							$repeat = false;
							return;
						}
					}

/*
if (count($authority['shopping']["category_id"])) {
$ats = array();
foreach ($authority['shopping']["category_id"] as $at) {
array_push($type, 'integer');
array_push($ats, "c.id = ?");
array_push($data, $at);
}
array_push($where, ' (' . implode(' OR ', $ats) . ')');
} else {
// 権限がないとき、サブカテゴリなし
$smarty->assign('no_subcategory', 1);
$repeat = false;
return;
}
 */
				}
			}
			if (count($where)) {
				$sql .= " WHERE " . implode(' AND ', $where) . " \n ";
			}
			$sql .= <<< HERE
 group by sc.id
 order by sc.sort_order

HERE;

			try {
				$res = $pdo->prepare($sql);
				$res->execute($data);

			} catch (Exception $e) {
				// データベースアクセスに失敗したらエラーとする
				$smarty->assign('db_error', 1);
				$repeat = false;
				return;
			}
			// カテゴリーを配列に読み込む
			while ($subcategory = $res->fetch()) {
				array_push($subcategories, $subcategory);
			}
			// カテゴリーがない場合
			if (count($subcategories) == 0) {
				$smarty->assign('no_subcategory', 1);
				$repeat = false;
				return;
			} else {
				$smarty->assign('no_subcategory', 0);
			}
		}
		// カテゴリーをSmartyの変数に保存
		$smarty->assign('subcategories', $subcategories);
		// カウンタを初期化
		$ctr = 0;
		$smarty->assign('sub_ctr', 0);
	}
	// 各繰り返しが終わった後の処理
	else {
		// Smartyの変数に保存した記事を読み出す
		$subcategories = $smarty->getTemplateVars('subcategories');
		// カウンタを読み出す
		$ctr = $smarty->getTemplateVars('sub_ctr');
	}

	// 個々のカテゴリーを読み込む
	$subcategory = $subcategories[$ctr];
	// カテゴリーの各フィールドをSmartyの変数に設定する

	if (strtotime($subcategory['limit_date']) > time()) {
		if (strtotime($subcategory['open_date']) > time()) {
			$subcategory['state'] = 0;
		} else {
			$subcategory['state'] = 1;
		}
	} else {
		$subcategory['state'] = 9;
	}
	if (!$subcategory['visible']) {
		$subcategory['state'] = -9;
	}

	$subcategory["description"] = htmlspecialchars_decode($subcategory["description"]);

	$smarty->assign('subcategory', $subcategory);

	$smarty->assign('subcategory_header', ($ctr == 0));
	$smarty->assign('subcategory_footer', ($ctr == count($subcategories) - 1));
	$smarty->assign('is_odd', ($ctr % 2 == 0));
	// 次のカテゴリーがあれば繰り返しを続け、なければ繰り返しから抜ける
	$ctr++;
	$smarty->assign('sub_ctr', $ctr);
	$repeat = ($ctr <= count($subcategories));
	// glueパラメータが指定されていて、かつ最後のカテゴリーでなければ、
	// 出力の後にglueパラメータの文字を追加する
	if ($repeat && $params['glue']) {
		$content .= $params['glue'];
	}
	// ブロック内の出力
	return $content;
}
?>
