{include file='header.tpl'}
<p class="alert alert-success">{$msg}</p>

<p>下のリンクから{$init_sitename}にアクセスください。</p>
<br>

<form name="login" method="post" action="{$init_url}" data-ajax="false">
<input type="hidden" name="username" id="username" value="{$post['username']}" />
<input type="hidden" name="password" id="password" value="{$post['password']}" />
<button class="btn btn-primary" type="submit" name="login" value="{$init_coopname}へサインインする">{$init_coopname}へサインインする</button>
</form>


{include file='footer.tpl'}
