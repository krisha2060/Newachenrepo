   
      document.addEventListener('DOMContentLoaded',function(){
        const sw=document.querySelector('.sidebar-wrapper');
        if(sw&&OverlayScrollbarsGlobal?.OverlayScrollbars)
          OverlayScrollbarsGlobal.OverlayScrollbars(sw,{scrollbars:{theme:'os-theme-light',autoHide:'leave',clickScroll:true}});
      });

      const today=new Date();
      const MONTHS=['January','February','March','April','May','June','July','August','September','October','November','December'];
      let curYear=today.getFullYear(),curMonth=today.getMonth();

      // amountRaw = numeric value in Rs (used for stats)
      //type=package type
    //   const bookings=[
    //     {id:'BK-0001',client:'Priya Sharma',email:'priya@example.com',initials:'PS',color:'#7c3aed',type:'Package 1',date:'2026-01-05',time:'6:00 PM - 11:00 PM',guests:150,venue:'Patan Durbar Hall',amount:'Rs 85,000',amountRaw:85000,status:'Confirmed',contact:'+977-9801234567',bookedOn:'2026-01-12',notes:'Vegetarian only. 2 extra tables near entrance. White & gold floral theme.',menu:['Sel Roti','Chatamari','Buff Choila','Wo','Aloo Tama','Yomari','Homemade Wine','Masala Tea'],timeline:[{t:'Jan 12',e:'Booking submitted'},{t:'Jan 14',e:'Deposit received (Rs 20,000)'},{t:'Jan 20',e:'Menu finalized'},{t:'Jan 25',e:'Confirmed by admin'}]},
    //     {id:'BK-0002',client:'Rajesh Thapa',email:'rajesh@email.com',initials:'RT',color:'#0891b2',type:'Package 4',date:'2026-02-05',time:'12:00 PM - 3:00 PM',guests:60,venue:'Kathmandu Business Hub',amount:'Rs 42,000',amountRaw:42000,status:'Confirmed',contact:'+977-9845678901',bookedOn:'2026-01-18',notes:'Gluten-free options for 5 guests. Corporate logo on napkins. AV setup required.',menu:['Momo','Thukpa','Spring Rolls','Fried Rice','Juice','Coffee'],timeline:[{t:'Jan 18',e:'Inquiry received'},{t:'Jan 19',e:'Quotation sent'},{t:'Jan 21',e:'Confirmed & deposit paid'}]},
    //     {id:'BK-0003',client:'Sunita Gurung',email:'sunita@mail.com',initials:'SG',color:'#be185d',type:'Package 4',date:'2026-02-12',time:'5:00 PM - 9:00 PM',guests:45,venue:'Nagarkot View Resort',amount:'Rs 35,000',amountRaw:35000,status:'Pending',contact:'+977-9812345678',bookedOn:'2026-01-22',notes:'Surprise party. Coordinate with host only. Custom cake preferred.',menu:['Sekuwa','Aila','Gundruk Soup','Beaten Rice','Dessert Platter'],timeline:[{t:'Jan 22',e:'Booking submitted'},{t:'Jan 23',e:'Under review'}]},
    //     {id:'BK-0004',client:'Binod Maharjan',email:'binod@newa.com',initials:'BM',color:'#d97706',type:'Newa Feast (Samay Baji)',date:'2026-02-18',time:'11:00 AM - 2:00 PM',guests:80,venue:'Bhaktapur Community Hall',amount:'Rs 56,000',amountRaw:56000,status:'Confirmed',contact:'+977-9856789012',bookedOn:'2026-01-10',notes:'Full traditional Newa menu. Live dhime music by client. Setup by 9 AM.',menu:['Samay Baji','Buff Choila','Wo','Aloo Achar','Yomari','Homemade Wine','Chaku'],timeline:[{t:'Jan 10',e:'Booking submitted'},{t:'Jan 12',e:'Full payment received'},{t:'Jan 15',e:'Menu confirmed'},{t:'Jan 30',e:'Venue visited'}]},
    //     {id:'BK-0005',client:'Anita Shrestha',email:'anita@web.com',initials:'AS',color:'#059669',type:'Package 1',date:'2026-02-22',time:'2:00 PM - 6:00 PM',guests:25,venue:'Garden Pavilion, Lalitpur',amount:'Rs 18,500',amountRaw:18500,status:'Pending',contact:'+977-9867890123',bookedOn:'2026-01-25',notes:'Pink themed setup. Finger foods only. Flowers from Kalimati market.',menu:['Sandwiches','Bruschetta','Mini Momo','Fruit Platter','Mocktails'],timeline:[{t:'Jan 25',e:'Booking submitted'},{t:'Jan 26',e:'Awaiting deposit'}]},
    //     {id:'BK-0006',client:'Kumar Tamang',email:'kumar@biz.com',initials:'KT',color:'#7c3aed',type:'Package 2',date:'2026-02-26',time:'7:00 PM - 10:00 PM',guests:120,venue:'Hyatt Regency Ballroom',amount:'Rs 95,000',amountRaw:95000,status:'Confirmed',contact:'+977-9878901234',bookedOn:'2026-01-15',notes:'High-end cocktail reception. Branded napkins. Media team present.',menu:['Canapes','Grilled Skewers','Pasta Station','Cheese Board','Open Bar'],timeline:[{t:'Jan 15',e:'Inquiry & quotation'},{t:'Jan 18',e:'Contract signed'},{t:'Jan 22',e:'Advance paid'}]},
    //     {id:'BK-0007',client:'Sita Rai',email:'sita@home.com',initials:'SR',color:'#dc2626',type:'Package 1',date:'2026-02-10',time:'9:00 AM - 1:00 PM',guests:200,venue:'Pashupatinath Area',amount:'Rs 38,000',amountRaw:38000,status:'Confirmed',contact:'+977-9889012345',bookedOn:'2026-01-28',notes:'Simple traditional food. No onion, garlic. Minimalist setup.',menu:['Khichdi','Dal','Puri','Sabji','Halwa'],timeline:[{t:'Jan 28',e:'Emergency booking, confirmed same day'}]},
    //     {id:'BK-0008',client:'Deepak Joshi',email:'deepak@corp.com',initials:'DJ',color:'#0891b2',type:'Package 1',date:'2026-02-28',time:'6:30 PM - 11:30 PM',guests:350,venue:'Soaltee Hotel Grand Ballroom',amount:'Rs 2,10,000',amountRaw:210000,status:'Pending',contact:'+977-9890123456',bookedOn:'2026-01-20',notes:'Black-tie 5-course dinner. Live band, sync service with performance schedule.',menu:['Amuse-bouche','Soup','Salad','Main Course','Dessert','Wine Pairing'],timeline:[{t:'Jan 20',e:'Initial inquiry'},{t:'Jan 22',e:'Tasting session done'},{t:'Jan 28',e:'Contract under review'}]},
    //     {id:'BK-0009',client:'Maya Lama',email:'maya@email.com',initials:'ML',color:'#be185d',type:'Package 2',date:'2026-02-18',time:'7:00 PM - 11:30 PM',guests:90,venue:'Himalayan Heights Banquet',amount:'Rs 72,000',amountRaw:72000,status:'Cancelled',contact:'+977-9801112233',bookedOn:'2026-01-08',notes:'Cancelled due to family emergency. Full refund processed.',menu:['Traditional Nepali Thali','Sel Roti','Kheer'],timeline:[{t:'Jan 8',e:'Booking confirmed'},{t:'Jan 30',e:'Cancellation requested'},{t:'Jan 31',e:'Refund processed'}]},
    //     {id:'BK-0010',client:'Hari Bhandari',email:'hari@firm.com',initials:'HB',color:'#d97706',type:'Package 3',date:'2026-02-14',time:'4:00 PM - 8:00 PM',guests:55,venue:'Boudha Rooftop Lounge',amount:'Rs 32,000',amountRaw:32000,status:'Confirmed',contact:'+977-9812233445',bookedOn:'2026-01-30',notes:"Valentine's day special. Red & pink decor. Couple-themed food.",menu:['Heart-shaped Momo','Chocolate Fondue','Strawberry Mocktail','Fondue Board'],timeline:[{t:'Jan 30',e:'Booking + full payment done'},{t:'Feb 1',e:'Menu confirmed'}]},
    //   ];




      //changed made so stop ctrl z here
       

      // ── STAT CARDS (computed live from bookings) ──────────────────
      function formatRs(n){
        if(n>=100000) return '$ '+(n/1000000).toFixed(1).replace(/\.0$/,'')+'M';
        if(n>=1000)   return '$ '+(n/1000).toFixed(0)+'K';
        return '$ '+n;
      }
      function updateStats(){
        const total     = bookings.length;
        const confirmed = bookings.filter(b=>b.status==='Confirmed').length;
        const pending   = bookings.filter(b=>b.status==='Pending').length;
        const revenue   = bookings.filter(b=>b.status==='Confirmed').reduce((s,b)=>s+b.amountRaw,0);

        document.getElementById('statTotal').textContent     = total;
        document.getElementById('statConfirmed').textContent = confirmed;
        document.getElementById('statPending').textContent   = pending;
        document.getElementById('statRevenue').textContent   = formatRs(revenue);

        // simple percent label based on confirmed ratio
        const confPct = total ? Math.round(confirmed/total*100) : 0;
        const pendPct = total ? Math.round(pending/total*100)   : 0;
        document.getElementById('statTotalTrend').innerHTML     = `<i class="bi bi-bar-chart-fill"></i>${total} total`;
        document.getElementById('statConfirmedTrend').innerHTML = `<i class="bi bi-arrow-up-short"></i>${confPct}% rate`;
        document.getElementById('statPendingTrend').innerHTML   = pending > 0
          ? `<i class="bi bi-hourglass-split"></i>${pendPct}% of total`
          : `<i class="bi bi-check-all"></i>All clear`;
        document.getElementById('statRevenueTrend').innerHTML   = `<i class="bi bi-arrow-up-short"></i>Confirmed only`;
        if(pending===0){
          document.getElementById('statPendingTrend').className='stat-trend trend-up';
        }
      }

      // ── TOAST ─
      let toastTimer;
      function showToast(msg,icon='bi-check-circle-fill',color='#28a745'){
        const t=document.getElementById('ctToast');
        document.getElementById('ctToastMsg').textContent=msg;
        const ic=document.getElementById('ctToastIcon');
        ic.className='bi '+icon; ic.style.color=color;
        t.style.display='block';
        clearTimeout(toastTimer);
        toastTimer=setTimeout(()=>{t.style.display='none';},3000);
      }

      // ── CONFIRM DIALOG ────────────────────────────────────────────
      let confirmCallback=null;
      function showConfirmDialog(title,msg,btnLabel,btnClass,iconClass,iconBg,iconColor,cb){
        document.getElementById('confirmDialogTitle').textContent=title;
        document.getElementById('confirmDialogMsg').textContent=msg;
        const btn=document.getElementById('confirmDialogBtn');
        btn.textContent=btnLabel; btn.className='btn-ct '+btnClass;
        const ic=document.getElementById('confirmDialogIcon');
        ic.className=''; ic.innerHTML=`<i class="bi ${iconClass}" style="color:${iconColor}"></i>`;
        ic.style.background=iconBg;
        confirmCallback=cb;
        document.getElementById('confirmDialog').classList.add('open');
      }
      function closeConfirmDialog(){document.getElementById('confirmDialog').classList.remove('open');confirmCallback=null;}
      function confirmDialogYes(){if(confirmCallback)confirmCallback();
      closeConfirmDialog();}

      // ── CURRENT OPEN BOOKING ──────────────────────────────────────
      let currentBookingId=null;

      // ── CALENDAR ──────────────────────────────────────────────────
      function getForDate(y,m,d){
        const ds=`${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        return bookings.filter(b=>b.date===ds);
      }
      function renderCalendar(){
        document.getElementById('calMonthLabel').textContent=`${MONTHS[curMonth]} ${curYear}`;
        const el=document.getElementById('calDays');el.innerHTML='';
        const first=new Date(curYear,curMonth,1).getDay();
        const total=new Date(curYear,curMonth+1,0).getDate();
        for(let i=0;i<first;i++){const e=document.createElement('div');e.className='cal-cell empty';el.appendChild(e);}
        for(let d=1;d<=total;d++){
          const db=getForDate(curYear,curMonth,d);
          const isT=d===today.getDate()&&curMonth===today.getMonth()&&curYear===today.getFullYear();
          const c=document.createElement('div');c.className='cal-cell';
          if(isT)c.classList.add('today');
          if(db.length===1)c.classList.add('has-booking');
          if(db.length>1)c.classList.add('multi-booking');
          c.innerHTML=`<span>${d}</span>`;
         if(db.length>0){
    const dot=document.createElement('div');dot.className='cal-dot';c.appendChild(dot);
    if(db.length>1){const b=document.createElement('div');b.className='cal-multi-badge';b.textContent=db.length;c.appendChild(b);}
    c.addEventListener('click',(e)=>{
        if(db.length===1){ openModal(db[0]); return; }
        openCalPopup(db, c, e);
    });
}
          el.appendChild(c);
        }
      }
      function changeMonth(dir){curMonth+=dir;if(curMonth>11){curMonth=0;curYear++;}if(curMonth<0){curMonth=11;curYear--;}renderCalendar();}

      // ── CALENDAR MULTI-BOOKING POPUP ──────────────────────────────
function openCalPopup(bookingsList, cellEl, e){
    e.stopPropagation();
   
    const existing = document.getElementById('calPopup');
    if(existing){ existing.remove(); return; }

    const popup = document.createElement('div');
    popup.id = 'calPopup';
    popup.style.cssText = `
        position:fixed;z-index:99990;background:#fff;border-radius:10px;
        border:1px solid #e2e6ea;box-shadow:0 8px 32px rgba(0,0,0,0.16);
        padding:8px 6px;min-width:220px;font-family:'DM Sans',sans-serif;
    `;

    const title = document.createElement('div');
    title.style.cssText = 'font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#adb5bd;padding:4px 10px 8px;border-bottom:1px solid #f0f2f5;margin-bottom:6px;';
    const d = new Date(bookingsList[0].date);
    title.textContent = `${d.getDate()} ${MONTHS[d.getMonth()]} — ${bookingsList.length} Bookings`;
    popup.appendChild(title);

    bookingsList.forEach(b => {
        const sc = b.status==='Confirmed'?'rb-confirmed':b.status==='Pending'?'rb-pending':'rb-cancelled';
        const item = document.createElement('div');
        item.style.cssText = 'display:flex;align-items:center;gap:9px;padding:7px 10px;border-radius:7px;cursor:pointer;transition:background 0.12s;';
        item.innerHTML = `
            <div style="width:30px;height:30px;border-radius:7px;background:${b.color}18;color:${b.color};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0">${b.initials}</div>
            <div style="flex:1;min-width:0">
                <div style="font-size:12.5px;font-weight:600;color:#1a2035;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${b.client}</div>
                <div style="font-size:11px;color:#8a92a6">${b.time||''}</div>
            </div>
            <span class="row-badge ${sc}" style="font-size:9px">${b.status}</span>
        `;
        item.addEventListener('mouseenter',()=>item.style.background='#f8faff');
        item.addEventListener('mouseleave',()=>item.style.background='');
        item.addEventListener('click',()=>{ popup.remove(); openModal(b); });
        popup.appendChild(item);
    });

    document.body.appendChild(popup);

    // Position popup near the cell
    const rect = cellEl.getBoundingClientRect();
    let top = rect.bottom + 6;
    let left = rect.left;
    // Keep within viewpart
    if(left + 220 > window.innerWidth - 12) left = window.innerWidth - 232;
    if(top + popup.offsetHeight > window.innerHeight - 12) top = rect.top - popup.offsetHeight - 6;
    popup.style.top = top + 'px';
    popup.style.left = left + 'px';

    // Close on outside click
    setTimeout(()=>{
        document.addEventListener('click', function handler(ev){
            if(!popup.contains(ev.target)){ popup.remove(); document.removeEventListener('click',handler); }
        });
    }, 0);
}

      // ── UPCOMING 
      function renderUpcoming(){
        const sorted=[...bookings].filter(b=>b.status!=='Cancelled').sort((a,b)=>new Date(a.date)-new Date(b.date)).slice(0,6);
        document.getElementById('upcomingList').innerHTML=sorted.map(b=>{
          const d=new Date(b.date);
          const sc=b.status==='Confirmed'?'rb-confirmed':b.status==='Pending'?'rb-pending':b.status==='Payment Done'?'rb-paymentdone':'rb-cancelled';          return `<div class="upcoming-item" onclick='openModal(bookings.find(x=>x.id=="${b.id}"))'>
            <div class="up-date-box"><div class="up-day">${d.getDate()}</div><div class="up-mon">${MONTHS[d.getMonth()].slice(0,3)}</div></div>
            <div class="up-info"><div class="up-name">${b.client}</div><div class="up-meta"><i class="bi bi-people" style="font-size:10px"></i> ${b.guests} guests </div></div>
            <span class="up-badge ${sc}">${b.status}</span>
          </div>`;
        }).join('');
      }

     
      // ── TABLE ─
let activeFilter='all';
let currentPage=1;
let pageSize=15;
let filteredData=[];

function setPageSize(val){
  pageSize=parseInt(val);
  currentPage=1;
  renderTable(filteredData);
}

function renderTable(data){
  filteredData=data;
  const body=document.getElementById('tableBody');
  if(!data.length){
    body.innerHTML='<tr><td colspan="9" style="text-align:center;padding:28px;color:#adb5bd">No bookings found</td></tr>';
    document.getElementById('tableCount').textContent='No bookings found';
    document.getElementById('pagWrap').innerHTML='';
    return;
  }

  const totalPages=Math.ceil(data.length/pageSize);
  if(currentPage>totalPages)currentPage=totalPages;

  const start=(currentPage-1)*pageSize;
  const pageData=data.slice(start,start+pageSize);

  body.innerHTML=pageData.map(b=>{
const sc=b.status==='Confirmed'?'ub-confirmed':b.status==='Pending'?'ub-pending':b.status==='Payment Done'?'ub-paymentdone':'ub-cancelled';    const dd=new Date(b.date).toLocaleDateString('en-US',{day:'2-digit',month:'short',year:'numeric'});
    return `<tr onclick='openModal(bookings.find(x=>x.id=="${b.id}"))'>
      <td><span style="color:#007bff;font-size:11px;font-weight:700">${b.id}</span></td>
      <td><div class="client-cell"><div class="cli-avatar" style="background:${b.color}18;color:${b.color}">${b.initials}</div><div><div class="cli-name">${b.client}</div><div class="cli-email">${b.email}</div></div></div></td>
      <td>${b.type}</td><td>${dd}</td><td>${b.guests}</td>
      <td class="td-mute">${b.venue}</td>
      <td class="amount-col">${b.amount}</td>
      <td><span class="row-badge ${sc}">${b.status}</span></td>
      <td onclick="event.stopPropagation()"><div class="row-actions">
        <div class="row-action-btn rab-view" title="View" onclick='openModal(bookings.find(x=>x.id=="${b.id}"))'><i class="bi bi-eye"></i></div>
        <div class="row-action-btn rab-del" title="Delete" onclick='askDelete("${b.id}")'><i class="bi bi-trash3"></i></div>
      </div></td>
    </tr>`;
  }).join('');

  document.getElementById('tableCount').textContent=`Showing ${start+1}–${Math.min(start+pageSize,data.length)} of ${data.length} bookings`;

  // Render pagination buttons
  const pag=document.getElementById('pagWrap');
  pag.innerHTML='';

  const addBtn=(label,page,isActive,isDisabled)=>{
    const btn=document.createElement('div');
    btn.className='pag-btn'+(isActive?' active':'')+(isDisabled?' disabled':'');
    btn.innerHTML=label;
    if(!isDisabled&&!isActive) btn.style.cursor='pointer';
    if(isDisabled) btn.style.opacity='0.4';
    if(!isDisabled) btn.addEventListener('click',()=>{ currentPage=page; renderTable(filteredData); });
    pag.appendChild(btn);
  };

  addBtn('<i class="bi bi-chevron-left"></i>',currentPage-1,false,currentPage===1);

  // Show smart page range
  let startP=Math.max(1,currentPage-2);
  let endP=Math.min(totalPages,startP+4);
  if(endP-startP<4) startP=Math.max(1,endP-4);

  if(startP>1){ addBtn('1',1,false,false); if(startP>2){const e=document.createElement('div');e.className='pag-btn';e.style.cssText='cursor:default;opacity:0.4';e.textContent='…';pag.appendChild(e);} }
  for(let p=startP;p<=endP;p++) addBtn(p,p,p===currentPage,false);
  if(endP<totalPages){ if(endP<totalPages-1){const e=document.createElement('div');e.className='pag-btn';e.style.cssText='cursor:default;opacity:0.4';e.textContent='…';pag.appendChild(e);} addBtn(totalPages,totalPages,false,false); }

  addBtn('<i class="bi bi-chevron-right"></i>',currentPage+1,false,currentPage===totalPages);
}

// function filterTable(){
//   const q=document.getElementById('tableSearch').value.toLowerCase();
//   let data=bookings;
//   if(activeFilter!=='all')data=data.filter(b=>b.status===activeFilter);
//   if(q)data=data.filter(b=>b.client.toLowerCase().includes(q)||b.type.toLowerCase().includes(q)||b.venue.toLowerCase().includes(q)||b.id.toLowerCase().includes(q));
//   currentPage=1;
//   renderTable(data);
// }
function filterTable(){
  const q = document.getElementById('tableSearch').value.toLowerCase();
  let data = bookings;

  if(activeFilter !== 'all'){
    data = data.filter(b => b.status === activeFilter);
  }

  if(q){
    data = data.filter(b =>
      String(b.client || '').toLowerCase().includes(q) ||
      String(b.type || '').toLowerCase().includes(q) ||
      String(b.venue || '').toLowerCase().includes(q) ||
      String(b.id || '').toLowerCase().includes(q)
    );
  }

  currentPage = 1;
  renderTable(data);
}
function setFilter(f,btn){
  activeFilter=f;
  document.querySelectorAll('.ct-filter-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');filterTable();
}

      // ── MODAL (view) 
      function openModal(b){
        if(!b)return;
        currentBookingId=b.id;
        document.getElementById('mId').textContent=b.id;
        document.getElementById('mName').textContent=b.client;
        document.getElementById('mDate').textContent=new Date(b.date).toLocaleDateString('en-US',{weekday:'long',day:'numeric',month:'long',year:'numeric'});
        document.getElementById('mVenue').textContent=b.venue;
        //const sc=b.status==='Confirmed'?'rb-confirmed':b.status==='Pending'?'rb-pending':'rb-cancelled';
        const sc=b.status==='Confirmed'?'rb-confirmed':b.status==='Pending'?'rb-pending':b.status==='Payment Done'?'rb-paymentdone':'rb-cancelled'; 
        const sb=document.getElementById('mStatusBadge');sb.textContent=b.status;sb.className='row-badge '+sc;
       document.getElementById('mType').textContent=b.type;
        document.getElementById('mGuests').textContent=b.guests+' guests';
        document.getElementById('mContact').textContent=b.contact;
        document.getElementById('mAmount').textContent=b.amount;
        document.getElementById('mTime').textContent=b.time;
        document.getElementById('mBookedOn').textContent=new Date(b.bookedOn).toLocaleDateString('en-US',{day:'numeric',month:'short',year:'numeric'});
        document.getElementById('mNotes').textContent=b.notes;
        document.getElementById('mMenu').innerHTML=b.menu.map(m=>`<span class="menu-tag-pill">${m}</span>`).join('');
       // document.getElementById('mTimeline').innerHTML=b.timeline.map(t=>`<div class="ctl-item"><div class="ctl-dot"></div><div class="ctl-time">${t.t}</div><div class="ctl-text">${t.e}</div></div>`).join('');

        // Show/hide buttons based on current status
        const btnConfirm=document.getElementById('btnConfirmBooking');
        const btnCancel=document.getElementById('btnCancelBooking');
 const btnPayment = document.getElementById('btnPaymentDone');
btnConfirm.style.display  = (b.status==='Confirmed'||b.status==='Payment Done') ? 'none' : 'flex';
btnPayment.style.display  = b.status==='Confirmed' ? 'flex' : 'none';
btnCancel.style.display   = (b.status==='Cancelled' ||b.status==='Payment Done') ? 'none' : 'flex';

        document.getElementById('ctModal').classList.add('open');
        document.body.style.overflow='hidden';
      }
      function closeModal(){document.getElementById('ctModal').classList.remove('open');document.body.style.overflow='';}
      function closeModalBg(e){if(e.target===document.getElementById('ctModal'))closeModal();}

      // ── MODAL ACTIONS 
    function actionConfirm() {
    const b = bookings.find(x => x.id === currentBookingId);
    if (!b) return;
    
    showConfirmDialog(
        'Confirm Booking?',
        `Mark ${b.client}'s booking as Confirmed?`,
        'Yes, Confirm', 'btn-ct-primary',
        'bi-check-circle-fill', '#e9f7ec', '#28a745',
        () => {
            updateBookingStatusInDB(b.id, 'Confirmed');
        }
    );
}
function actionCancel() {
    const b = bookings.find(x => x.id === currentBookingId);
    if (!b) return;
    
    showConfirmDialog(
        'Cancel Booking?',
        `This will cancel ${b.client}'s booking.`,
        'Yes, Cancel', 'btn-ct-danger',
        'bi-x-circle-fill', '#fdecea', '#dc3545',
        () => {
            updateBookingStatusInDB(b.id, 'Cancelled');
        }
    );
}

function actionPaymentDone() {
    const b = bookings.find(x => x.id === currentBookingId);
    if (!b) return;
    
    showConfirmDialog(
        'Mark Payment Done?',
        `Confirm payment for ${b.client}'s booking?`,
        'Yes, Mark Paid', 'btn-ct-payment',
        'bi-cash-coin', '#ede9fe', '#7c3aed',
        () => {
            updateBookingStatusInDB(b.id, 'Payment Done');
        }
    );
}


function updateBookingStatusInDB(bookingId, newStatus) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(UPDATE_STATUS_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            booking_id: bookingId,
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const b = bookings.find(x => x.id === bookingId);
            if (b) b.status = newStatus;
            
            closeModal();
            refreshAll();
            showToast(`Status updated to ${newStatus}!`, 'bi-check-circle-fill', '#28a745');
            
            setTimeout(() => {
                const updated = bookings.find(x => x.id === bookingId);
                //if (updated) openModal(updated);
            }, 100);
        } else {
            showToast('Error: ' + data.message, 'bi-exclamation-triangle-fill', '#dc3545');
        }
    })
    .catch(error => {
        showToast('Network error', 'bi-exclamation-triangle-fill', '#dc3545');
    });
}
      function actionEdit(){
        const b=bookings.find(x=>x.id===currentBookingId);
        if(!b)return;
        closeModal();
        openEdit(b);
      }

      function updateBookingStatus(id,newStatus){
        const b=bookings.find(x=>x.id===id);
        if(!b)return;
        const now=new Date();
        const label=now.toLocaleDateString('en-US',{day:'numeric',month:'short'});
        b.status=newStatus;
       // b.timeline.push({t:label,e:`Status changed to ${newStatus} by admin`});
        closeModal();
        refreshAll();
        // Re-open updated modal
        setTimeout(()=>openModal(b),100);
      }

      // ── DELETE 
      function askDelete(id){
        const b=bookings.find(x=>x.id===id);
        if(!b)return;
        showConfirmDialog(
          'Delete Booking?',
          `Permanently delete ${b.client}'s booking (${b.id})?`,
          'Yes, Delete','btn-ct-danger',
          'bi-trash3-fill','#fdecea','#dc3545',
          ()=>{
            const idx=bookings.findIndex(x=>x.id===id);
            if(idx>-1)bookings.splice(idx,1);
            showToast(`Booking ${id} deleted.`,'bi-trash3-fill','#dc3545');
            refreshAll();
          }
        );
      }

      // ── EDIT MODAL 
      function openEdit(b){
        if(!b)return;
        currentBookingId=b.id;
        document.getElementById('eMId').textContent=b.id;
        document.getElementById('eClient').value=b.client;
        document.getElementById('eContact').value=b.contact;
        document.getElementById('eType').value=b.type;
        document.getElementById('eDate').value=b.date;
        document.getElementById('eTime').value=b.time;
        document.getElementById('eGuests').value=b.guests;
        document.getElementById('eVenue').value=b.venue;
        document.getElementById('eAmount').value=b.amount;
        document.getElementById('eStatus').value=b.status;
        document.getElementById('eNotes').value=b.notes;
        document.getElementById('editModal').classList.add('open');
        document.body.style.overflow='hidden';
      }
      function closeEdit(){document.getElementById('editModal').classList.remove('open');document.body.style.overflow='';}
      function closeEditBg(e){if(e.target===document.getElementById('editModal'))closeEdit();}

      function saveEdit(){
        const b=bookings.find(x=>x.id===currentBookingId);
        if(!b)return;
        const now=new Date();
        const label=now.toLocaleDateString('en-US',{day:'numeric',month:'short'});
        const oldStatus=b.status;

        b.client  = document.getElementById('eClient').value.trim()||b.client;
        b.contact = document.getElementById('eContact').value.trim()||b.contact;
        b.type    = document.getElementById('eType').value.trim()||b.type;
        b.date    = document.getElementById('eDate').value||b.date;
        b.time    = document.getElementById('eTime').value.trim()||b.time;
        b.guests  = parseInt(document.getElementById('eGuests').value)||b.guests;
        b.venue   = document.getElementById('eVenue').value.trim()||b.venue;
        b.amount  = document.getElementById('eAmount').value.trim()||b.amount;
        b.status  = document.getElementById('eStatus').value;
        b.notes   = document.getElementById('eNotes').value.trim()||b.notes;

        // parse amountRaw from amount string
        const rawNum=parseInt((b.amount||'').replace(/[^0-9]/g,''));
        if(!isNaN(rawNum))b.amountRaw=rawNum;

        //b.timeline.push({t:label,e:`Booking details updated by admin`});
       // if(oldStatus!==b.status) b.timeline.push({t:label,e:`Status changed to ${b.status}`});

        closeEdit();
        showToast(`${b.client}'s booking updated!`,'bi-floppy-fill','#007bff');
        refreshAll();
      }

      //  REFRESH ALL 
      function refreshAll(){
        updateStats();
        renderCalendar();
        renderUpcoming();
        filterTable();
      }

      document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeModal();closeEdit();closeConfirmDialog();}});

      refreshAll();
   