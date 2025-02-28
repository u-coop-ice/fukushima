<?php

function smarty_modifier_number_payment($string)
{


				$ss = intval($string);
				if(intval($string)){
				$string=number_format($string);
				} else {
				$string='<span class="navy tag">支払済</span>';
				}

				if ($ss<0){
				$string = '<span class="red">'.$string.'</span>';
				} else if($ss>0) {
				$string = '+'.$string;
				}

				// 結果の文字列を返す
    return $string;
}
?>
