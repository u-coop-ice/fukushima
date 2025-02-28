{include file='header.tpl'}
<p class="alert alert-success">パスワードの変更が完了しました。</p>

<div class="contact">
<h4 class="top">サインイン</h4>
<form name="login" method="post" action="{$init_url}">
<dl id="formLogin">
<dt><input class="form-control input-lg" type="email" name="username" placeholder="ユーザーID（登録時のE-mailアドレス）" size="50" value="{$post['username']}" /></dt>
<dt><input class="form-control input-lg" type="password" name="password" placeholder="パスワード" /></dt>
<dt><button class="btn btn-primary" type="submit" value="サインイン" >サインイン</button></dt>
</dl>
<div class="checkbox"><label><input type="checkbox" id="rememberme" name="rememberme" value="1" {if $post['rememberme']}checked="checked"{/if} /> サインインしたままにする</label>
</div>

</form>
</div>


{include file='footer.tpl'}
