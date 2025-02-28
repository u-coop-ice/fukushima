{include file='regist_partition1.tpl'}
{include file='regist_membership.tpl'}
{include file='regist_name.tpl'}
{include file='regist_sex.tpl'}
{include file='regist_age.tpl'}
{include file='regist_mobilephone.tpl'}
{include file='regist_student_email.tpl'}
{include file='regist_student_email_mobile.tpl'}
{include file='regist_new_add.tpl'}
{include file='regist_partition2.tpl'}
{include file='regist_address.tpl'}
{include file='regist_phonenumber.tpl'}

{if ($regist['parentnamef'])}
{include file='regist_partition2.tpl'}
{include file='regist_parent_name.tpl'}
{include file='regist_parent_sex.tpl'}
{include file='regist_parent_email.tpl'}
{include file='regist_parent_email_mobile.tpl'}
{include file='regist_parent_mobile.tpl'}
{include file='regist_parent_com.tpl'}
{include file='regist_parent_com_phone.tpl'}
{/if}
