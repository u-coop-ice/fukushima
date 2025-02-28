{include file='header.tpl'}

{if $errmsg}
<p class="error">{$errmsg}</p>
{/if}
{if $category['denomination']}
<div class="contact">
<h5 class="top">{$category['denomination']}</h5>
<p class="pad_l">
{if $closed}
{$category['description_closed']|nl2br}
{else if $category['description_web']}
{$category['description_web']|nl2br}
{/if}
</p>
</div>
{/if}


<div class="row">
<div class="col-sm-8"><p><a class="btn btn-primary btn-block" href="{$init_coopurl}"><i class="fa fa-fw fa-reply"></i>{$init_coopname} トップページに戻る</a></p>
</div></div>


{include file='footer.tpl'}
