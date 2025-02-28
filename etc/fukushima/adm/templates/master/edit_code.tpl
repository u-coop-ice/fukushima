{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<![CDATA[

$(function(){
    var radio = $('div.radio-group');
    $('input', radio).css({'opacity': '0'});

$("input:checked").next().addClass("checked");
$("input:checked").parent().addClass("checked");

    $('label', radio).click(function() {
        $(this).parent().parent().each(function() {
            $('label',this).removeClass('checked'); 
        });
        $(this).addClass('checked');
    });
});

//]]>
</script>
{/literal}
{/capture}

{capture assign="page_title"}
所属コード・大学合格種別（KLAS）の{if $view_code_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="saved">保存しました。</p>
{/if}

{code}
<form name="code" id="code" method="post" action="{$self}?mode=save_code" onsubmit="">
{if $code['id']}
<input type="hidden" name="id" value="{$code['id']}" />
{/if}
<input type="hidden" name="univ_id" value="{$view_univ_id}" />
<input type="hidden" name="name" value="{$view_code_name}" />
<table class="inputForm" cellspacing="0">
<tr>
<th>{if $name="23"}所属{else}大学合格種別{/if}コード<span class="label label-danger">必須</span></th>
<td><input class="form-control" type="text" name="number" id="number" maxlength="4" value="{$code['number']}" /></td>
</tr>
<tr>
<th>名称<span class="label label-danger">必須</span></th>
<td><input class="form-control" type="text" name="value" id="value" value="{$code['value']}" /></td>
</tr>
{if $view_code_name==23}
<tr>
<th>組合員区分</th>
<td>
<select class="valedate[required] form-control" id="member" name="member" >
{html_options options=$memberList selected=$code['member']}
</select>
</td>
</tr>
{/if}
<tr>
<th>並び順（半角数字）</th>
<td><input class="form-control" type="text" name="sort_order" id="sort_order" value="{$code['sort_order']}" /></td>
</tr>
<tr>
<th>表示</th>
<td>
<div class="radio radio-group clearfix">
<div><label for="flag1"><input type="radio" id="flag1" name="flag" value="1" {if $code['flag']==1}checked="checked"{/if} />表示</label></div>
<div><label for="flag2"><input type="radio" id="flag2" name="flag" value="0" {if $code['flag']==0}checked="checked"{/if} />非表示</label></div>
</div>
</td>
</tr>

</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存">保存する</button></p>
</form>
{/code}
{if $no_code && !$new}
<p class="alert alert-info">コードが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">コードの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
