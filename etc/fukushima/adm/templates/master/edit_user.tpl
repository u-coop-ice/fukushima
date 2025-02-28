{capture assign="header_insert"}
{literal}


<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>


<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
//<[!CDATA[

$(function(){
$("#formID").validationEngine({
  'promptPosition':'inline'
  ,'ajaxFormValidationMethod':'post'
});

});


$(function(){
  $("#change_passowrd").on('click', function(){chgPassword()});
});

function chgPassword() {
  var uid=$("#change_passowrd").attr('data');
  $.fancybox({
  autoSize : false,
  width: 400,
  height: 280,
  href:"./?mode=edit_password&uid="+uid,
  type: "iframe",
  scrolling :'no',
  });

}
//]]>
</script>



{/literal}
{/capture}

{capture assign="page_title"}
管理ユーザーの{if $user_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}


{users id=$user_id}
<h4 class="page_title">{$page_title}</h4>
<div id="msg" class="note none"></div>
{if $saved}
<div id="msg" class="note">ユーザー権限を保存しました。</div>
{/if}

<form id="formID" method="post" action="{$self}?mode=save_user">
{if $user_id}
<input type="hidden" name="id" value="{$user_id}" />
{/if}
<table class="inputForm" cellspacing="0">
<col style="width:30%;" />
{if $new_user}
<tr>
<th>管理ユーザーアカウント<span class="red">※</span></th>
<td><input type="text" name="username" value="{$user['username']}"  class="form-control validate[required,minSize[5],maxSize[16],custom[onlyLetterNumberSp],ajax[ajaxUserCall]]" placeholder="半角英数5文字以上"></td>
</tr>
<tr>
<th>パスワード<span class="red">※</span></th>
<td><input type="password" id="password_new" name="password_new" maxlength="16" class="form-control validate[required,minSize[8],maxSize[16],custom[onlyLetterNumber]]" value="{$user['password']}" placeholder="半角英数8文字以上">
 <span id="passstrength"></span>
</td>
</tr>

<tr>
<th>パスワード（確認）<span class="red">※</span></th>
<td><input type="password" name="password_cfrm" id="password_cfrm" maxlength="16" class="form-control validate[required,minSize[8],maxSize[16],equals[password_new],custom[onlyLetterNumberSp]]" value="{$user_password}" placeholder="（確認のため再度入力）"/>
{if $no_password_cfrm_err}<span class="must_view">*パスワードの形式が不正です</span>{/if}
{if $not_pass_err}<span class="must_view">*パスワードが一致しません</span>{/if}
{if $password_cfrm_err}<span class="must_view">*必須項目です</span>{/if}
<p><strong class="em09 red">パスワードはメモをとるなどして保管しておいてください。</strong></p>
</td>
</tr>




{else}
<tr>
<th>管理ユーザーアカウント</th>
<td>{$user['username']} <span class="tag black">IDの変更はできません</span></td>
</tr>
<tr>
<th>パスワード</th>
<td><div><a class="btn btn-primary btn-sm" id="change_passowrd" data="{$user_id}"><i class="fa fa-lock fa-fw"></i>パスワードの変更</a></div></td>
</tr>
{/if}

<tr>
<th>メールアドレス<span class="red">※</span></th>
<td><input type="text" id="email" name="email" value="{$user['email']}" class="form-control validate[required]" placeholder="（管理ユーザーメールアドレス）">
</td>
</tr>




{foreach from=$authList key=k item=au}
{if $k!="master"}
<tr>
<th>{$authList[$k]['name']}<br />
<span class="em09">{$authList[$k]['description']}</span>

</th>
<td>{if $authority[$k]['master']!=1}<div><span class="tag min black">変更権限はありません</span></div>{else}
<span class="tag min">{$k}</span>
{foreach from=$subAuthList item=s}
<div class="checkbox"><label for="{$k}[{$s}]"><input type="checkbox" name="{$k}[{$s}]" id="{$k}[{$s}]" {if $user["auth"][$k][$s]}checked="checked"{/if} value="1" />{$s}</label>
{if $au[$s]}（{$au[$s]}）{/if}

</div>
{/foreach}


{if $k=="entry" || $k=="reserve"}
{categories component=$k no_archived=1}
{if $category_header}
<dl>
<dd>カテゴリ</dd>
{/if}
<dd>
<div class="checkbox">
<label><input type="checkbox" name="{$k}[category_id][]" value="{$category['id']}" {if $user["auth"][$k]["category_id"] && $category['id']|in_array:$user["auth"][$k]["category_id"]}checked="checked"{/if}> {$category["denomination"]}</label></dd>
</div>
{if $category_footer}
</dl>
{/if}
{/categories}


{else if $k=="shopping"}
{sp_categories}
{if $category_header}
<dl>
<dd>カテゴリ</dd>
{/if}
<dd>
<div class="checkbox">
<label><input type="checkbox" name="{$k}[category_id][]" value="{$category['id']}" {if $user["auth"]["shopping"]["category_id"] && $category['id']|in_array:$user["auth"]["shopping"]["category_id"]}checked="checked"{/if}> {$category["denomination"]}</label></div></dd>
{if $category_footer}
</dl>
{/if}
{/sp_categories}
{/if}
{/if}
</td>
</tr>
{/if}
{/foreach}


</table>
<p><button class="btn btn-primary" type="submit" name="rewrite" value="保存">保存</button> <button class="btn btn-primary" type="submit" name="rewrited" value="保存して一覧に戻る">保存して一覧に戻る</button></p>
</form>
{/users}
{if $no_users}
<p class="note">ユーザーが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">ユーザーの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
