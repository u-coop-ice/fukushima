{assign var='page_title' value='サインイン'}
{include file='header.tpl'}


<p class="alert alert-danger">セキュリティ強化のための認証システムアプリ（Google Authenticatorなど）を利用した、管理画面の2段階認証の対応が可能です。大学生協内でご検討ください。導入についてのスケジュール感、不明点などについても、東北地区HPG城田までお問い合わせください。（2025.11.06）</p>


<div class="login">
<div class="login-inner">
<div class="center">
<h5>
<div class="logo-icon"><i class="fa fa-cogs"></i></div>{$page_title}</h5>


<form method="post" action="{$self}{$query}">

<div class="form-group">
<label>
<input type="text" name="username" id="username" class="form-control input-lg" placeholder="管理ユーザー名" value="{$post_username}"  />
</label>
</div>

<div class="form-group">
<label>
<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" />
</label>
</div>


<div class="row">
<div class="col-xs-12 col-sm-12">
<input class="btn btn-success btn-block" type="submit" name="login" value="サインイン" />
</div>
</div>
</form>


</div>


</div>
</div>

{include file='footer.tpl'}
