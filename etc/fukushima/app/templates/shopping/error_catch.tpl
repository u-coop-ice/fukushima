{include file='header.tpl'}

{if $card_err}
<div class="alert alert-danger">
<h4 class="mt-0">クレジットカードの決済に失敗しました</h4>
{$card_err}
カード情報を確認しお手数ですが、もう一度お申込み手続きにお進みください。
</div>
{/if}


<div class="row">
<div class="col-sm-8"><p><a class="btn btn-primary btn-block" href="{$self}"><i class="fa fa-fw fa-reply"></i>トップページに戻る</a></p>
</div></div>


{include file='footer.tpl'}
