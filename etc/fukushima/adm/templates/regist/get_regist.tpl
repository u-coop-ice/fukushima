{assign var="init_pagetitle" value="登録情報"}

{include file='preview_header.tpl'}

<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">登録基本情報</th></tr>

{include file="regist_username.tpl"}

</table>


<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">大学・受験内容</th></tr>
{include file='regist_year.tpl'}
{include file='regist_univ.tpl'}
{*include file='regist_exam.tpl'*}
{include file='regist_dept.tpl'}
{*include file='regist_examnumber.tpl'*}
{include file='regist_union.tpl'}
</table>
{include file='preview_footer.tpl'}
