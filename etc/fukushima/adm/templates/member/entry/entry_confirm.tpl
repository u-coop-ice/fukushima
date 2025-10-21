{* ヘッダー部分の組み込み *}
{include file='../htkt/header.tpl'}

{* 1ページあたり記事を10件ずつ表示 *}
{entry_page_navi_setup per_page=10}

{* 記事一覧 開始 *}

<h4>{$blogname}{$entry_publish}</h4>
{entries}
<div class="noticeInTheTop">
こちらは公開時の表示確認画面です。<br />
<strong class="em07">現在この一言カードは{if $entry_publish==0}未公開{else}公開済み{/if}です。</strong>
</div>

<div class="">
<dl>
<dt>{if $entry_conv_br}{$entry_text_edit|nl2br}{else}{$entry_text_edit}{/if}
{if $entry_has_category}
<p class="px13 right normal black">
{/if}
投稿日時 : {$entry_date}&nbsp;
宛先 : <a href="{$self}?cat_id={$entry_category_id}">{$entry_category_name}</a><br />
</p>
</dt>
{if $entry_text_return}
<dd class="entry-return">{if $entry_conv_br}{$entry_text_return|nl2br}{else}{$entry_text_return}{/if}</dd>
{/if}
<dd>
</div>
{/entries}
{* 記事一覧 終了 *}

{* ページ選択 *}
{include file='../common/page_select.tpl'}

{* 記事がない場合など 開始 *}
{if $no_entry}
<p>記事がありません</p>
{/if}
{if $db_error}
<p>データベースからデータを読み込むのに失敗しました。</p>
{/if}
{* 記事がない場合など 終了 *}

<p><a href="{$self}?mode=edit_entry&id={$view_entry_id}">編集画面に戻る</a></p>



{* フッター部分の組み込み *}
{include file='../htkt/footer.tpl'}
