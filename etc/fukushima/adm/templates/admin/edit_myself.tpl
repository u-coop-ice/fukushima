{capture assign="header_insert"}
{literal}


<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/adm/master/js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
//<[!CDATA[

$(function(){
$("#formID").validationEngine({
  'promptPosition':'inline'
  ,'ajaxFormValidationMethod':'post'
});
});



$(function(){
  $("#reset_myself_secret").on('click', function(){
  let user_id=$(this).data('user_id');
  if (confirm('2段階認証をリセットしてもよろしいですか')){
    $.post('./?mode=reset_myself_secret',{'user_id':user_id})
    .done(function(e){
      console.log(e);
      if (e.error){
        alert(e.error);
        return false;
      }
      location.reload();
    })
    .fail(function(e){
      alert('2段階認証をリセットに失敗しました');
    });
  }
  });
});



//]]>
</script>



{/literal}
{/capture}

{capture assign="page_title"}
管理ユーザーの編集
{/capture}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
<div id="msg" class="note none"></div>
{if $saved}
<div id="msg" class="alert alert-success">ユーザー権限を保存しました。</div>
{/if}

<form id="formID" method="post" action="{$self}?mode=save_myself">
{if $user['id']}
<input type="hidden" name="id" value="{$user['id']}" />
{/if}
<table class="inputForm" cellspacing="0">
<col style="width:30%;" />
<tr>
<th>管理ユーザーアカウント</th>
<td>{$auth_username} <span class="badge badge-primary">IDの変更はできません</span></td>
</tr>
<tr>
<th>パスワード</th>
<td><div><button type="button" class="btn btn-primary" data-user_id={$user['id']} id="change_passowrd"><i class="fa fa-lock fa-fw"></i>パスワードの変更</a></div></td>
</tr>

<tr>
<th>メールアドレス<span class="badge badge-danger">必須</span></th>
<td><input type="text" id="email" name="email" value="{$user['email']}" class="form-control validate[required]" placeholder="（管理ユーザーメールアドレス）">
</td>
</tr>

<tr>
<th>2段階認証</th>
<td>{if $user['secret']}<i class="fa fa-user-shield"></i>設定済 <button id="reset_myself_secret" class="btn btn-primary btn-sm" type="button" data-user_id="{$user['id']}"><i class="fa fa-trash-alt"></i> 2段階認証のリセット</button><p class="form-control-plaintext text-muted">2段階認証の設定をリセットすることで、再度サインイン時にQRコードが表示されるようになります。</p>{else}未設定{/if}</td>
</tr>

</table>
<p><button class="btn btn-primary" type="submit" name="rewrite" value="設定を変更する"><i class="fa fa-fw fa-check"></i>設定を変更する</button></p>
</form>


{literal}
<script type="text/javascript">
//<[!CDATA[

$(function(){
  $('#change_passowrd').on('click',function(){

  var href = "./?mode=edit_password";
  var user_id = $(this).data("user_id");
  href += "&user_id="+user_id;

  $("#editModal").find(".modal-body").load(href);
    $("#editModal").modal('show');
  });


});

//]]>
</script>
{/literal}

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-body"></div>
</div>
</div>
</div>




{if $no_users}
<p class="alert alert-info">管理ユーザーが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">管理ユーザーの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
