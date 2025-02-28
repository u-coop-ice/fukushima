{if $smarty.const.COMPONENT=="arbeit"}
<div class="sidecolumn navi">

<dl>
<div><a class="btn btn-primary btn-sm" href="{$init_url}app/arbeit/" target="_blank">求人公開サイト <i class="fa fa-external-link"></i></a></div>


{if $authority['arbeit']['show']}

<dt>求人情報の公開操作</dt>
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&all=1" ><i class="fa fa-list"></i> すべて{arb_entries list=1}({$entry['ct']}){/arb_entries}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&ready=1" ><i class="fa fa-paperclip"></i> 掲載申請中{arb_entries list=1 ready=1}({$entry['ct']}){/arb_entries}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&visible=1" ><i class="fa fa-file-text-o"></i> 公開中{arb_entries list=1 visible=1}({$entry['ct']}){/arb_entries}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&before=1" ><i class="fa fa-clock-o"></i> 予約公開{arb_entries list=1 before=1}({$entry['ct']}){/arb_entries}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&expiry=1" ><i class="fa fa-file-text"></i> 公開終了{arb_entries list=1 expiry=1}({$entry['ct']}){/arb_entries}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&else=1" ><i class="fa fa-folder-open"></i> その他{arb_entries list=1 else=1}({$entry['ct']}){/arb_entries}</a></dd>
{/if}

{if $authority['arbeit']['show']}
<dt>求人情報の新規作成</dt>
<dd><a href="{$init_url}adm/arbeit/?mode=edit_entry&step=1" ><i class="fa fa-edit"></i> 新規作成</a></dd>
{/if}

<div class="hr"></div>

{if $authority['arbeit']['show']}
<dt>登録企業の操作</dt>
<dd><a href="{$init_url}adm/arbeit?mode=list_regist"><i class="fa fa-folder-open"></i> 登録企業一覧</a></dd>


<div class="hr"></div>
{if $authority['arbeit']['show']}
<dt>支払状況</dt>
{foreach from=$paymentList key=k item=v}
<dd><a href="{$init_url}adm/arbeit/?mode=list_entry&status_payment={$k}" ><i class="fa fa-caret-right"></i> {$v}({arb_entry_count status_payment=$k})</a></dd>
{/foreach}

<dt>利用実績</dt>
<dd><a href="{$init_url}adm/arbeit/?mode=show_result"><i class="fa fa-calculator"></i> 利用実績</dd>

{/if}


<div class="hr"></div>

<dt>登録企業からの連絡</dt>
{foreach from=$statusAskList key=k item=v}
<dd>
<a href="{$init_url}adm/arbeit/?mode=list_ask&st={$k}"><i class="fa fa-comment"></i> {$v}({arb_ask_count status=$k})</a>
</dd>
{/foreach}
{/if}

{if $authority['arbeit']['show']}
<dt>家庭教師の公開操作</dt>
<dd><a href="{$init_url}adm/arbeit/?mode=list_tutor" ><i class="fa fa-list"></i> すべて{arb_tutors list=1}({$tutor['ct']}){/arb_tutors}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_tutor&visible=1" ><i class="fa fa-file-text-o"></i> 公開中{arb_tutors list=1 visible=1}({$tutor['ct']}){/arb_tutors}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_tutor&before=1" ><i class="fa fa-file-text"></i> 未公開{arb_tutors list=1 before=1}({$tutor['ct']}){/arb_tutors}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_tutor&expiry=1" ><i class="fa fa-file-text"></i> 公開終了{arb_tutors list=1 expiry=1}({$tutor['ct']}){/arb_tutors}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_tutor&ready=1" ><i class="fa fa-paperclip"></i> 掲載申請中{arb_tutors list=1 ready=1}({$tutor['ct']}){/arb_tutors}</a></dd>
<dd><a href="{$init_url}adm/arbeit/?mode=list_tutor&else=1" ><i class="fa fa-folder-open"></i> その他{arb_tutors list=1 else=1}({$tutor['ct']}){/arb_tutors}</a></dd>
{/if}

{if $authority['arbeit']['show']}
<dt>家庭教師の新規作成</dt>
<dd><a href="{$init_url}adm/arbeit/?mode=edit_tutor" ><i class="fa fa-edit"></i> 新規作成</a></dd>
{/if}

<div class="hr"></div>

{if $authority['arbeit']['show']}

<dt>データベースの操作</dt>
<dd><a href="{$init_url}adm/arbeit/?mode=edit_excel" >データ書き出し</a></dd>
{/if}


{if $authority['arbeit']['master']}
<dt>基本設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=list_category" ><i class="fa fa-cogs"></i> 求人カテゴリ一覧・編集</a></dd>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=list_page" ><i class="fa fa-edit"></i> 固定ページ管理</a></dd>
{/if}
</dl>
</div>
{/if}

