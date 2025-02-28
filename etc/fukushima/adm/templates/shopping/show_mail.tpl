{capture assign="header_insert"}
{literal}

<script type="text/javascript" src="/js/jquery/jquery-ui-1.9.0.custom/jquery-ui-1.9.0.custom.min.js"></script>
<link type="text/css" href="/js/jquery/jquery-ui.custom/bootstrap/jquery-ui.custom.css" rel="stylesheet" media="screen,print" />

<script type="text/javascript" src="/js/jquery/fancybox/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/fancybox/jquery.fancybox.css" rel="stylesheet" media="screen,print" />

<script type="text/javascript">
//<[!CDATA[

$(function(){
{/literal}
var active = {$now_add_id};
{literal}
var index = $("#accordion h4").index($("#add"+active));

	$("#accordion").accordion({
	header: "h4",
	heightStyle: "content",
	collapsible: true,
	active: index
	});
});

//]]>
</script>

<style type="text/css">
h4.ui-state-default.send {

  background-color: #BEC9EA;
		background-repeat: no-repeat;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#E8ECFC), color-stop(25%, #E8ECFC), to(#BEC9EA));
  background-image: -webkit-linear-gradient(#E8ECFC, #E8ECFC 25%, #BEC9EA);
  background-image: -moz-linear-gradient(top, #E8ECFC, #E8ECFC 25%, #BEC9EA);
  background-image: -ms-linear-gradient(#E8ECFC, #E8ECFC 25%, #BEC9EA);
  background-image: -o-linear-gradient(#E8ECFC, #E8ECFC 25%, #BEC9EA);
  background-image: linear-gradient(#E8ECFC, #E8ECFC 25%, #BEC9EA);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#E8ECFC', endColorstr='#BEC9EA', GradientType=0);

  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);

  color: #333;
  font-size: 13px;
  line-height: normal;
  border: 1px solid #ccc;
  border-bottom-color: #bbb;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -webkit-transition: 0.1s linear background-image;
  -moz-transition: 0.1s linear background-image;
  -ms-transition: 0.1s linear background-image;
  -o-transition: 0.1s linear background-image;
  transition: 0.1s linear background-image;
			overflow: visible;

 }
</style>

{/literal}
{/capture}

{assign var="page_title" value="ユーザー宛システム送信メール"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="note deleted">メールを削除しました。</p>
{/if}

{adds}
{assign var=view_order_id value=$add_order_id}
{if $add_header}
<div id="accordion">
{/if}
<h4 id="add{$add_id}" class="{if $add_send}send{/if}"><a>{$add_subject}&nbsp;&nbsp;[{$add_date}]</a></h4>
<div>
<p class="right">お申し込み：
<a href="{$self}?mode=show_order&id={$view_order_id}">{$infocode}-{orders order_id=$add_order_id}:{$order_date|date_format:"%Y%m%d"}-{$order_count|string_format:"%04d"}{/orders}</a>
</p>
<p class="pad_l">{$add_memo|nl2br}</p>
</div><!-- div -->
{if $add_footer}
</div><!-- accordion -->
{/if}

{/adds}
{if $no_add}
<p class="ind">送信履歴が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="ind">送信履歴の読み込みに失敗しました。</p>
{/if}

<div><a href="./admin.php?mode=list_mail" class="btn"><i class="icon-chevron-left"></i> 送信履歴に戻る</a></div>
{include file='footer.tpl'}
