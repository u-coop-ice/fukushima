<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>



<link rel="stylesheet" href="<?php fp_ft('./css/calendar.css'); ?>">




<?php
include $rootpath . 'include/header2.txt';
?>




<div id="main2" class="full">

<h2>営業時間</h2>

<?php /*?>
<div class="box">
<h4 class="top">新型コロナウイルス感染対策における営業時間変更について</h4>

<p>日頃、福島大学生協をご利用いただきまして誠にありがとうございます。<br />
昨今の事情により、福島大学生協では各店舗の営業を一部自粛及び営業時間を変更しております。<br />
状況が変わり次第徐々にではありますが営業を再開する予定でございます。<br />
ご利用者の方にはご不便をおかけしますが、ご理解とご協力の程何卒よろしくお願いいたします。</p>
</div>
<?php */?>

<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setlog(array('../../../data/whatsnewdata.xml'));
$whatsnew->setCoop('fukushima');
$whatsnew->setBefore(365);
?>


<?php
$whatsnew->setKey('covid19-time');
if ($whatsnew->getList()) {
	echo '<h3>営業時間の変更等</h3>';
	echo $whatsnew->getList();
} /*else {
	echo '<p class="alert alert-info">現在表示する項目はありません。</p>';
}*/
?>



<h3>営業時間のご案内</h3>

<div class="table-responsive">
        <table cellspacing="0" class="table tblFull em09">
            <tr>
                <th colspan="2">店舗名</th>
                <th>連絡先</th>
                <th>平日</th>
                <th>土曜</th>
                <th>日曜</th>
                <th>祝日</th>
                <th style="width:25%">備考</th>
            </tr>
            <tr>
                <td rowspan="2">購買店</td>
                <td>コンビニ</td>
                <td rowspan="2">024-548-0091</td>
                <td>9:30～19:00</td>
                <td>11:00～14:00</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td></td>
            </tr>
            <tr>
                <td>カウンター</td>
                <td>10:00～17:00</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">本部・新入生サポートセンター</td>
                <td>024-548-5141</td>
                <td>10:00～17:00</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">1階食堂　Dining ReaF</td>
                <td>024-548-5142</td>
                <td>9:30～19:00</td>
                <td>11:00～14:00</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">2階食堂　Quick Lunchグリーン</td>
                <td>-</td>
                <td>11:00～14:00</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td class="">閉店</td>
                <td></td>
            </tr>
        </table>
    </div>
<ul class="tri">
        <li>変更が出た場合は随時更新いたします。</li>
        <li>日曜・祝日は全店閉店となります。</li>
        <li>大学学事により営業時間が変更になる場合があります。その場合は、各店掲示板に掲示いたします。</li>
        <?php /* <li>★はサポートセンターのみの営業になります。</li> */ ?>
    </ul>



<h3>営業時間カレンダー</h3>





<?php
include  './include/calendar.php';
?>





  
	
	
	
	
	<br><br><br>
    <p><a class="btn btn-primary" href="/store/"><i class="fa fa-fw fa-reply"></i>店舗トップに戻る</a></p>
</div>
<!-- main終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>
