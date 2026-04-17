// public/js/admin/datewisebookings.js

// ── QUICK DATE PRESETS ────────────────────────────────────────
function setQuick(range) {
  const now = new Date();
  const fmt = d => d.toISOString().split('T')[0];
  let from, to;
  if (range === 'today') {
    from = to = fmt(now);
  } else if (range === 'week') {
    const day = now.getDay();
    const mon = new Date(now); mon.setDate(now.getDate() - day + (day === 0 ? -6 : 1));
    const sun = new Date(mon); sun.setDate(mon.getDate() + 6);
    from = fmt(mon); to = fmt(sun);
  } else if (range === 'month') {
    from = fmt(new Date(now.getFullYear(), now.getMonth(), 1));
    to   = fmt(new Date(now.getFullYear(), now.getMonth() + 1, 0));
  }
  document.getElementById('fromDate').value = from;
  document.getElementById('toDate').value   = to;
  loadBookings();
}

// ── STATE ─────────────────────────────────────────────────────
let dwFiltered   = [];   // all bookings in selected date range
let dwActiveFilter = 'all'; // current status filter

// ── LOAD BOOKINGS ────────────────────────────────────────────
function loadBookings() {
  const from = document.getElementById('fromDate').value;
  const to   = document.getElementById('toDate').value;
  if (!from || !to) {
    alert('Please select both From and To dates.');
    return;
  }
  if (from > to) {
    alert('From date cannot be after To date.');
    return;
  }

  dwFiltered = bookings.filter(b => b.date >= from && b.date <= to);

  // Reset status filter to 'all' on new date load
  dwActiveFilter = 'all';
  document.querySelectorAll('.ct-filter-btn').forEach(btn => btn.classList.remove('active'));
  const allBtn = document.querySelector('.ct-filter-btn[onclick*="\'all\'"]');
  if (allBtn) allBtn.classList.add('active');

  document.getElementById('initialState').style.display   = 'none';
  document.getElementById('emptyState').style.display     = dwFiltered.length ? 'none' : 'block';
  document.getElementById('resultsSection').style.display = dwFiltered.length ? 'block' : 'none';

  if (dwFiltered.length) {
    updateDwStats(dwFiltered);
    const fromFmt = new Date(from).toLocaleDateString('en-US', {day:'numeric', month:'short', year:'numeric'});
    const toFmt   = new Date(to).toLocaleDateString('en-US',   {day:'numeric', month:'short', year:'numeric'});
    document.getElementById('dwRangeBadge').textContent = `${fromFmt} → ${toFmt}`;
    dwApplyFilterAndRender();
  }
}

function clearFilter() {
  document.getElementById('fromDate').value = '';
  document.getElementById('toDate').value   = '';
  document.getElementById('dwSearch').value = '';
  document.getElementById('resultsSection').style.display = 'none';
  document.getElementById('emptyState').style.display     = 'none';
  document.getElementById('initialState').style.display   = 'block';
  dwFiltered     = [];
  dwActiveFilter = 'all';
  document.querySelectorAll('.ct-filter-btn').forEach(btn => btn.classList.remove('active'));
  const allBtn = document.querySelector('.ct-filter-btn[onclick*="\'all\'"]');
  if (allBtn) allBtn.classList.add('active');
}

// ── STATUS FILTER TABS ────────────────────────────────────────
function dwSetFilter(status, btn) {
  dwActiveFilter = status;
  document.querySelectorAll('.ct-filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  dwApplyFilterAndRender();
}

// Returns the currently visible (status-filtered + search-filtered) records
function dwGetVisibleRecords() {
  const q = (document.getElementById('dwSearch').value || '').toLowerCase();

  let data = dwActiveFilter === 'all'
    ? dwFiltered
    : dwFiltered.filter(b => b.status === dwActiveFilter);

  if (q) {
    data = data.filter(b =>
      (b.client||'').toLowerCase().includes(q) ||
      (b.type||'').toLowerCase().includes(q) ||
      (b.venue||'').toLowerCase().includes(q) ||
      (b.id||'').toLowerCase().includes(q)
    );
  }
  return data;
}

function dwApplyFilterAndRender() {
  dwRenderTable(dwGetVisibleRecords());
}

// ── STATS ─────────────────────────────────────────────────────
function formatDwRs(n) {
  if (n >= 1000000) return '$' + (n/1000000).toFixed(2) + 'M';
  if (n >= 1000)    return '$' + (n/1000).toFixed(1) + 'K';
  return '$' + n;
}

function updateDwStats(data) {
  document.getElementById('dwStatTotal').textContent     = data.length;
  document.getElementById('dwStatConfirmed').textContent = data.filter(b => b.status === 'Confirmed').length;
  document.getElementById('dwStatPending').textContent   = data.filter(b => b.status === 'Pending').length;
  const rev = data.filter(b => b.status === 'Payment Done' || b.status === 'Delivered').reduce((s, b) => s + b.amountRaw, 0);
  document.getElementById('dwStatRevenue').textContent   = formatDwRs(rev);
}

// ── SEARCH FILTER ─────────────────────────────────────────────
function dwFilterTable() {
  dwApplyFilterAndRender();
}

// ── RENDER TABLE ──────────────────────────────────────────────
function dwRenderTable(data) {
  const body = document.getElementById('dwTableBody');
  if (!data.length) {
    body.innerHTML = '<tr><td colspan="10" style="text-align:center;padding:28px;color:#adb5bd">No bookings found</td></tr>';
    document.getElementById('dwTableCount').textContent = 'No bookings found';
    return;
  }

  body.innerHTML = data.map(b => {
    const sc  = b.status === 'Confirmed'    ? 'rb-confirmed'   :
                b.status === 'Pending'      ? 'rb-pending'     :
                b.status === 'Info Sent'    ? 'rb-infosent'    :
                b.status === 'Payment Done' ? 'rb-paymentdone' : 'rb-cancelled';
    const dd  = new Date(b.date).toLocaleDateString('en-US', {day:'2-digit', month:'short', year:'numeric'});
    const allItems = [...(b.menu1||[]), ...(b.menu||[])];
    const show = allItems.slice(0, 3);
    const more = allItems.length - 3;
    const pillsHtml = show.map(i => `<span class="item-pill">${i}</span>`).join('')
      + (more > 0 ? `<span class="items-more">+${more} more</span>` : '');

    return `<tr>
      <td><span style="color:#007bff;font-size:11px;font-weight:700">${b.id}</span></td>
      <td>
        <div class="client-cell">
          <div class="cli-avatar" style="background:${b.color}18;color:${b.color}">${b.initials}</div>
          <div>
            <div class="cli-name">${b.client}</div>
            <div class="cli-email">${b.contact}</div>
          </div>
        </div>
      </td>
      <td>${b.type}</td>
      <td>${dd}</td>
      <td>${b.guests}</td>
      <td style="color:#adb5bd;font-size:12px;max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${b.venue}</td>
      <td><div class="items-cell">${pillsHtml}</div></td>
      <td class="amount-col">${b.amount}</td>
      <td><span class="row-badge ${sc}">${b.status}</span></td>
      <td>
        <button class="dw-btn dw-btn-print-row" style="padding:5px 12px;font-size:11px" onclick="openPrintAmountModal('${b.id}')">
          <i class="bi bi-printer"></i> Print
        </button>
      </td>
    </tr>`;
  }).join('');

  document.getElementById('dwTableCount').textContent =
    `Showing ${data.length} booking${data.length !== 1 ? 's' : ''}`;
}

// ── PRINT SINGLE: AMOUNT MODAL ────────────────────────────────
let _pendingPrintId = null;

function openPrintAmountModal(id) {
  _pendingPrintId = id;
  const modal = document.getElementById('printAmountModal');
  modal.style.display = 'flex';

  document.getElementById('printWithAmountBtn').onclick = function() {
    const idToPrint = _pendingPrintId;  // Store ID first
    closePrintAmountModal();
    printSingleBooking(idToPrint, true);  // Use stored value
  };
  
  document.getElementById('printWithoutAmountBtn').onclick = function() {
    const idToPrint = _pendingPrintId;  // Store ID first
    closePrintAmountModal();
    printSingleBooking(idToPrint, false);  // Use stored value
  };
}

function closePrintAmountModal() {
  document.getElementById('printAmountModal').style.display = 'none';
 // _pendingPrintId = null;
}

// ── PRINT SINGLE (opens print.blade.php in new window) ───────
function printSingleBooking(id, showAmount) {
  console.log("printSingleBooking called with:", id, showAmount);
  const param = showAmount ? '1' : '0';
  const url = `${baseUrl}/print-single/${id}?show_amount=${param}`;
  console.log("Opening URL:", url);
  window.open(url, '_blank', 'width=900,height=700');
}

// ── PRINT DROPDOWN TOGGLE ─────────────────────────────────────
function togglePrintDropdown() {
  document.getElementById('printDropdownMenu').classList.toggle('open');
}

function closePrintDropdown() {
  document.getElementById('printDropdownMenu').classList.remove('open');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
  const wrap = document.getElementById('printDropdownWrap');
  if (wrap && !wrap.contains(e.target)) {
    closePrintDropdown();
  }
});

// Close print modal on backdrop click
document.addEventListener('click', function(e) {
  const modal = document.getElementById('printAmountModal');
  if (modal && e.target === modal) closePrintAmountModal();
});

// ── PRINT ALL ─────────────────────────────────────────────────
// Prints only the currently visible (filtered) records
function printAllBookings(showAmount) {
  const visible = dwGetVisibleRecords();
  if (!visible.length) {
    alert('No bookings to print.');
    return;
  }

  const from = document.getElementById('fromDate').value;
  const to   = document.getElementById('toDate').value;

  if (!from || !to) {
    alert('Please select date range first.');
    return;
  }

  // Build query: pass the IDs of only visible records + show_amount flag
  const ids        = visible.map(b => b.id).join(',');
  const amountFlag = showAmount ? '1' : '0';
  const status     = dwActiveFilter !== 'all' ? `&status=${encodeURIComponent(dwActiveFilter)}` : '';

  window.open(
    `${baseUrl}/print-all?from=${from}&to=${to}&ids=${encodeURIComponent(ids)}&show_amount=${amountFlag}${status}`,
    '_blank',
    'width=1100,height=750'
  );
}

// ── EXPORT TABLE TO EXCEL ─────────────────────────────────────
function exportTableToExcel() {
  const visible = dwGetVisibleRecords();
  if (!visible.length) {
    alert('No bookings loaded to export.');
    return;
  }

  const rows = [];
  const headers = ['ID', 'Client', 'Contact', 'Package', 'Date', 'Guests', 'Items', 'Amount', 'Status'];
  rows.push(headers);

  visible.forEach(booking => {
    const items = [];
    if (booking.menu1)      items.push(...booking.menu1);
    if (booking.menu)       items.push(...booking.menu);
    if (booking.kids_items) items.push(...booking.kids_items);

    rows.push([
      booking.id,
      booking.client,
      booking.contact,
      booking.type,
      booking.date,
      booking.guests + (booking.kids_count > 0 ? ' + ' + booking.kids_count + 'K' : ''),
      items.join(', '),
      booking.amount,
      booking.status
    ]);
  });

  let csv = rows.map(row =>
    row.map(cell => '"' + String(cell).replace(/"/g, '""') + '"').join(',')
  ).join('\n');

  const link = document.createElement('a');
  link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
  link.download = 'bookings_export_' + new Date().toISOString().split('T')[0] + '.csv';
  link.click();
}

// ── INITIALIZE ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
  const now      = new Date();
  const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
  const lastDay  = new Date(now.getFullYear(), now.getMonth() + 1, 0);

  document.getElementById('fromDate').value = firstDay.toISOString().split('T')[0];
  document.getElementById('toDate').value   = lastDay.toISOString().split('T')[0];

  loadBookings();
});