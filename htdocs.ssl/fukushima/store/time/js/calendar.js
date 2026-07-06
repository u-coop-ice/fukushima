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
  // ■ 改行変換（HTMLタグ保護）
  // ============================
  function nl2brSafe(str){
    if(!str) return "";

    const tags = [];

    const tmp = str.replace(/<[^>]+>/g, match=>{
      tags.push(match);
      return `___HTML_TAG_${tags.length-1}___`;
    });

    let replaced = tmp.replace(/\n/g,"<br>");

    replaced = replaced.replace(/___HTML_TAG_(\d+)___/g,(_,i)=>tags[i]);

    return replaced;
  }

  // ============================
  // ■ データ取得
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

    // ============================
    // ■ お知らせ
    // ============================
    if(res.info && res.info.length){
      infoBox.innerHTML = `
        <div class="info-box">
          ${res.info.map(text=>`
            <div class="info-item">${nl2brSafe(text)}</div>
          `).join("")}
        </div><br>
      `;
    }

    // ============================
    // ■ データ整理
    // ============================
    sheetData.forEach(item=>{

      if(!item || !item.date) return;

      const dateStr = item.date;
      hoursData[dateStr] = item;

      const d = new Date(dateStr);

      // ★ 0埋めキー（ズレ防止）
      const key = `${d.getFullYear()}-${("0"+d.getMonth()).slice(-2)}`;
      months[key] = true;

      // 今日表示
      if(dateStr === todayStr){

        const week = ["日","月","火","水","木","金","土"];

        todayBox.innerHTML = `
        <div class="today-box">
          <h4>本日の営業時間 ${today.getMonth()+1}/${today.getDate()} (${week[today.getDay()]})</h4>

          <div class="note">
            ${holidayData[dateStr] ? `<p class="holiday-name">${holidayData[dateStr]}</p>` : ""}
            ${item.note ? `<p>${nl2brSafe(item.note)}</p>` : ""}
          </div>

          ${shopKeys.map(k=>{
            const h = headers[k];
            return `
            <div class="today-row">
              <span class="time_label ${h.color}">
                ${(h.name || "").replace(/\n/g,"<br>")}
              </span>
              <span class="time">
                ${(item[k]||"").replace(/\n/g,"<br>")}
              </span>
            </div>
            `;
          }).join("")}

        </div>`;
      }

    });

    // ============================
    // ■ 月ソート（完全版）
    // ============================
    const sortedMonths = Object.keys(months).sort((a,b)=>{
      const [y1,m1] = a.split("-").map(Number);
      const [y2,m2] = b.split("-").map(Number);
      return y1 - y2 || m1 - m2;
    });

    // ============================
    // ■ カレンダー生成
    // ============================
    let tabHtml = "";
    const calFragment = document.createDocumentFragment();
    const listFragment = document.createDocumentFragment();

    sortedMonths.forEach(key=>{

      const [year,month] = key.split("-").map(Number);

      if(new Date(year,month) < new Date(today.getFullYear(),today.getMonth())){
        return;
      }

      const isCurrent = (year === today.getFullYear() && month === today.getMonth());

      const calId = `cal-${year}-${month}`;
      const listId = `list-${year}-${month}`;

      // タブ
      tabHtml += `
        <button class="tab-btn ${isCurrent ? "active":""}" data-target="${calId}">
          ${month+1}月
        </button>`;

      // ============================
      // カレンダー
      // ============================
      const calDiv = document.createElement("div");
      calDiv.className = "calendar-box";
      calDiv.id = calId;
      if(!isCurrent) calDiv.style.display="none";

      const firstDay = new Date(year,month,1);
      const lastDay = new Date(year,month+1,0);

      let html = `<h4>${month+1}月</h4><table class="calendar"><tr>
      <th class="red">日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th class="blue">土</th>
      </tr><tr>`;

      for(let i=0;i<firstDay.getDay();i++) html+="<td></td>";

      for(let d=1;d<=lastDay.getDate();d++){

        const dateObj = new Date(year,month,d);
        const dateStr = formatDate(dateObj);

        let cls="";
        if(hoursData[dateStr]?.holiday == "1" || holidayData[dateStr]) {
					cls="holiday";
				}
        else if(dateObj.getDay()===0) cls="sun";
        else if(dateObj.getDay()===6) cls="sat";

        if(dateStr === todayStr) cls+=" today";

        html += `<td class="${cls}"><div class="date">${d}</div>`;

        if(hoursData[dateStr]){
          html += `
          <div class="note">
            ${holidayData[dateStr] ? `<span class="holiday-name">${holidayData[dateStr]}</span><br>`:""}
            ${nl2brSafe(hoursData[dateStr].note || "")}
          </div>

          <table class="shop">
          ${shopKeys.map(k=>`
            <tr>
              <td><span class="time_label ${headers[k].color}">${headers[k].short}</span></td>
              <td>${(hoursData[dateStr][k]||"").replace(/\n/g,"<br>")}</td>
            </tr>
          `).join("")}
          </table>`;
        }

        html += "</td>";
        if(dateObj.getDay()===6) html+="</tr><tr>";
      }

      html += "</tr></table>";
      calDiv.innerHTML = html;
      calFragment.appendChild(calDiv);

      // ============================
      // リスト（スマホ）
      // ============================
      const listDiv = document.createElement("div");
      listDiv.className = "list-box";
      listDiv.id = listId;
      if(!isCurrent) listDiv.style.display="none";

      let listHtml = "<table>";

      Object.keys(hoursData).sort().forEach(dateStr=>{

        const d = new Date(dateStr);
        if(d.getFullYear()!==year || d.getMonth()!==month) return;

        let cls="";
        if(hoursData[dateStr]?.holiday == "1" || holidayData[dateStr]) {
					cls="holiday";
				}
        else if(d.getDay()===0) cls="sun";
        else if(d.getDay()===6) cls="sat";

        listHtml += `
        <tr class="${cls}">
          <th>${d.getDate()}（${"日月火水木金土"[d.getDay()]}）</th>
          <td>
            <p class="note">
              ${holidayData[dateStr] ? `<span class="holiday-name">${holidayData[dateStr]}</span><br>`:""}
              ${nl2brSafe(hoursData[dateStr].note || "")}
            </p>

            ${shopKeys.map(k=>`
              <div>
                <span>${(headers[k].name || "").replace(/\n/g,"<br>")}</span>
                <span class="event">${(hoursData[dateStr][k]||"").replace(/\n/g,"<br>")}</span>
              </div>
            `).join("")}
          </td>
        </tr>`;
      });

      listHtml += "</table>";
      listDiv.innerHTML = listHtml;
      listFragment.appendChild(listDiv);

    });

    tabBox.innerHTML = tabHtml;
    calendarView.appendChild(calFragment);
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

    document.getElementById("loading").style.display="none";

  })
  .catch(err=>{
    console.error(err);
    document.getElementById("loading").style.display="none";
  });

});