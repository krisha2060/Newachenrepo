@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

  {{-- HEADER ROW --}}
  <div class="dw-page-header">
    <div>
      <div class="dw-page-title"><i class="bi bi-calendar-range-fill"></i> Date-wise Bookings</div>
      <div class="dw-page-sub">Filter and print bookings by date range</div>
    </div>
  </div>

  {{-- DATE RANGE PICKER CARD --}}
  <div class="ct-card dw-filter-card mb-4">
    <div class="dw-filter-body">
      <div class="dw-filter-group">
        <label class="dw-label"><i class="bi bi-calendar3"></i> From Date</label>
        <input type="date" id="fromDate" class="dw-date-input" />
      </div>
      <div class="dw-filter-sep"><i class="bi bi-arrow-right"></i></div>
      <div class="dw-filter-group">
        <label class="dw-label"><i class="bi bi-calendar3"></i> To Date</label>
        <input type="date" id="toDate" class="dw-date-input" />
      </div>
      <div class="dw-filter-actions">
        <button class="dw-btn dw-btn-primary" onclick="loadBookings()">
          <i class="bi bi-search"></i> Load Bookings
        </button>
        <button class="dw-btn dw-btn-outline" onclick="clearFilter()">
          <i class="bi bi-x-circle"></i> Clear
        </button>
      </div>
      <div class="dw-quick-btns">
        <button class="dw-quick-btn" onclick="setQuick('today')">Today</button>
        <button class="dw-quick-btn" onclick="setQuick('week')">This Week</button>
        <button class="dw-quick-btn" onclick="setQuick('month')">This Month</button>
      </div>
    </div>
  </div>

  {{-- RESULTS SECTION --}}
  <div id="resultsSection" style="display:none">

    {{-- SUMMARY STATS --}}
    <div class="row g-3 mb-4" id="summaryCards">
      <div class="col-xl-3 col-md-6">
        <div class="catering-stat cs-blue">
          <div class="stat-icon-box sib-blue"><i class="bi bi-calendar-check-fill"></i></div>
          <div class="stat-num" id="dwStatTotal">0</div>
          <div class="stat-lbl">Total Bookings</div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="catering-stat cs-green">
          <div class="stat-icon-box sib-green"><i class="bi bi-check-circle-fill"></i></div>
          <div class="stat-num" id="dwStatConfirmed">0</div>
          <div class="stat-lbl">Confirmed</div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="catering-stat cs-gold">
          <div class="stat-icon-box sib-gold"><i class="bi bi-clock-fill"></i></div>
          <div class="stat-num" id="dwStatPending">0</div>
          <div class="stat-lbl">Pending</div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="catering-stat cs-red">
          <div class="stat-icon-box sib-red"><i class="bi bi-cash-coin"></i></div>
          <div class="stat-num" id="dwStatRevenue">$0</div>
          <div class="stat-lbl">Total Revenue</div>
        </div>
      </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="ct-card">
      <div class="ct-table-toolbar">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
          <div class="ct-card-title"><i class="bi bi-table"></i> Bookings</div>
          <span class="dw-range-badge" id="dwRangeBadge"></span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
          {{-- STATUS FILTER BUTTONS --}}
          <button class="ct-filter-btn active" onclick="dwSetFilter('all',this)">All</button>
          <button class="ct-filter-btn" onclick="dwSetFilter('Pending',this)">Pending</button>
          <button class="ct-filter-btn" onclick="dwSetFilter('Info Sent',this)">Info Sent</button>
          <button class="ct-filter-btn" onclick="dwSetFilter('Confirmed',this)">Confirmed</button>
          <button class="ct-filter-btn" onclick="dwSetFilter('Reminder Sent',this)">Reminder Sent</button>
            <button class="ct-filter-btn" onclick="dwSetFilter('Payment Done',this)">Payment Done</button>

          <button class="ct-filter-btn" onclick="dwSetFilter('Delivered',this)">Delivered</button>
          <button class="ct-filter-btn" onclick="dwSetFilter('Cancelled',this)">Cancelled</button>

          {{-- PRINT ALL DROPDOWN --}}
          <div class="dw-print-dropdown" id="printDropdownWrap">
            <button class="dw-btn dw-btn-print" onclick="togglePrintDropdown()">
              <i class="bi bi-printer-fill"></i> Print All <i class="bi bi-chevron-down" style="font-size:10px"></i>
            </button>
            <div class="dw-print-menu" id="printDropdownMenu">
              <button onclick="printAllBookings(true); closePrintDropdown()">
                <i class="bi bi-currency-dollar"></i> Print with Amount
              </button>
              <button onclick="printAllBookings(false); closePrintDropdown()">
                <i class="bi bi-eye-slash"></i> Print without Amount
              </button>
            </div>
          </div>

          {{-- EXPORT EXCEL BUTTON --}}
          <button class="dw-btn dw-btn-export" onclick="exportTableToExcel()">
            <i class="bi bi-file-earmark-spreadsheet"></i> Export Excel
          </button>
          <div class="ct-search-wrap">
            <i class="bi bi-search"></i>
            <input class="ct-search" type="text" placeholder="Search..." id="dwSearch" oninput="dwFilterTable()"/>
          </div>
        </div>
      </div>

      <div style="overflow-x:auto">
        <table class="ct-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Client</th>
              <th>Package</th>
              <th>Date</th>
              <th>Guests</th>
              <th>Venue</th>
              <th>Items</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Print</th>
            </tr>
          </thead>
          <tbody id="dwTableBody"></tbody>
        </table>
      </div>

      <div class="ct-table-footer">
        <span id="dwTableCount">No bookings loaded</span>
      </div>
    </div>
  </div>

  {{-- EMPTY STATE --}}
  <div id="emptyState" style="display:none">
    <div class="dw-empty">
      <div class="dw-empty-icon"><i class="bi bi-calendar-x"></i></div>
      <div class="dw-empty-title">No Bookings Found</div>
      <div class="dw-empty-sub">There are no bookings in the selected date range. Try a different range.</div>
    </div>
  </div>

  {{-- INITIAL STATE --}}
  <div id="initialState">
    <div class="dw-empty">
      <div class="dw-empty-icon" style="background:#e8f0fe;color:#007bff"><i class="bi bi-calendar-range"></i></div>
      <div class="dw-empty-title">Select a Date Range</div>
      <div class="dw-empty-sub">Choose a from and to date above, then click <strong>Load Bookings</strong> to view results.</div>
    </div>
  </div>

  {{-- PRINT SINGLE: with/without amount modal --}}
  <div id="printAmountModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:28px 32px;max-width:360px;width:90%;box-shadow:0 8px 32px rgba(0,0,0,0.18);">
      <div style="font-size:16px;font-weight:700;color:#1a2035;margin-bottom:6px;"><i class="bi bi-printer"></i> Print Invoice</div>
      <div style="font-size:13px;color:#6c757d;margin-bottom:22px;">Choose how you want to print this invoice:</div>
      <div style="display:flex;flex-direction:column;gap:10px;">
        <button id="printWithAmountBtn" class="dw-btn dw-btn-primary" style="justify-content:center;padding:12px 20px;">
          <i class="bi bi-currency-dollar"></i> Print with Amount
        </button>
        <button id="printWithoutAmountBtn" class="dw-btn dw-btn-outline" style="justify-content:center;padding:12px 20px;">
          <i class="bi bi-eye-slash"></i> Print without Amount
        </button>
        <button onclick="closePrintAmountModal()" style="padding:8px;border:none;background:none;color:#adb5bd;cursor:pointer;font-size:13px;margin-top:4px;">Cancel</button>
      </div>
    </div>
  </div>

</div>

<script>
  const bookings = @json($bookings);
  const baseUrl = '{{ url("/admin") }}';
</script>

<style>
/* ── PAGE HEADER ─────────────────────────────────────────── */
.dw-page-header {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:20px; flex-wrap:wrap; gap:10px;
}
.dw-page-title {
  font-size:20px; font-weight:700; color:#007bff;
  display:flex; align-items:center; gap:8px;
}
.dw-page-sub { font-size:13px; color:#8a92a6; margin-top:2px; }

/* ── FILTER CARD ─────────────────────────────────────────── */
.dw-filter-card { padding:20px 24px !important; }
.dw-filter-body {
  display:flex; align-items:flex-end; gap:16px; flex-wrap:wrap;
}
.dw-filter-group { display:flex; flex-direction:column; gap:5px; }
.dw-label {
  font-size:11px; font-weight:600; text-transform:uppercase;
  letter-spacing:0.7px; color:#8a92a6;
  display:flex; align-items:center; gap:5px;
}
.dw-date-input {
  padding:8px 12px; border-radius:7px; border:1px solid #e2e6ea;
  font-size:13px; color:#495057; outline:none; font-family:inherit;
  background:#f4f6f9; transition:border 0.13s;
}
.dw-date-input:focus { border-color:#007bff; background:#fff; }
.dw-filter-sep {
  font-size:18px; color:#adb5bd;
  padding-bottom:6px; align-self:flex-end;
}
.dw-filter-actions { display:flex; gap:8px; align-self:flex-end; }
.dw-quick-btns {
  display:flex; gap:6px; align-self:flex-end; flex-wrap:wrap;
  padding-left:8px; border-left:1.5px solid #f0f2f5;
}
.dw-quick-btn {
  padding:8px 14px; border-radius:7px; background:#f4f6f9;
  border:1px solid #e2e6ea; font-size:12px; font-weight:500;
  color:#6c757d; cursor:pointer; font-family:'DM Sans',sans-serif;
  transition:all 0.13s;
}
.dw-quick-btn:hover { background:#e8f0fe; color:#007bff; border-color:#b3d0ff; }

/* ── BUTTONS ─────────────────────────────────────────────── */
.dw-btn {
  padding:8px 18px; border-radius:7px; font-size:13px; font-weight:500;
  cursor:pointer; border:none; transition:all 0.13s;
  display:flex; align-items:center; gap:6px; font-family:'DM Sans',sans-serif;
}
.dw-btn-primary  { background:#007bff; color:#fff; }
.dw-btn-primary:hover { background:#0069d9; }
.dw-btn-outline  { background:transparent; border:1px solid #ced4da; color:#6c757d; }
.dw-btn-outline:hover { border-color:#007bff; color:#007bff; }
.dw-btn-print    { background:#007bff; color:#fff; }
.dw-btn-print:hover { background:#0d1426; }
.dw-btn-export   { background:#e8e8e8; color:#000; border:1px solid #000; }
.dw-btn-export:hover { background:#d0d0d0; }
.dw-btn-print-row { background:#f8fafc; border:1px solid #e2e6ea; color:#495057; }
.dw-btn-print-row:hover { background:#1a2035; color:#fff; border-color:#1a2035; }

/* ── STATUS FILTER BUTTONS (same as dashboard) ───────────── */
.ct-filter-btn {
  padding:6px 14px; border-radius:20px; font-size:11px; font-weight:600;
  cursor:pointer; border:1px solid #e2e6ea; background:#f4f6f9;
  color:#6c757d; transition:all 0.13s; font-family:'DM Sans',sans-serif;
  text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap;
}
.ct-filter-btn:hover { border-color:#007bff; color:#007bff; background:#e8f0fe; }
.ct-filter-btn.active { background:#007bff; color:#fff; border-color:#007bff; }

/* ── PRINT DROPDOWN ──────────────────────────────────────── */
.dw-print-dropdown { position:relative; }
.dw-print-menu {
  display:none; position:absolute; top:calc(100% + 6px); right:0;
  background:#fff; border:1px solid #e2e6ea; border-radius:8px;
  box-shadow:0 4px 16px rgba(0,0,0,0.12); min-width:200px; z-index:999;
  overflow:hidden;
}
.dw-print-menu.open { display:block; }
.dw-print-menu button {
  display:flex; align-items:center; gap:8px;
  width:100%; padding:11px 16px; border:none; background:none;
  font-size:13px; color:#1a2035; cursor:pointer; font-family:'DM Sans',sans-serif;
  font-weight:500; text-align:left; transition:background 0.12s;
}
.dw-print-menu button:hover { background:#f4f6f9; }
.dw-print-menu button i { color:#8a92a6; }

/* ── RANGE BADGE ─────────────────────────────────────────── */
.dw-range-badge {
  background:#e8f0fe; color:#007bff; font-size:11px; font-weight:600;
  padding:3px 10px; border-radius:20px; letter-spacing:0.3px;
}

/* ── ITEMS CELL ──────────────────────────────────────────── */
.items-cell { display:flex; flex-wrap:wrap; gap:4px; max-width:220px; }
.item-pill {
  padding:2px 8px; border-radius:12px; font-size:10px;
  background:#f4f6f9; border:1px solid #e2e6ea; color:#3d4a5c;
  white-space:nowrap;
}
.items-more {
  padding:2px 8px; border-radius:12px; font-size:10px;
  background:#e8f0fe; border:1px solid #b3d0ff; color:#007bff;
  white-space:nowrap; cursor:pointer; font-weight:600;
}

/* ── EMPTY STATE ─────────────────────────────────────────── */
.dw-empty {
  text-align:center; padding:60px 20px;
  background:#fff; border-radius:10px; border:1px solid #e8ecf0;
  box-shadow:0 1px 6px rgba(0,0,0,0.05);
}
.dw-empty-icon {
  width:64px; height:64px; border-radius:16px; background:#f4f6f9;
  color:#adb5bd; font-size:28px; display:flex; align-items:center;
  justify-content:center; margin:0 auto 16px;
}
.dw-empty-title { font-size:16px; font-weight:700; color:#1a2035; margin-bottom:6px; }
.dw-empty-sub   { font-size:13px; color:#8a92a6; max-width:340px; margin:0 auto; line-height:1.6; }

/* ── STAT CARDS (reuse from dashboard) ──────────────────── */
.catering-stat { background:#fff; border-radius:10px; border:1px solid #e8ecf0; padding:20px 20px 16px; position:relative; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,0.06); }
.catering-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; }
.cs-blue::before  { background:linear-gradient(90deg,#007bff,#66b2ff); }
.cs-green::before { background:linear-gradient(90deg,#28a745,#5dd879); }
.cs-gold::before  { background:linear-gradient(90deg,#c9a84c,#e8c97a); }
.cs-red::before   { background:linear-gradient(90deg,#dc3545,#f07080); }
.stat-icon-box { width:46px; height:46px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:12px; }
.sib-blue  { background:#e8f0fe; color:#007bff; }
.sib-green { background:#e9f7ec; color:#28a745; }
.sib-gold  { background:#fdf6e3; color:#c9a84c; }
.sib-red   { background:#fdecea; color:#dc3545; }
.stat-num { font-size:26px; font-weight:700; color:#1a2035; line-height:1; }
.stat-lbl { font-size:12px; color:#8a92a6; margin-top:3px; text-transform:uppercase; letter-spacing:0.7px; }

/* ── TABLE (reuse from dashboard) ───────────────────────── */
.ct-card { background:#fff; border-radius:10px; border:1px solid #e8ecf0; box-shadow:0 1px 6px rgba(0,0,0,0.05); overflow:hidden; }
.ct-card-title { font-size:14px; font-weight:600; color:#1a2035; display:flex; align-items:center; gap:7px; }
.ct-card-title i { color:#007bff; }
.ct-table-toolbar { padding:14px 20px; border-bottom:1px solid #f0f2f5; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.ct-search-wrap { position:relative; }
.ct-search-wrap i { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#adb5bd; font-size:13px; }
.ct-search { background:#f4f6f9; border:1px solid #e2e6ea; border-radius:7px; padding:7px 12px 7px 32px; font-size:13px; color:#495057; width:200px; outline:none; font-family:inherit; }
.ct-search:focus { border-color:#007bff; background:#fff; }
.ct-table { width:100%; border-collapse:collapse; }
.ct-table thead th { padding:11px 16px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.7px; color:#8a92a6; background:#f8fafc; border-bottom:1px solid #edf0f5; text-align:left; white-space:nowrap; }
.ct-table tbody tr { border-bottom:1px solid #f5f7fa; transition:background 0.12s; }
.ct-table tbody tr:hover { background:#f8faff; }
.ct-table tbody tr:last-child { border-bottom:none; }
.ct-table td { padding:13px 16px; font-size:13px; color:#3d4a5c; vertical-align:middle; }
.client-cell { display:flex; align-items:center; gap:9px; }
.cli-avatar { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
.cli-name  { font-weight:600; color:#1a2035; font-size:13px; }
.cli-email { font-size:11px; color:#adb5bd; }
.amount-col { font-weight:700; color:#1a2035; }
.row-badge { font-size:10px; font-weight:600; padding:3px 9px; border-radius:20px; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; }
.rb-confirmed   { background:#e9f7ec; color:#28a745; }
.rb-pending     { background:#fff8e1; color:#e6a817; }
.rb-cancelled   { background:#fdecea; color:#dc3545; }
.rb-paymentdone { background:#ede9fe; color:#7c3aed; }
.rb-infosent    { background:#e0f2fe; color:#0369a1; }
.ct-table-footer { padding:12px 20px; border-top:1px solid #f0f2f5; display:flex; align-items:center; justify-content:space-between; font-size:12px; color:#8a92a6; }

/* ── PRINT STYLES ────────────────────────────────────────── */
@media print {
  body * { visibility:hidden !important; }
  #printArea, #printArea * { visibility:visible !important; }
  #printArea {
    position:fixed !important; left:0; top:0; width:100%;
    background:#fff !important;
  }
  tr { page-break-inside: avoid; break-inside: avoid; }
}
</style>

<script src="{{ asset('web/js/datewisebookings.js') }}"></script>

@endsection