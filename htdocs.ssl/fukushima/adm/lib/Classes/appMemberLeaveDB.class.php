<?php
class appMemberLeaveDB extends commonDB {

	use baseSendmail;
	use baseFunction;
	use baseApp;
	use checkEntryCategories;
	use checkApp;
	use execRegist;
	use execAppAdd;
	use execApp;
	use execLog;
	use extendAuth;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function saveAppEntry() {

		if (!isset($_POST["confirm"]) && !isset($_POST["reinput"]) && !isset($_POST["register"])) {
			throw new Exception("不正なアクセスです", 1);
		}

		$category = $this->getEntryCategory();
		$this->checkWorkigEntryCategory($category);
		HTTP_Session2::set('stock_multi', $this->get_multi_stock());

		if (isset($_POST["confirm"])) {

			if ($_POST['extra'][2]) {
				if (preg_match('/返還/', $_POST['extra'][2])) {
					$category['method']['bank']['use'] = 2;
				} else {
					$category['method']['bank']['use'] = 0;
				}

			}

			$category = $this->calcCategoryMethod($category);

			HTTP_Session2::set('method', $this->get_method_category());
			$postdata = $this->execSanitize($category['fields']['all'], $category['fields']['must']);

			HTTP_Session2::set('postdata', $postdata);
			HTTP_Session2::set('fields_sql', $this->get_fields_sql());
			HTTP_Session2::set('fields_sql_app', $this->get_fields_sql_app());

			$this->_smarty->assign('post', $postdata);
		}

// 登録内容の確認の場合
		if (isset($_POST["confirm"])) {
			throw new Exception("confirm input", 8);
		}
// 再入力の場合
		else if (isset($_POST['reinput'])) {
			throw new Exception("Reinput", 9);
		} else if (isset($_POST['register'])) {

			$postdata = HTTP_Session2::get('postdata');

// データベースにユーザー情報を登録する

			$fields_sql = HTTP_Session2::get('fields_sql');
			$fields_sql_app = HTTP_Session2::get('fields_sql_app');

			unset($fields_sql['emailcfrm']);
			unset($fields_sql['name']);
			unset($fields_sql_app['bank']);

			$fields_sql_app['component'] = 'text';
			$postdata['component'] = COMPONENT;

			$fields_sql_app['part'] = 'text';
			$postdata['part'] = PART;

			$fields_sql_app['category_id'] = 'integer';
			$postdata['category_id'] = $category['id'];

			$fields_sql_app['extra'] = 'text';
			$postdata['extra'] = json_encode($postdata['extra']);

			$fields_sql_app['methods'] = 'text';
			$postdata['methods'] = json_encode($category['method']);

			$postdata['id'] = $this->_auth->getAuthData('id');

			try {

//トランザクション開始

				$this->_pdo->query("SET innodb_lock_wait_timeout=30;");
				$this->_pdo->beginTransaction();

//在庫チェック
				$this->set_post_stock_multi($postdata['stock_multi']);
				$this->checkWorkigEntryCategory();

				$this->set_postdata($postdata);

				$this->saveRegist($fields_sql);

				if ($this->_auth->checkAuth()) {
					$postdata['regist_id'] = $this->_auth->getAuthData('id');
				} else {
					$postdata['regist_id'] = $this->get_last_insertId();
				}
				$this->set_postdata($postdata);

				$this->saveApp($fields_sql_app);
				$postdata = $this->get_postdata();
				$postdata['app_id'] = $this->get_last_insertId();

// stock_multiテーブルの更新
				$_category = $this->getEntryCategorySimple();
				$this->updateEntryStockMulti($_category);

//メール送信

//生協管理用メールアドレスを取得する。
				$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

				$init_ordermail = $_SESSION['config']['email'];
				$replymail = $_SESSION['config']['donotreply_email'];

				$infocode = $_SESSION['config']['component'][COMPONENT]['infocode'];
				$init_pagetitle = $_SESSION['config']['component'][COMPONENT]['title'];

				$cat_code = $category['cat_code'];             //カテゴリ毎のCODE取得
				$cat_denomination = $category['denomination']; //カテゴリ名

				$ordermail = $category['ordermail']; //追加メールアド
				$pressmail = $category['pressmail']; //自動返信メール記載アド

				$this->_smarty->assign('pressmail', $pressmail);

// 登録確認メールを送信する

				$regist_code = $infocode . $cat_code . ":" . date("Ymd") . "-" . sprintf("%04d", $postdata['app_count']); //受付番号の番号作成
				$this->_smarty->assign('regist_code', $regist_code);

				if ($this->_auth->checkAuth()) {
					if ($this->_auth->getAuthData('namef')) {

						$this->_smarty->assign('post_namef', $this->_auth->getAuthData('namef'));
						$this->_smarty->assign('post_nameg', $this->_auth->getAuthData('nameg'));

						$name = $this->_auth->getAuthData('namef') . ' ' . $this->_auth->getAuthData('nameg');
					} else {
						$name = $this->_auth->getUsername();
					}

					$email = $this->_auth->getAuthData('email');

				} else {
					$email = $postdata['email'];
					$name = $postdata['namef'] . ' ' . $postdata['nameg'];
				}

				$this->_smarty->assign('post_email', $email);

//メール本文作成

				reset($postdata);
				while (list($field, $value) = each($postdata)) {
					if ($field == "extra") {$postdata[$field] = json_decode($value, true);}
				}

				$this->_smarty->assign('post', $postdata);

				$html = '';
				$pp = 'conf_';

				$method = HTTP_Session2::get('method');
				foreach ($method as $key => $value) {
					$extraList = null;
					if (!preg_match('/^extra/', $key)) {
						if ($key == "bank") {
							$html .= $this->_smarty->fetch('conf_bank_blank.tpl');
						} else {
							$html .= $this->_smarty->fetch($pp . $key . '.tpl');
						}
					} else {
						$k = intval(substr($key, 5));
						$this->_smarty->assign('k', $k);

						if ($category['method']['extra'][$k]['select']) {
							$select = trim($category['method']['extra'][$k]['select']);
							$select = preg_replace('/\n|\r\n/', "\n", $select);
							$extraList = explode("\n", $select);
							$tmps = [];

							if ($k == 0) {
								foreach ($extraList as $v) {
									$tmp = explode(",", $v);
									$tmps[$tmp[0]] = $tmp[1];
								}
								$extraList = array_keys($tmps);
								$post_extra = $postdata['extra'];
								$extramail = [];
								if (is_array($post_extra[0])) {
									foreach ($post_extra[0] as $pe) {
										if ($tmps[$pe]) {
											array_push($extramail, $tmps[$pe]);
										}
									}
								} else {
									if ($tmps[$post_extra[0]]) {
										array_push($extramail, $tmps[$post_extra[0]]);
									}
								}

							}

							$this->_smarty->assign('extraList', $extraList);
						}
						$html .= $this->_smarty->fetch($pp . 'extra.tpl');
					}
				}
//			$text = $html;
				$html = preg_replace("/<\/th>/", "]", $html);
				$html = preg_replace("/<th.*>/", "[", $html);
				$this->_smarty->assign('html', $html);
				$text = strip_tags($html);
				$text = preg_replace('/(\n)+|(\r\n)+/', "\n", $text);
				$this->_smarty->assign('text', $text);

				$this->_smarty->assign('app_code', $postdata['code']);

				$cust_body = $this->_smarty->fetch('customer_mail.tpl');
				$order_body = $this->_smarty->fetch('order_mail.tpl');

				$cust_subject = $cat_denomination . 'を承りました';
//登録者へのメール送信

				$arg['component'] = COMPONENT;
				$arg['part'] = PART;
				$arg['univ_id'] = $_SESSION['config']['univ_id'];
				$arg['regist_id'] = $postdata['regist_id'];
				$arg['category_id'] = $postdata['category_id'];

//管理者メール設定
				if ($ordermail) {
					$init_ordermail = $ordermail;
				} else if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
					$init_ordermail = $_SESSION['config']['component'][COMPONENT]['store_ordermail'];
				}

				$order_subject = $regist_code . '【' . $cat_denomination . '】';

				$admarg = [];

//メール連動系の処理 Ccへ追加
				$cc = null;
				if (count($extramail)) {
					$cc = implode(",", $extramail);
					$admarg['cc'] = $cc;
				}

//app_addへの登録

				$adddata['app_id'] = $postdata['app_id'];
				$adddata['regist_id'] = $postdata['regist_id'];
				$adddata['code'] = md5($infocode . time() . COMPONENT . $email);
				$this->_smarty->assign('adic', $adddata['code']);
				$this->_smarty->assign('view_ic', $data['code']);

				$adddata['subject'] = $cust_subject;
				$adddata['memo'] = $cust_body;

				$adddata['send'] = 1;
				$adddata['noreply'] = 1;
				$adddata['auto_send'] = 1;
				$adddata['add'] = COMPONENT;

				$this->set_postdata($adddata);
				$this->saveAppAdd();

				$postdata['add_id'] = $this->get_last_insertId();

//ログのセット

				$logdata['kind'] = COMPONENT;
				$logdata['app_add_id'] = $postdata['add_id'];
				$logdata['target_id'] = $postdata['app_id'];
				$logdata['username'] = $email;
				$this->setLogdata($logdata);
				$this->insertLog();

				$this->_pdo->commit();

//登録者へのメール送信
				self::send_mail($init_coopname, $replymail, $email, $cust_subject, $cust_body, $arg);
//管理者へのメール送信
				self::send_mail($name, $replymail, $init_ordermail, $order_subject, $order_body, $admarg);

// 登録完了画面表示する
				$self .= '?mode=complete';
				header("Location: $self");
				exit();

			} catch (Exception $e) {
				$this->_pdo->rollBack();
				throw new Exception($e->getMessage(), $e->getCode());
			}

			exit();
		}
	}
}
?>
