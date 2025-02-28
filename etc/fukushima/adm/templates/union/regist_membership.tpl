<tr><th>組合員番号</th>
<td>{$regist['membership']|default:"未入力"}
{if $idms_requestNo}
<p>組合員マスタ {if $idms_isExist}<span class="tag green min">OK</span>
{if $idms_kumiaiKbn} {$idms_kumiaiKbn}{/if}
{else if $idms_errormsg}<span class="tag min red">{$idms_errormsg}</span>{/if}
</p>
{/if}

</td>
</tr>
