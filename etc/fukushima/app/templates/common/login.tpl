{assign var='page_title' value='サインイン'}
{include file='header.tpl'}

{if $msg_app}<div class="contact">{$msg_app}</div>{/if}

{*
<div class="login">
<div class="login-inner">

<form method="post" action="{$self}{if $query}?{$query}{/if}">
{if $msg}<p class="error">{$msg}</p>{/if}

<div class="form-group">
<label>ユーザーID</label>
<input type="text" required id="username" name="username" class="form-control input-lg" {if $post['username']}value="{$post['username']}"{/if}  placeholder="（メールアドレス）" />
</div>
<div class="form-group">
<label>パスワード</label>
<input type="password" required id="password" name="password" class="form-control input-lg" placeholder="（パスワード）" />
</div>
<div class="checkbox">
<label><input data-role="none" type="checkbox" name="rememberme" value="1" {if $post['rememberme']}checked="checked"{/if}><span class="normal black"> 自動的にサインイン</span></label>
</div>

<p class=""><input class="btn btn-success btn-block" type="submit" value="サインイン" /></p>
<p><a href="{$init_url}app/regist/?mode=remind">パスワードをお忘れの方<i class="fa fa-fw fa-chevron-right"></i></a></p>

<p>

<a class="btn btn-info btn-block" href="{$init_url}app/regist/{if $smarty.const.COMPONENT}?reffer={$smarty.const.COMPONENT}{if $smarty.const.PART}&part={$smarty.const.PART}{/if}{if $category_ic}&cd={$category_ic}{/if}{if $md}&md={$md}{/if}{/if}">新規ユーザー登録<i class="fa fa-fw fa-chevron-right"></i></a>

</form>



</div>
</div>
*}

<div class="contact">
<h5 class="">ユーザー登録済みの方はサインインしてください。新規登録もこちらから手続きできます。</h5>
<p><a class="btn btn-success btn-block" id="login" href="#form_signin">サインイン／新規登録</a></p>
</div>

{include file='footer.tpl'}
