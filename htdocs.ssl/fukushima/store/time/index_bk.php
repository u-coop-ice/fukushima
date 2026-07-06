<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>
<link type="text/css" href="/css/print.css" rel="stylesheet" media="print" />
<link type="text/css" href="./css/time.css" rel="stylesheet" media="screen,print" />
<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">
    <h2>営業時間</h2>
    <div id="today-hours"></div>
    <div id="calendar-tabs"></div>
    <div id="calendar-view"></div>
    <div id="list-view"></div>
    <script>


const csvUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vQMoQofPHUVsCJxuXZfzkgEf7a4bhRDz87qjQeK7DlOPNmWJj843prCywa0JwSNTQ/pub?gid=1385257430&single=true&output=csv";



	
	function formatDate(date) {
  const y = date.getFullYear();
  const m = ("0" + (date.getMonth() + 1)).slice(-2);
  const d = ("0" + date.getDate()).slice(-2);
  return `${y}-${m}-${d}`;
}


fetch(csvUrl)
  .then(response => response.text())
  .then(data => {

    const rows = data.trim().split(/\r?\n/).map(row => row.split(","));

    function normalizeDate(str) {
      const parts = str.trim().replace(/\//g, "-").split("-");
      const y = parts[0];
      const m = ("0" + parts[1]).slice(-2);
      const d = ("0" + parts[2]).slice(-2);
      return `${y}-${m}-${d}`;
    }



    const today = formatDate(new Date());

    rows.forEach((row, index) => {
      if (index === 0) return;
      if (!row[0]) return;

      const sheetDate = normalizeDate(row[0]);

      if (sheetDate === today) {

        document.getElementById("today-hours").innerHTML = `
          <div class="today-box">
            <h4>本日の営業時間</h4>
						<br>
            <p><span class="time_label label-blue">購買</span> ${row[1] || ""}</p>
            <p><span class="time_label label-red">カウンター</span> ${row[2] || ""}</p>
            <p><span class="time_label label-green">Dining ReaF</span> ${row[3] || ""}</p>
            <p><span class="time_label label-orange">Quick Lunchグリーン</span> ${row[4] || ""}</p>
            <p><span class="time_label label-purple">本部・新入生サポートセンター</span> ${row[5] || ""}</p>
            ${row[6] || `<p class="note">${row[6]}</p>` || ""}
          </div>
        `;
      }
    });
  });
	
	
	
fetch(csvUrl)
.then(res => res.text())
.then(data => {

const rows = data.trim().split(/\r?\n/).map(r => r.split(","));

const hoursData = {};
const months = {};

// 日付フォーマット
function formatDate(date){
const y = date.getFullYear();
const m = ("0"+(date.getMonth()+1)).slice(-2);
const d = ("0"+date.getDate()).slice(-2);
return `${y}-${m}-${d}`;
}

// シート日付を正規化
function normalizeDate(str){

const parts = str.trim().replace(/\//g,"-").split("-");
const y = parts[0];
const m = ("0"+parts[1]).slice(-2);
const d = ("0"+parts[2]).slice(-2);

return `${y}-${m}-${d}`;

}

// =================
// データ変換
// =================

rows.forEach((row,i)=>{

if(i===0) return;
if(!row[0]) return;

const dateStr = normalizeDate(row[0]);

hoursData[dateStr] = {

shop1:row[1],
shop2:row[2],
shop3:row[3],
shop4:row[4],
shop5:row[5],
note:row[6]

};

const date = new Date(dateStr);
const key = `${date.getFullYear()}-${date.getMonth()}`;

months[key] = true;

});

// =================
// カレンダー生成
// =================

const today = new Date();

let tabHtml = "";
let calendarHtml = "";

Object.keys(months).sort().forEach((key,i)=>{

const parts = key.split("-");
const year = parseInt(parts[0]);
const month = parseInt(parts[1]);

// 過去月は表示しない
if(new Date(year,month) < new Date(today.getFullYear(),today.getMonth())){
return;
}

const displayMonth = month + 1;

const firstDay = new Date(year,month,1);
const lastDay = new Date(year,month+1,0);

const calId = `cal-${year}-${month}`;

tabHtml += `<button class="tab-btn" data-target="${calId}">${displayMonth}月</button>`;

calendarHtml += `
<div class="calendar-box" id="${calId}">
<h4>${displayMonth}月</h4>
<table class="calendar">
<tr>
<th class="red">日</th>
<th>月</th>
<th>火</th>
<th>水</th>
<th>木</th>
<th>金</th>
<th class="blue">土</th>
</tr>
<tr>
`;

for(let j=0;j<firstDay.getDay();j++){
calendarHtml += "<td></td>";
}

for(let day=1; day<=lastDay.getDate(); day++){

const dateObj = new Date(year,month,day);
const dateStr = formatDate(dateObj);

const isToday =
day === today.getDate() &&
month === today.getMonth() &&
year === today.getFullYear();

calendarHtml += `<td class="${isToday?'today':''}">
<div class="date">${day}</div>
`;

if(hoursData[dateStr]){

calendarHtml += `
<div class="shop bold em11">${hoursData[dateStr].note||""}</div>

<div class="shop"><span class="time_label label-blue">購</span>${hoursData[dateStr].shop1||""}</div>
<div class="shop"><span class="time_label label-red">カ</span>${hoursData[dateStr].shop2||""}</div>
<div class="shop"><span class="time_label label-green">D</span>${hoursData[dateStr].shop3||""}</div>
<div class="shop"><span class="time_label label-orange">Q</span>${hoursData[dateStr].shop4||""}</div>
<div class="shop"><span class="time_label label-purple">本</span>${hoursData[dateStr].shop5||""}</div>

`;

}

calendarHtml += "</td>";

if(dateObj.getDay() === 6){
calendarHtml += "</tr><tr>";
}

}

calendarHtml += "</tr></table></div>";

});

// =================
// HTML反映
// =================

document.getElementById("calendar-tabs").innerHTML = tabHtml;
document.getElementById("calendar-view").innerHTML = calendarHtml;

// =================
// タブ切替
// =================

document.querySelectorAll(".tab-btn").forEach((btn,i)=>{

btn.addEventListener("click",()=>{

document.querySelectorAll(".calendar-box").forEach(el=>{
el.style.display="none";
});

document.getElementById(btn.dataset.target).style.display="block";

});

});

document.querySelectorAll(".calendar-box").forEach((el,i)=>{
el.style.display = i===0 ? "block":"none";
});

// =================
// スマホ縦リスト
// =================

let listHtml = "";

listHtml += `
<table class="tblFull">

`;

Object.keys(hoursData).sort().forEach(dateStr=>{

const dateObj = new Date(dateStr);

if(dateObj < new Date(today.getFullYear(),today.getMonth(),today.getDate())){
return;
}

listHtml += `
<tr>
<th>
<div class="day-number">
${dateObj.getDate()}（${"日月火水木金土"[dateObj.getDay()]}）
</div>
</th>

<td>
<p class="shop bold em11">${hoursData[dateStr].note||""}</p>
          購買：<div class="event">${hoursData[dateStr].shop1}</div><br>
					カウンター：<div class="event">${hoursData[dateStr].shop2}</div><br>
					Dining ReaF：<div class="event">${hoursData[dateStr].shop3}</div><br>
					Quick Lunchグリーン：<div class="event">${hoursData[dateStr].shop4}</div><br>
					本部・新入生サポートセンター：<div class="event">${hoursData[dateStr].shop5}</div>
					</td>
<tr>

`;

});

listHtml += `

</table>
`;

document.getElementById("list-view").innerHTML = listHtml;

});


	

	

	</script>
    <style>
	
	.today-box {
  background:#eef4ff;
  padding:20px;
  border-radius:10px;
  margin-bottom:30px;
}

.today-box h4 {
  font-size:18px;
}

.today-box p {
  font-size:16px;
  font-weight:bold;
}

.note {
  color:#c00;
  font-size:14px;
}

.calendar {
  width:100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.calendar th{
  background-color: #F5F5F5;
	 border:1px solid #ddd;
  vertical-align: top;
  padding:8px;
  height:40px;
  font-size:14px;
}


.calendar td {
  border:1px solid #ddd;
  vertical-align: top;
  padding:8px;
  height:100px;
  font-size:14px;
}

.calendar .date {
  font-weight:bold;
  margin-bottom:5px;
}

.calendar .today {
  background:#eef4ff;
}

.calendar .shop {
  font-size:12px;
}

.calendar .cafeteria {
  font-size:12px;
  color:#555;
}

/* スマホ */
@media (max-width:768px){
  .calendar th,
  .calendar td {
    font-size:11px;
    padding:4px;
    height:auto;
  }
}

/* デフォルト：PCはカレンダー表示 */
#list-view {
  display:none;
}

/* スマホ */
@media (max-width:768px){

  #calendar-view {
    display:none;
  }

  #list-view {
    display:block;
  }
	

  .day-block {
    border-bottom:1px solid #ddd;
    padding:15px 10px;
  }

  .day-number {
    font-size:18px;
    font-weight:bold;
    margin-bottom:10px;
  }

  .event {
    display:inline-block;
    border-radius:6px;
    margin-bottom:8px;
    font-size:14px;
  }

  .blue_time { background:#7ec0d8; }
  .orange_time { background:#f6b26b; }
}

.time_label {
font-size: 0.8em;
display: inline;
padding: .2em .6em .3em;
font-weight: 500;
line-height: 1;
color: #fff;
text-align: center;
white-space: normal;
vertical-align: baseline;
border-radius: .25em;
}

.label-blue {
  background-color: #3498db;
}
.label-red {
  background-color: #DB3469;
}

.label-green {
  background-color: #4FB454;
}

.label-orange {
  background-color: #ECA151;
}

.label-purple {
  background-color: #C951EC;
}

.label-yellow {
  background-color: #ECD051;
}

.label-pink {
  background-color: #FF56DE;
}

.calendar-box{display:none}

.tab-btn{
padding:6px 12px;
margin-right:5px;
cursor:pointer;
}

.today{
background:#fff4c4;
}
	
	</style>
    <p><a class="btn btn-primary" href="/store/"><i class="fa fa-fw fa-reply"></i>店舗トップに戻る</a></p>
</div>
<!-- main終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>
