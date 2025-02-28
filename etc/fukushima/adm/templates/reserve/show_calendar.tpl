{capture assign="header_insert"}
{literal}


<script type="text/javascript">
//<[!CDATA[
	//]]>
</script>
{/literal}
{/capture}

{capture assign="page_title"}
{$category['denomination']} 登録一覧
{/capture}


{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>



<h5>
<a href="{$self}?mode=show_calendar&year={$prev_year}&month={$prev_month}&category_id={$view_category_id}"><i class="fa fa-fw fa-chevron-left"></i></a>
{$year}年{$month}月
<a href="{$self}?mode=show_calendar&year={$next_year}&month={$next_month}&category_id={$view_category_id}"><i class="fa fa-fw fa-chevron-right"></i></a>
</h5>



{foreach from=$calendar_list nofilter key=months item=value}


<div id="month{$months}">

<table class="tblFull" cellspacing="0">

<tr>
<th>Sun</th>
<th>Mon</th>
<th>Tue</th>
<th>Wed</th>
<th>Thu</th>
<th>Fri</th>
<th>Sat</th>
</tr>

{foreach from=$value nofilter key=week item=values}

<tr>

{foreach from=$values nofilter key=day item=item}

<td style="width:90px;height: 5em;min-height:5em;">
{if ($item != 'brunk')}
{assign var='date' value="{$year}-{$months|string_format:'%02d'}-{$day|string_format:'%02d'}"}
<div>{$day}
{if $item}(<a href="{$self}?mode=list_app&category_id={$view_category_id}&year={$year}&month={$months}&day={$day}">{$calendar_list_diff[$date]}/{$item}</a>)</div>
{foreach from=$stocks[$date] key=k item=v}
<div class="em09">
<span class="label label-default">{$k}</span> <a href="{$self}?mode=list_app&category_id={$view_category_id}&year={$year}&month={$months}&day={$day}&time={$k}">{$v['ct']|default:0}</a>{if $opt_stocks[$date]}/<span class="label {if $v['stock']-$v['ct']>0}label-success{else if ($v['stock']==$v['ct'])}label-primary{else}label-danger{/if}">{$v['stock']}</span>{/if}</div>
{/foreach}


{else}&nbsp;{/if}
{/if}
</td>

{/foreach}

</tr>

{/foreach}

</table>
<p class="pad_l">エントリー数をクリックすると、日付ごとの一覧を表示します。日付横の数字は（申込数／キャンセル含んだ総申込数）です。</p>

</div>
{/foreach}


{include file='footer.tpl'}
