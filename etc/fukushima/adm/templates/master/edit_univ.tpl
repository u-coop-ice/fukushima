{capture assign="header_insert"}
{literal}
<script type="text/javascript" src="admin.js"></script>
<script type="text/javascript">
//<[!CDATA[
var cat_name = {
{/literal}
{univ glue="," not_id="$id"}
    '{$univ|escape:"javascript"}' : {$univ_id}
{/univ}
{literal}
};

function submitCheck() {
    if (!document.univ.name.value) {
        alert('カテゴリーの名前を入力してください。');
        document.univ.name.focus();
        return false;
    }
    if (isNaN(parseInt(document.univ.sort_order.value))) {
        alert('カテゴリーの並び順を数値で入力してください。');
        document.cat.sort_order.focus();
        return false;
    }
    if (cat_name[document.univ.name.value]) {
        alert('同名のカテゴリーがすでに存在します。');
        document.cat.name.focus();
        return false;
    }
    return true;
}
//]]>
</script>
{/literal}
{/capture}

{capture assign="page_title"}
宛先の{if $id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

{univ id=$id}
<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="saved">宛先を保存しました。</p>
{/if}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_univ" onsubmit="return submitCheck();">
{if $id}
<input type="hidden" name="id" value="{$id}" />
{/if}
<table class="inputForm" cellspacing="0">
  <tr>
    <th><label for="name">宛先</label></th>
    <td><input type="text" name="name" id="name" size="50" value="{$univ_name}" /></td>
  </tr>
  <tr>
    <th><label for="coopname">大学生協名</label></th>
    <td><input type="text" name="coopname" id="coopname" size="50" value="{$coop_name}" /></td>
  </tr>
  <tr>
    <th><label for="name">投稿メール送信先</label><br /><span class="em09">初期設定アドレス以外に送信先が<br />必要な場合入力してください。</span></th>
    <td><input type="text" name="ordermail" id="ordermail" size="50" value="{$univ_ordermail}" /></td>
  </tr>
  <tr>
    <th><label for="code">大学生協コード</label></th>
    <td><input type="text" name="code" id="code" size="50" value="{$univ_code}" /></td>
  </tr>
  <tr>
    <th><label for="sort_order">並び順</label></th>
    <td><input type="text" name="sort_order" id="sort_order" size="10" value="{$univ_sort_order}" /></td>
  </tr>
</table>
<p><input type="submit" name="submit" value="保存" /></p>
</form>
{/univ}
{if $no_univ && !$new}
<p>宛先が見つかりませんでした。</p>
{/if}
{if $db_error}
<p>宛先の読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
