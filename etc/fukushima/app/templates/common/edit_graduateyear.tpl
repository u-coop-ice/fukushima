<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
$("#graduateyear").AnyTime_picker(
{
	format: "%Y年%m月",
	monthAbbreviations: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
	labelTitle: "年月選択",
	labelYear: "年",
	labelMonth: "月",
 } );
})

$(function(){
	$('.reset').on('click',function(){
			$(this).prev('input').val('');
	});
});
//]]>
</script>



<div id="form-group_graduateyear" class="form-group">
<label class="control-label col-sm-3">{$methods['graduateyear']['title']|default:"卒業予定年"}{if $methods['graduateyear']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="graduateyear" name="graduateyear" value="{$regist['graduateyear']}" placeholder="" class="datetime form-control input-lg{if $methods['graduateyear']['use']==2} validate[required]{/if}">
<button type="button" class="reset btn btn-primary btn-sm">リセット</button>
{if $error['graduateyear']=="1"}<span class="must_view">*必須項目です</span>{/if}
{if $methods['graduateyear']['note']}<p class="help-block">{$methods['graduateyear']['note']}</p>{/if}
</div>
</div>
