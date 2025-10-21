{assign var='page_title' value=$category["denomination"]}


{include file='header.tpl'}

{if $category["denomination"]}<h4>{$category["denomination"]}</h4>{/if}
<p class="pad_l">左メニューから選択してください。</p>

{include file='footer.tpl'}

