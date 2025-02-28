<?php
//アクセス端末に対応したXHTMLのDOCTYPEを出力する
function mobile_xhtml_doctype() {
// 出力するDOCTYPE
	// 共通DOCTYPEをまず設定
	$doctype = '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">';

// Net_UserAgent_Mobileをインスタンス化する
	$agent = Net_UserAgent_Mobile::singleton();

// キャリアをチェックする
	if ($agent->isDoCoMo()) {
		// DoCoMo
		// ブラウザタイプ
		$type = $agent->getHTMLVersion();
		// FOMAかどうかチェックする
		if ($agent->isFOMA()) {
			if (strcmp($type, "4.0") == 0) {
				// DoCoMo (iモードXHTML1.0)
				$doctype = '<!DOCTYPE html PUBLIC "-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/1.0) 1.0//EN" "i-xhtml_4ja_10.dtd">';
			} else if (strcmp($type, "5.0") == 0) {
				// DoCoMo (iモードXHTML1.1)
				$doctype = '<!DOCTYPE html PUBLIC "-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/1.1) 1.0//EN" "i-xhtml_4ja_10.dtd">';
			} else if (strcmp($type, "6.0") == 0) {
				// DoCoMo (iモードXHTML2.0)
				$doctype = '<!DOCTYPE html PUBLIC "-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/2.0) 1.0//EN" "i-xhtml_4ja_10.dtd">';
			} else if (strcmp($type, "7.0") == 0) {
				// DoCoMo (iモードXHTML2.1)
				$doctype = '<!DOCTYPE html PUBLIC "-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/2.1) 1.0//EN" "i-xhtml_4ja_10.dtd">';
			} else if (strcmp($type, "7.1") == 0) {
				// DoCoMo (iモードXHTML2.2)
				$doctype = '<!DOCTYPE html PUBLIC "-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/2.2) 1.0//EN" "i-xhtml_4ja_10.dtd">';
			} else if (strcmp($type, "7.2") == 0) {
				// DoCoMo (iモードXHTML2.3)
				$doctype = '<!DOCTYPE html PUBLIC "-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/2.3) 1.0//EN" "i-xhtml_4ja_10.dtd">';
			}
		}
	} else if ($agent->isEZweb()) {
		// au
		// WAP2.0の場合
		if ($agent->isWAP2()) {
			$doctype = '<!DOCTYPE html PUBLIC "-//OPENWAVE//DTD XHTML 1.0//EN" "http://www.openwave.com/DTD/xhtml-basic.dtd">';
		}
	} else if ($agent->isSoftBank()) {
		// SoftBank
		// W型か3GC型の場合
		if ($agent->isTypeW() || $agent->isType3GC()) {
			$doctype = '<!DOCTYPE html PUBLIC "-//JPHONE//DTD XHTML Basic 1.0 plus//EN" "xhtml-basic10-plus.dtd">';
		}
	}
	return $doctype;
}
?>
