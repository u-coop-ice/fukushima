{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
$(function() {

	var all = $('#noreply_all');
	if (all.prop('checked')){
		$('[name="noreply[]"]').prop('disabled',true);
	}

	all.on('click',function(){
		if($(this).prop('checked')){
			$('[name="noreply[]"]').prop('disabled',true);
		} else {
			$('[name="noreply[]"]').prop('disabled',false);
		}
	});
});

//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="システムメール送信履歴（{if $view_app=="stay"}受験宿泊分のみ{else if $view_add=="ask"}お問い合わせフォーム{else if $view_add=="living"}不動産{else}すべて{/if}）"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>

<div id="search">
<form method="put" id="searchForm" class="form-inline" action="{$self}" class="filter_entry">
<input type="hidden" name="mode" value="list_mail" />

<p>
<div class="checkbox">
<label><input type="checkbox" id="noreply_all" {if $view_noreply|@count==0}
checked="checked"{/if} >すべて</label>
{html_checkboxes options=$noreplyList name="noreply" checked=$view_noreply}
</div>




{if $view_app}
<input type="hidden" name="app" value="{$view_app}" />
{/if}
{if $view_add}
<input type="hidden" name="add" value="{$view_add}" />
{/if}

{if $view_category_id}
<input type="hidden" name="category_id" value="{$view_category_id}" />
{/if}

<span class="checkbox">
<label for="searchword">
<input type="search" id="searchword" name="searchword" class="form-control" value="{$view_search_word}" placeholder="氏名・カナ" maxlength="64" />
</label>
</span>
<button type="submit" class="btn btn-primary" value="検索">検索</button></p>
</form>
</div>

{if $deleted}
<p class="alert alert-success">メールを削除しました。</p>
{/if}

{adds app=$view_app add=$view_add manual=1 per_page=10}


{if $add_header}
<p>{$add_count}件中の{$first_add_no}〜{$last_add_no}件目</p>
<table class="inputForm_free em09" cellspacing="0">
<tr>
<th class="mh" style="width:15%;">件名</th>
<th class="mh" style="width:15%;"><i class="fa fa-arrow-right"></i>送信／<i class="fa fa-envelope"></i>受信</th>
<th class="mh" style="width:10%;">種別</th>
<th class="mh" style="width:10%;">宛先</th>
<th class="mh" style="width:10%;">関連申込</th>
<th class="mh" style="width:15%;">担当(メモ)</th>
<th class="mh" style="width:15%;">送信日時</th>
<th class="mh" style="width:10%;">状況</th>
</tr>
{/if}
<tr{if $add['send']} class="send"{/if}>
<td><a href="{$self}?mode=show_mail&add_id={$add['id']}">{if $add['subject']}{$add['subject']|mb_truncate:60:"･･･"}{else}件名なし{/if}</a></td>
<td><i class="fa fa-fw fa-{if $add['recieve']}envelope{else if $add['send']}arrow-right{/if}"></i><div>{if $add['namef']}{$add['namef']} {$add['nameg']}{else}{$add['username']}{/if}</div>{if $add['user_status']==9}<span class="tag min black">退会済</span>{else if $add['user_status']==-9}<span class="tag min gray">非登録</span>{/if}</td>
<td>{$add['add']}</td>
<td>{if $add['category_id']}{ask_categories id=$add['category_id']}{$category['denomination']}{/ask_categories}{/if}</td>
<td>{$add['app_component']}
{if $add['app_id']}
{get_app_info app_id=$add['app_id']}
<p><a href="{$init_url}adm/{$app['component']}/{if $app['part']}{$app['part']}/{/if}?mode=show_app&app_id={$add['app_id']}" target="_blank">{$app['regist_code']}</a></p>
{/if}

</td>
<td>{if $add['cover']}<div>{$add['cover']}</div>{/if}<span title="{$add['treat']}">{$add['treat']|mb_truncate:10:"･･･"}</span></td>
<td>{$add['regist_date']}{if $add['recieve']}<span class="micro tag{if $add['read']} black{/if}">{$readList[$add['read']|default:0]}</span>{/if}</td>
<td>{if $add['noreply']>-1}<span class="min tag {$reactColorList[$add['noreply']]}">{$reactList[$add['noreply']]}</span>{/if}</td>

</tr>
{if $add_footer}
</table>
{/if}
{/adds}

{* ページ選択 *}
{include file='page_select.tpl'}


{if $no_add}
<p class="alert alert-info">システムメールの履歴が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">システムメールの履歴の読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}

