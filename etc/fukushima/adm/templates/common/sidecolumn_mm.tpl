{if $smarty.const.COMPONENT=="mm"}
<div class="sidecolumn navi">
<dl>
<dt>メールマガジン</dt>
<dd><a href="{$self}?mode=edit_magazine"><i class="fa fa-fw fa-pencil"></i>新規作成</a></dd>
<dd><a href="{$self}?mode=list_magazine&status=sent"><i class="fa fa-fw fa-inbox"></i>送信済みトレイ</a>
<dl class="pad_l">
{send sent=1}
<dd><a href="{$self}?mode=list_magazine&status=sent&group_id={$send['id']}"><i class="fa fa-fw fa-caret-right"></i>{$send['denomination']}({$send['magazine_count']})</a></dd>
{/send}
{get_magazine_count onetime=1 sent=1}
{if $getmagazinecount}
<dd><a href="{$self}?mode=list_magazine&status=sent&onetime=1"><i class="fa fa-fw fa-caret-right"></i>その他({$getmagazinecount})</a></dd>
{/if}
</dl>
</dd>
<dd><a href="{$self}?mode=list_magazine&status=reserved"><i class="fa fa-fw fa-clock-o"></i>送信予約トレイ</a>
<dl class="pad_l">
{send reserve=1}<dd><a href="{$self}?mode=list_magazine&status=reserved&group_id={$send['id']}"><i class="fa fa-fw fa-caret-right"></i>{$send['denomination']}({$send['magazine_count']})</a></dd>{/send}
{get_magazine_count onetime=1 reserved=1}
{if $getmagazinecount}
<dd><a href="{$self}?mode=list_magazine&status=reserved&onetime=1"><i class="fa fa-fw fa-caret-right"></i>その他({$getmagazinecount})</a></dd>
{/if}
</dl>
</dd>
<dd><a href="{$self}?mode=list_magazine&status=draft"><i class="fa fa-fw fa-edit"></i>下書き</a>
<dl class="pad_l">
{send draft=1}
<dd><a href="{$self}?mode=list_magazine&status=draft&group_id={$send['id']}"><i class="fa fa-fw fa-caret-right"></i>{$send['denomination']}({$send['magazine_count']})</a></dd>
{/send}
{get_magazine_count onetime=1 draft=1}
{if $getmagazinecount}
<dd><a href="{$self}?mode=list_magazine&status=draft&onetime=1"><i class="fa fa-fw fa-caret-right"></i>その他({$getmagazinecount})</a></dd>
{/if}

</dl>
</dd>

<dd><a href="{$self}?mode=delete_magazine_all"><i class="fa fa-fw fa-trash"></i> メルマガ一括削除</a></dd>
<dt>登録ユーザー</dt>
<dd><a href="{$self}?mode=list_email"><i class="fa fa-fw fa-list-ul"></i> 登録ユーザー一覧</a>
<dl class="pad_l">
{groups all=1}
<dd><a href="{$self}?mode=list_email&group_id={$group['id']}"><i class="fa fa-fw fa-caret-right"></i>{$group['denomination']}({get_regist_count group_id=$group['id']})</a></dd>
{/groups}
</dl>
</dd>
<dt>ユーザーグループ</dt>
<dd><a href="{$self}?mode=edit_group"><i class="fa fa-fw fa-plus"></i>グループの新規作成</a></dd>
<dd><a href="{$self}?mode=list_group"><i class="fa fa-fw fa-list-ul"></i>グループの一覧</a>
</dd>

</dl>
</div>

{/if}
