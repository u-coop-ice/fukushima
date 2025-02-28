<div class="modal fade" id="gakushoku" style="text-align: left;" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span>×</span></button>
<h4 class="modal-title">掲載につきまして、下記のことにご留意ください。</h4>
</div>
<div class="modal-body">
<ul class="tri">
<li>学食.coopのページは、関東地区の大学生協と東北地区の大学生協で出食しているメニューを掲載しております。一部、東北地区のみで出食しているメニューは掲載がございませんのでご了承ください。</li>
<li>価格は地域によって異なります。<?php echo ($init_coopname); ?>での価格は、表示の価格とは若干異なります。詳しくは、店舗へお問い合わせください。</li>
<li>アレルギー成分の検索は、掲載されているメニュー内で行われます。掲載されていない各生協独自メニューなどについては表示されませんので、ご注意ください。詳細は店舗へお問い合わせください。</li>
</ul>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
<a class="btn btn-primary" id="close_modal" href="http://gakushoku.coop/" target="_blank">学食どっとコープ</a>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function(){
  $("#close_modal").on("click",function(){
  	$('#gakushoku').modal('hide');
  });
});

</script>
