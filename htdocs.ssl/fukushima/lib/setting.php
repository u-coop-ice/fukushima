<?php
if ($is_login) {
	?>
<p class="welcome_username"><a href="/app/user/?mode=show_regist"><i class="fa fa-fw fa-user"></i><?php echo $auth_username; ?></a></p>

<li class="ui-user navy"><a id="user_toggle" href="#"><i class="fa fa-fw fa-bars"></i>ユーザーページ</a>
<ul>
<div class="arrow"></div>
<li><a href="/app/user/?mode=show_regist">登録情報の確認・編集</a></li>
<li><a href="/app/user/?mode=list_app">お申込み内容の確認</a></li>
<li><a href="/app/user/?mode=list_mail"><?php echo (COOPNAME); ?>との連絡<?php if ($app_add['ct']) {echo ('<span class="badge">' . $app_add['ct'] . '</span>');}
	?></a></li>
<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?signout=1">サインアウト</a></li>
</ul>
</li>
<?php
} else {
	?>

<li class="ui-user navy"><a id="login" href="#form_signin"><i class="fa fa-sign-in"></i> サインイン（新規登録）</a></li>

<?php
}
?>
