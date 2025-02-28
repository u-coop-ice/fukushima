{if $page_count > 1}
<form name="page_sel">
<p>
{if $is_prev_page}
<a href="{$self}?{if $url_query}{$url_query}&amp;{/if}page=1">先頭ページ</a>
<a href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$prev_page}">前のページ</a>
{/if}
<select name="page_no">
{page_loop}
<option value="{$page_no}"{if $is_cur_page} selected="selected"{/if}>{$page_no}ページ</option>
{/page_loop}
</select>
<input type="button" class="min" value="移動" onclick="location.href = '{$self}?{if $url_query}{$url_query}&amp;{/if}page=' + document.page_sel.page_no.value;"/>
{if $is_next_page}
<a href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$next_page}">次のページ</a>
<a href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$page_count}">最後のページ</a>
{/if}
</p>
</form>
{/if}
