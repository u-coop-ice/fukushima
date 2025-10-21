{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('カテゴリーを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="カテゴリの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="deleted note">カテゴリを削除しました。</p>
{/if}

<div class="alert alert-danger">
<h5 class="top">みなさまへお願い</h5>
<p>利用が終わったカテゴリは、アーカイブ化（デフォルトで表示しないが、DBには残っているので呼び出せる）するようお願いします。それだけで管理画面のレンダリングが見違えるように高速化します。カテゴリ編集＞中段あたりの「アーカイブ化」を「ON」にしてください。</p>
</div>


<div><a class="btn btn-primary" href="{$self}?mode=edit_category"><i class="fa fa-pencil-square-o"></i>カテゴリーの新規作成</a></div>

<p class="right">初期設定メール送信先：{$init_ordermail}</p>

{categories all=1 component="entry"}
{if $category_header}
<table class="inputForm_free" cellspacing="0">
<tr>
<th class="mh" style="width: 35%;text-align: left;">名称</th>
<th class="mh" style="width: 30%;text-align: left;">投稿メール送信先</th>
<th class="mh" style="width: 5%;">運用状態</th>
<th class="mh" style="width: 20%;">登録数</th>
<th class="mh" style="width: 10%;">並び順</th>
{if $authority['entry']['delete']}
<th class="mh"><i class="fa fa-wrench"></i>&nbsp;</th>
{/if}
</tr>
{/if}
{get_app_count category_id=$category['id']}
<tr{if $is_odd} class="odd"{/if}>
<td style="word-break:break-all;"><a href="{$self}?mode=edit_category&category_id={$category['id']}">{$category['denomination']}</a><br />
<a href="{$init_url}app/entry/?cd={$category['code']}" target="_blank">{$init_url}app/entry/?cd={$category['code']}<i class="fa fa-fw fa-external-link"></i></a></td>
<td style="word-break:break-all;">{if $category['ordermail']}{$category['ordermail']}{else}{$init_ordermail}{/if}</td>
<td class="nowrap">
<span title="{$category['date_start']}〜{$category['date_limit']}" class="tag 
{if $category['status']<0}black">終了{else if $category['status']==0}red">準備中
{else}{if $category['onstock']}{if $app_count_state<1}black">在庫切停止{else}green">稼働中{/if}
{else}green">稼働中{/if}{/if}</span>
</td>
<td>
{if $category['onstock']==1}<a href="{$self}?mode=list_app&category_id={$category['id']}">{$app_count}</a>
/<span class="tag min {$stockColorList[$app_count_state]}">{$category['stock']}</span>
{else if $category['onstock']==2}
{foreach from=$stock_multi key=k item=v}
<span class="">{$k}</span><br />{$v['ct']}/<span class="tag micro {if $v['diff']>0}green{else if $v['diff']==0}navy{else}red{/if}">{$v['stock']}</span><br />
{/foreach}
{else}
<a href="{$self}?mode=list_app&category_id={$category['id']}">{$app_count}</a>
{/if}
</td>
<td>{$category['sort_order']}</td>

{if $authority['entry']['delete']}
<td class="delete_category_button">
<span><a class="btn btn-primary btn-sm" title="設定をコピーして新しいフォームを作成する" href="{$self}?mode=edit_category&category_id={$category['id']}&copy=1"><i class="fa fa-copy"></i></a></span>

{if $app_count}
&nbsp;
{else}
<form method="post" action="{$self}?mode=delete_category" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$category['id']}" />
<input type="hidden" name="query" value="{$query}" />
<input class="btn btn-primary btn-sm" type="submit" value="削除" />
</form>
{/if}
</td>
{/if}
</tr>
{if $category_footer}
</table>
{/if}
{/categories}

{if $view_archived}
<p class=""><a href="{$self}?mode=list_category">アーカイブは表示しない</a></p>
{else}
<p class=""><a href="{$self}?mode=list_category&archived=1">アーカイブを含めてすべて表示</a></p>
{/if}



{if $no_category}
<p class="alert alert-info">カテゴリーが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">カテゴリーの読み込みに失敗しました。</p>
{/if}
{*include file='footer.tpl'*}
