{if $smarty.const.COMPONENT=="ask"}
{if $authority['ask']['show']}

<div class="sidecolumn navi">
<dl>
<dt>システムメール</dt>

{get_add_count add="ask"}
<dd><a href="{$init_url}adm/ask/?mode=list_mail&amp;add=ask&amp;noreply[]=1&amp;noreply[]=2"><i class="fa fa-fw fa-comment"></i>メール送受信(お問い合わせ)({$add_counts['all']})</a>
<dl>
{ask_categories all=1}
<dd><a href="{$init_url}adm/ask/?mode=list_mail&amp;add=ask&amp;category_id={$category['id']}&amp;noreply[]=1&amp;noreply[]=2"><i class="fa fa-fw fa-caret-right"></i>{$category['denomination']}({$add_counts[$category['id']]|default:0})</a></dd>
{/ask_categories}
<dd><a href="{$init_url}adm/ask/?mode=list_mail&amp;add=ask&amp;no_category=1&amp;noreply[]=1&amp;noreply[]=2"><i class="fa fa-fw fa-caret-right"></i>関連申込・その他({$add_counts[0]|default:0})</a></dd>
</dl>

</dd>

{get_add_count add="living"}

<dd><i class="fa fa-caret-right"></i> <a href="{$init_url}adm/ask/?mode=list_mail&amp;add=living&amp;noreply[]=1&amp;noreply[]=2" >お問い合わせ(不動産)({$add_counts['all']})</a></dd>


{*get_add_count*}


{*<dd><a href="{$init_url}adm/ask/?mode=list_mail&amp;add=ask"><i class="fa fa-fw fa-comment"></i>メール送受信(お問い合わせ)({get_add_count add="ask"})</a></dd>
<dd><a href="{$init_url}adm/ask/?mode=list_mail"><i class="fa fa-envelope-o"></i> すべてのメール履歴({get_add_count})</a></dd>*}
<dd><a href="{$init_url}adm/ask/?mode=list_mail&amp;noreply[]=1&amp;noreply[]=2"><i class="fa fa-envelope-o"></i> すべてのメール履歴</a></dd>

</dl>
{/if}

{if $authority['ask']['master']}
<div class="hr"></div>

<dl>
{if $authority['ask']['edit']}
<dt><i class="fa fa-fw fa-square"></i>宛先</dt>
<dd><a href="{$init_url}adm/ask/?mode=edit_category" ><i class="fa fa-fw fa-edit"></i>宛先の新規作成</a></dd>
<dd><a href="{$init_url}adm/ask/?mode=list_category" ><i class="fa fa-fw fa-list"></i>宛先の一覧</a></dd>
{/if}



<dt>基本設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
</dl>
{/if}

</div>
{/if}
