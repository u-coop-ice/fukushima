{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}
{include file='header.tpl'}

<h3>山形の味覚を全国にお届けします！</h3>

<div class="center"><img src="./images/perorin.png" width="360" height="60" alt="おいしい山形・愛称「ペロリン」" /></div>

<div style="margin:10px">
<p class="ind">山形県は、秀麗な山々に囲まれ、最上川や緑豊かな田園など美しい自然に恵まれています。
県を南北に走る出羽山地の東側にあたる内陸地方は、奥羽山脈に挟まれた盆地になっており、夏の暑さ冬の寒さが厳しく、昼夜の気温較差が大きく、また一方で梅雨時の長雨が少ないという特徴も併せ持ちます。</p>
<p class="ind">この気候により落葉果樹栽培の好適地を作り、サクランボ、ラ・フランスを代表とする果樹王国となっています。また出羽山地の西側にあたる庄内地方は、海洋性気候で内陸に比べ平均気温も高く多雨・多照の気候的特質は、この地方の稲作を支えてきました。</p>

<p class="ind">山形県には、四季折々各地方毎に育まれてきた独自の「食文化」があり、全国的に誇ることができる代表的な産物もたくさんあります。<strong class="green">山形大学生協の「CO-OPのふるさと便」</strong>は、学生教職員をはじめ、全国各地から山形大学に入学された学生のご家族の皆さまへ、季節毎のフルーツを主とした山形県の名産品をご案内しております。</p>
<p class="ind">またご卒業や進学・転勤等で山形県を離れ、他都道府県で暮らす家族、友人、知人の方に「ふるさと“山形”の旬の味覚」をお届けする企画でもあります。</p>
<p class="ind">長年地域生協とともに、実績と信頼を積み重ねている産地・生産者から直接先方にお届けしています。</p>

<p class="ind">山形大学にご入学されたこの機会に、四季折々に「山形のうまいもの」を愛でいただければ幸いに存じます。</p>


<p class="note">ご利用は組合員に限らせて頂きます。また、大学生協が組合員とそのご家族以外の皆さまに商品提供することは、一定の範囲に限定されております。誠に申し訳ございませんが、下記までお問い合わせください。<br />
<span>
山形大学生活協同組合　理事会室産直ふるさと便係　０２３−６４１−４３８０<br />
平日 10：00〜17：00</span>
</p>

</div>




<div class="center">
<img src="./images/top.png" width="600" height="300" alt="おいしい山形" />
</div>


{* フッター部分の組み込み *}

{if !$login}
{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-455544-2");
pageTracker._initData();
pageTracker._trackPageview();
</script>
{/literal}
{/if}

{include file='footer.tpl'}
