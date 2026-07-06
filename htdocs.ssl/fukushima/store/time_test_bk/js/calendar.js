document.addEventListener("DOMContentLoaded", function () {

  const apiUrl = "./include/data.php";

  const todayBox = document.getElementById("today-hours");
  const tabBox = document.getElementById("calendar-tabs");
  const calendarView = document.getElementById("calendar-view");
  const listView = document.getElementById("list-view");
	const infoBox = document.getElementById("info-box");

  // ============================
  // ■ 日付フォーマット
  // ============================
  function formatDate(date){
    const y = date.getFullYear();
    const m = ("0"+(date.getMonth()+1)).slice(-2);
    const d = ("0"+date.getDate()).slice(-2);
    return `${y}-${m}-${d}`;
  }

  // ============================
  // ■ データ取得（営業時間 + 祝日API）
  // ============================
  Promise.all([
    fetch(apiUrl,{cache:"no-store"}).then(res=>res.json()),
    fetch("https://holidays-jp.github.io/api/v1/date.json").then(res=>res.json())
  ])
  .then(([res, holidayData])=>{

    const headers = res.headers || {};
    const sheetData = res.data || [];
    const shopKeys = Object.keys(headers);

    const hoursData = {};
    const months = {};

    const today = new Date();
    const todayStr = formatDate(today);
		
// =============================
// ■ 共通お知らせ表示（HTML対応）
// =============================
function nl2brSafe(str){
  if(!str) return "";

  const tags = [];

  // ① HTMLタグを退避
  const tmp = str.replace(/<[^>]+>/g, match => {
    tags.push(match);
    return `___HTML_TAG_${tags.length-1}___`;
  });

  // ② 改行を変換
  let replaced = tmp.replace(/\n/g, "<br>");

  // ③ タグを戻す
  replaced = replaced.replace(/___HTML_TAG_(\d+)___/g, (_,i)=>{
    return tags[i];
  });

  return replaced;
}

if(res.info && res.info.length){

infoBox.innerHTML = `
  <div class="info-box">
    ${res.info.map(text => `
      <div class="info-item">
        ${nl2brSafe(text)}
      </div>
			<br>
    `).join("")}
  </div>
`;

}
		

    // ============================
    // ■ データ整理
    // ============================
    sheetData.forEach(item=>{

      if(!item.date) return;

      const dateStr = item.date;

      hoursData[dateStr] = item;

      const d = new Date(dateStr);
      months[`${d.getFullYear()}-${d.getMonth()}`] = true;

      // ============================
      // ■ 今日表示
      // ============================
      if(dateStr === todayStr){

        const week = ["日","月","火","水","木","金","土"];

        todayBox.innerHTML = `
        <div class="today-box">
          <h4>本日の営業時間 ${today.getMonth()+1}/${today.getDate()} (${week[today.getDay()]})</h4>
					<div class="note">

          ${holidayData[dateStr] ? `<p class="holiday-name">${holidayData[dateStr]}</p>` : ""}

          ${item.note ? `<p class="note">${item.note.replace(/\n/g,"<br>")}</p>` : ""}
					</div>

          ${shopKeys.map(k=>{
            const h = headers[k];
            return `
            <div class="today-row">
              <span class="time_label ${h.color}">${(h.name).replace(/\n/g, "<br>")}</span>
              <span class="time">${(item[k]||"").replace(/\n/g,"<br>")}</span>
            </div>
            `;
          }).join("")}

        </div>
        `;
      }

    });
		


    // ============================
    // ■ カレンダー生成
    // ============================

    let tabHtml = "";
    const fragment = document.createDocumentFragment();

    Object.keys(months).sort().forEach(key=>{

      const [year,month] = key.split("-").map(Number);

      if(new Date(year,month) < new Date(today.getFullYear(),today.getMonth())) return;

      const calId = `cal-${year}-${month}`;
      tabHtml += `<button class="tab-btn" data-target="${calId}">${month+1}月</button>`;

      const div = document.createElement("div");
      div.className = "calendar-box";
      div.id = calId;

      const firstDay = new Date(year,month,1);
      const lastDay = new Date(year,month+1,0);

      let html = `
      <h4>${month+1}月</h4>
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

      for(let i=0;i<firstDay.getDay();i++) html += "<td></td>";

      for(let day=1; day<=lastDay.getDate(); day++){

        const d = new Date(year,month,day);
        const dateStr = formatDate(d);

        let cls = "";

        // ★ 祝日優先
        if(holidayData[dateStr]){
          cls = "holiday";
        }else if(d.getDay()===0){
          cls = "sun";
        }else if(d.getDay()===6){
          cls = "sat";
        }

        if(dateStr === todayStr){
          cls += " today";
        }

        html += `<td class="${cls}">
        <div class="date">${day}</div>
				
				<div class="note">

        ${holidayData[dateStr] ? `<div class="holiday-name">${holidayData[dateStr]}</div>` : ""}
				</div>
        `;

        if(hoursData[dateStr]){

          html += `
          <div class="note">${(hoursData[dateStr].note||"").replace(/\n/g,"<br>")}</div>

          <table class="shop">
          ${shopKeys.map(k=>{
            const h = headers[k];
            return `
            <tr title="${headers[k]?.name || ""}">
              <td><span class="time_label ${h.color}">${h.short}</span></td>
              <td>${(hoursData[dateStr][k]||"").replace(/\n/g,"<br>")}</td>
            </tr>
            `;
          }).join("")}
          </table>
          `;
        }

        html += "</td>";

        if(d.getDay()===6) html += "</tr><tr>";
      }

      html += "</tr></table>";

      div.innerHTML = html;
      fragment.appendChild(div);
    });

    tabBox.innerHTML = tabHtml;
    calendarView.appendChild(fragment);

    // ============================
    // ■ スマホリスト
    // ============================

    const listFragment = document.createDocumentFragment();

    Object.keys(months).sort().forEach(key=>{

      const [year,month] = key.split("-").map(Number);

      if(new Date(year,month) < new Date(today.getFullYear(),today.getMonth())) return;

      const listId = `list-${year}-${month}`;

      const div = document.createElement("div");
      div.className = "list-box";
      div.id = listId;

      let html = "<table>";

      Object.keys(hoursData).sort().forEach(dateStr=>{

        const d = new Date(dateStr);
        if(d.getFullYear()!==year || d.getMonth()!==month) return;

        let cls = "";
        if(holidayData[dateStr]) cls="holiday";
        else if(d.getDay()===0) cls="sun";
        else if(d.getDay()===6) cls="sat";

        html += `
        <tr class="${cls}">
          <th>${d.getDate()}（${"日月火水木金土"[d.getDay()]}）</th>
          <td>
					
					<p class="note">

          ${holidayData[dateStr] ? `<span class="holiday-name">${holidayData[dateStr]}</span>` : ""}

          <p>${(hoursData[dateStr].note||"").replace(/\n/g,"<br>")}</p>
					</p>

          ${shopKeys.map(k=>{
            return `
            <div>
              <span>${(headers[k].name).replace(/\n/g, "<br>")}</span>
              <span class="event">${(hoursData[dateStr][k]||"").replace(/\n/g,"<br>")}</span>
            </div>
            `;
          }).join("")}

          </td>
        </tr>
        `;
      });

      html += "</table>";
      div.innerHTML = html;
      listFragment.appendChild(div);
    });

    listView.appendChild(listFragment);

    // ============================
    // ■ タブ切替
    // ============================

    document.querySelectorAll(".tab-btn").forEach(btn=>{
      btn.onclick = ()=>{
        document.querySelectorAll(".tab-btn").forEach(b=>b.classList.remove("active"));
        btn.classList.add("active");

        document.querySelectorAll(".calendar-box,.list-box").forEach(el=>{
          el.style.display="none";
        });

        document.getElementById(btn.dataset.target).style.display="block";

        const list = document.getElementById(btn.dataset.target.replace("cal","list"));
        if(list) list.style.display="block";
      };
    });

    // ============================
    // ■ 初期表示
    // ============================

    document.querySelectorAll(".calendar-box,.list-box").forEach(el=>{
      el.style.display="none";
    });

    const firstCal = document.querySelector(".calendar-box");
    const firstList = document.querySelector(".list-box");
    const firstTab = document.querySelector(".tab-btn");

    if(firstCal) firstCal.style.display="block";
    if(firstList) firstList.style.display="block";
    if(firstTab) firstTab.classList.add("active");

    document.getElementById("loading").style.display="none";

  })
  .catch(err=>{
    console.error(err);
    document.getElementById("loading").style.display="none";
  });

});