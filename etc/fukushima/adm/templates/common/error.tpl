{include file='header.tpl'}

{if $category['denomination']}
<div class="contact">
<h4 class="top">{$category['denomination']}</h4>
<p class="pad_l">
{$category['description']|nl2br}
</p>
</div>
{/if}

<p class="alert alert-danger">{$errmsg}</p>

<p><a class="btn btn-primary" href="{$init_url}adm/"><i class="fa fa-fw fa-reply"></i>{$init_coopname} 管理トップページに戻る</a></p>


{include file='footer.tpl'}
