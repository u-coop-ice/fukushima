{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />

<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.position.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.dialog.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.button.min.js"></script>


<script type="text/javascript">
//<[!CDATA[

	$(function() {
		$(".special").on("click",function(){
		var ck = $(this).attr('id').slice(4);
		var cd = $("#p"+ck+" > span").hasClass("none");
		var sp = $("#checked_special"+ck).hasClass("none");
		var os = $("#opt_stock_tag"+ck).hasClass("none");
		var st = $("#st"+ck).text();
		var ct = $("#category_id"+ck).text();
		var op ={ck,cd,sp,os,st};
		spDay(op);
		})
	});


function spDay(o){
	var c = o["ck"];
	$('#dialog [name="open"]').prop("checked",!o["cd"]);
	$('#dialog [name="special"]').prop("checked",!o["sp"]);
	$('#dialog [name="opt_stock"]').prop("checked",!o["os"]);
	$('#dialog [name="select_time"]').val(o["st"]);

	var pos = ["left top","left+90 top","#p"+c];
		$('#dialog').dialog({
		position: {my: pos[0],at: pos[1],of: pos[2]},
		height: "auto",
		width: 280,
		buttons: {
			'保存': function(){
				var form = $(this).find("form").serializeArray();
				form[4]={name:"date",value:c};
				form[5]={name:"category_id",value:{/literal}{$view_category_id}{literal}};
				$.ajax({
				type: "post",
				url: "./?mode=save_select_time",
				data: form,
				dataType: "json"}).done(function(r){
					$('#st'+c).text(r.select_time);
					if (r.special==0){
//					$('#opt_special'+c).prop("checked",false);
					$('#checked_special'+c).addClass('none');
					} else {
					$('#checked_special'+c).removeClass('none');
					}

					if (r.open==0){
//					$('#opt_date'+c).prop("checked",false);
					$("#p"+c+" > span").addClass('none');
					} else {
					$("#p"+c+" > span").removeClass('none');
					}

					if (r.opt_stock==0){
//					$('#opt_stock'+c).prop("checked",false);
					$('#opt_stock_tag'+c).addClass('none');
					} else {
					$('#opt_stock_tag'+c).removeClass('none');
					}


					}).fail(function(r){
						console.log(r);
					});
			$(this).dialog('close');
				}
			},
		close: function(){
					}

		});
		return false;
}


	//]]>
</script>


<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
$(function(){
$("#preview").fancybox({
type:'iframe',
	padding: 15,
	width: 700,
	height: $('body').innerHeight()*0.9,
	centerOnScroll: true,
	overlayOpacity: 1
	});
});
</script>

<style>
pre {
	background-color: #FFFFFF;
	border: none;
}
</style>

{/literal}
{/capture}

{capture assign="page_title"}
{$category['denomination']} 開設日の設定
{/capture}

{include file='header.tpl'}

{*<div class="preview" style="float:right;"><a class="btn btn-primary" id="preview" href="{$self}?mode=preview_sc&cid={$view_cat_id}">1ページ目のプレビュー</a></div>*}


<h4 class="top">{$page_title}
{if $view_category_id}<div class="pull-right">
<a id="preview" class="btn btn-primary btn-sm" href="/adm/ajax/?mode=preview_form&component={$smarty.const.COMPONENT}&category_id={$view_category_id}"><i class="fa fa-comment-alt"></i> プレビュー</a>
</div>{/if}
</h4>

<div class="clear"></div>

{if $saved}
<p class="alert alert-success">営業カレンダーを保存しました。</p>
{/if}

{foreach from=$calendar_list nofilter key=months item=value}
<div id="month{$months}">

<h5>
<a href="{$self}?mode=edit_calendar&category_id={$view_category_id}&year={$prev_year}&month={$prev_month}"><i class="fa fa-fw fa-chevron-left"></i></a>
{$year}年{$month}月
<a href="{$self}?mode=edit_calendar&category_id={$view_category_id}&year={$next_year}&month={$next_month}"><i class="fa fa-fw fa-chevron-right"></i></a>
</h5>

<table class="tblFull">

<tr>
<th>Sun</th>
<th>Mon</th>
<th>Tue</th>
<th>Wed</th>
<th>Thu</th>
<th>Fri</th>
<th>Sat</th>
</tr>

{foreach from=$value nofilter key=week item=values}

<tr height="2em">

{foreach from=$values nofilter key=day item=item}

<td id="td{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'} " style="width:90px;height:90px;min-heigth:90px;">
{if ($item != 'brunk')}
<div id="p{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}"><span class="tag micro{if !$schedule[$year][$months][$day]['open']} none{/if}"><i class="fa fa-check"></i></span>{$day}</div>

{if $item}<div class="em08 deepred">{$item}</div>{/if}

<div class="clearfix"></div>


<span id="checked_special{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}" class="tag micro{if !$schedule[$year][$months][$day]['special']} none{/if}"><i class="fa fa-check"></i></span><span class="em08" for="special{$year|string_format:'%04d'}-{$months|string_format:"%02d"}-{$day|string_format:"%02d"}" >特別営業日</span>

<span class="micro tag {if !$schedule[$year][$months][$day]['opt_stock']}none{/if}" id="opt_stock_tag{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}">在庫引当</span>
<div><pre id="st{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}" class="em07">{$schedule[$year][$months][$day]['select_time']}</pre></div>


<div class="pull-left"><button type="button" id="date{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}" class="special form-control input-sm">設定</button></div>

<div class="clearfix"></div>


{/if}
</td>

{/foreach}

</tr>

{/foreach}

</table>
</div>
{/foreach}

<div id='dialog' class="dialog none" style="text-align:left;" title='営業日の設定'>

<form id="form_dialog">
<label><input type="checkbox" id="opt_open" name="open" value="1"  /> 選択可能日に設定</label><br />
<label><input type="checkbox" id="opt_special" name="special" value="1"  /> 特別営業日として設定</label><br />
<label><input type="checkbox" id="opt_stock" name="opt_stock" value="1"  /> 在庫引当</label>
<textarea rows="4" id="select_time" name="select_time" class="form-control"></textarea>
<p class="em09">改行が項目の区切り（1選択肢1行）になります。在庫・定員は項目に半角カンマ区切りで入力してください。例：10:00,10（デフォルトの場合は空欄でOK!!）</p>
</form>


<form>
<input name="date" type="hidden" value="{$year|string_format:'%04d'}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}" /></form>

</div>

{literal}
<style type="text/css">
  #previewModal iframe {
    border:none;
    padding: 0px;
  }

  #previewModal .modal-body {
    padding: 15px;
  }

</style>

<script type="text/javascript">
//<[!CDATA[


$(function(){
  $('#preview').on('click',function(){
//  hideLoading();

  var ih = window.innerHeight
  var href = $(this).attr('href');
  var iframe = $('<iframe>').attr('src',href).attr('width','100%').attr('height','100%');
    $("#previewModal").find(".modal-body").css('height',ih*0.9).html(iframe);



//  $("#mailModal").find(".modal-body").load(href);
  $("#previewModal").modal();
	return false;
	});
});
//]]>
</script>
{/literal}

<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-body"></div>
</div>
</div>
</div>


{include file='footer.tpl'}
