{if $page_count > 1}
<nav class="navigation pagination" role="navigation">

{if $is_prev_page}
{*<a class="page-numbers" href="{$self}?{if $url_query}{$url_query}&amp;{/if}page=1" title="先頭ページ"><i class="fa fa-fast-backward"></i></a>*}
<a class="prev page-numbers" href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$prev_page}" title="前のページ"><i class="fa fa-chevron-left"></i> PREV</a>
{/if}
{page_loop limit=4}
{if $is_cur_page}
<span class="page-numbers current">{$page_no}</span>
{else}
<a class="page-numbers" href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$page_no}">{$page_no}</a>
{/if}
{/page_loop}

{if $is_next_page}
<a class="next page-numbers" href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$next_page}" title="次のページ">NEXT <i class="fa fa-chevron-right"></i></a>
{*<a class="page-numbers" href="{$self}?{if $url_query}{$url_query}&amp;{/if}page={$page_count}" title="最終ページ"><i class="fa fa-fast-forward"></i></a>*}
{/if}
</nav>
{/if}
