{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('アドレスを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="登録ユーザーアドレスの一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* アドレス一覧本体 開始 *}
<h4 class="page_title">
{if $view_group_id}{groups id=$view_group_id}【{$group['denomination']}】{$page_title}</h4>

{if $view_searchword}
<h5>「{$view_searchword}」の検索結果</h5>
{/if}


{if $group['condition']}<p>絞り込み条件：

{translate_condition condition=$group['condition']}
{if $translate_condition['component']}<div><span class="badge badge-secondary">お申込み</span> {$translate_condition['component']} {$translate_condition['category_denomination']}</div>{/if}
{if $translate_condition['forced']}<div><span class="badge badge-secondary">ユーザーの配信停止設定</span> {$translate_condition['forced']}</div>{/if}
</p>
{/if}

{/groups}{/if}

{regists group_id=$view_group_id per_page=20}
{if $regist_header}

<div id="ct">
<div class="pull-left">
<p>{$regist_count}件中の{$first_regist_no}〜{$last_regist_no}件目</p>
</div>

<div class="pull-right" id="search">
<form method="post" action="{$self}?mode=list_email&group_id={$view_group_id}" class="form-inline">
<p><label for="search_word"></label>
<input type="search" class="form-control" id="searchword" name="searchword" value="{$view_searchword}" maxlength="64" placeholder="メールアドレス・名前" />
<input class="btn btn-primary form-control" type="submit" value="検索" /></p>
</form>
</div>
</div>

<div class="clearfix"></div>
<table class="inputForm_free" cellspacing="0">
<thead>
<tr class="mh">
<th>ID</th>
<th>名前</th>
<th>e-mail</th>
<th>最終更新日</th>
</tr>
</thead>



{/if}


<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$init_url}adm/regist/?mode=show_regist&rid={$regist['id']}" target="_blank">{$regist['id']}</a></td>
<td>{if $regist['namef']}{$regist['namef']} {$regist['nameg']}{else}未登録{/if}</td>
<td>{$regist['email']}{if $regist['status']==-9}<span class="tag min gray">非登録</span>{else if $regist['status']==9}<span class="tag black min">退会</span>{/if}{if $regist['send_error']}<span class="tag black min">送信エラー</span>{/if}{if $regist['inherit']}<span class="label label-primary">newlife継承</span>{/if}{if $regist['dm']}<span class="label label-default">配信停止</span>{/if}

{*if $regist['email']==$regist['student_email']}<span class="{$healthClassList[$regist['rc_se']]}">{$healthList[$entry_rc_se]}</span>
{else if $regist['email']==$entry_student_email_mobile}<span class="{$healthClassList[$entry_rc_sem]}">{$healthList[$entry_rc_sem]}</span>
{else if $regist['email']==$entry_parent_email}<span class="{$healthClassList[$entry_rc_pe]}">{$healthList[$entry_rc_pe]}</span>
{else if $regist['email']==$entry_parent_email_mobile}<span class="{$healthClassList[$entry_rc_pem]}">{$healthList[$entry_rc_pem]}</span>
{/if*}
</td>
<td>{$regist['date']}</td>
</tr>
{if $regist_footer}
</table>
{/if}
{/regists}
{* アドレス一覧本体 終了 *}



{* ページ選択 *}
{include file='page_select.tpl'}


{* アドレスが見つからなかった場合の出力等 開始 *}
{if $no_regist}

<p>絞り込み条件：{groups id=$view_group_id}{if $group['oncategory']}{categories id=$group['category_id']}「{$category['denomination']}」{/categories}{/if}{if $group['year']}「入学年度：{$group['year']}」{/if}{/groups}</p>

<p class="alert alert-info">アドレスが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">アドレスの読み込みに失敗しました。</p>
{/if}
{* アドレスが見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
