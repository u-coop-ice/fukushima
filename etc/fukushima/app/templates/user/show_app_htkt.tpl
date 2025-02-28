{htkt_entries}

<div class="contact">
<h5 class="top">{if $entry['title_edit']}{$entry['title_edit']}{else}{$entry['title']}{/if} <span class="label label-info {$entry['category_color']}">{$entry['category_name']}</span></h5>

<p>{if $entry['text_edit']}{$entry['text_edit']|nl2br}{else}{$entry['text']|nl2br}{/if}</p>

<p>（{if $entry['affiliation']}{$entry['affiliation']}　{/if}{if $entry['identity']}{$entry['identity']}　{/if}{$entry['nickname']}）</p>
{if $entry['has_category']}
<p class="px12 right normal black">
投稿日：{$entry['date']|date_format:"%Y/%m/%d"}&nbsp;
宛先：<a href="{$self}?cid={$entry['category_id']}">{$entry['category_name']}</a>
</p>
{/if}
</div>

{if $entry['publish']}

<div class="contact gray">
<p class="right"><span class="label label-success">回答公開済</span></p>
{if $entry['text_return']}
<p>{$entry['text_return']|nl2br}</p>
{/if}
<p>{$entry['replyer']}</p>
<p class="right px12">回答日：{$entry['date_return']|date_format:"%Y/%m/%d"}</p>
</div>

<p><a class="btn btn-primary" href="{$init_url}app/htkt/?mode=show_entry&ic={$entry['code']}" target="_blank"></i>掲載サイトで確認する<i class="fa fa-fw fa-external-link"></i></a></p>

<div class="clear"></div>
{else}
<div class="contact gray">
<p class="form-control-static"><span class="label label-warning">回答準備中</span></p>
</div>
{/if}
{/htkt_entries}
