@extends('admin.layouts.app')
   
@section('content')   
     

        
          <div class="container-fluid">

            <!-- STAT CARDS -->
            <div class="row g-3 mb-4">
              <div class="col-xl-3 col-md-6">
                <div class="catering-stat cs-blue">
                  <div class="stat-icon-box sib-blue"><i class="bi bi-calendar-check-fill"></i></div>
                  <div class="stat-trend trend-up" id="statTotalTrend"></div>
                  <div class="stat-num" id="statTotal">–</div>
                  <div class="stat-lbl">Total Bookings</div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="catering-stat cs-green">
                  <div class="stat-icon-box sib-green"><i class="bi bi-check-circle-fill"></i></div>
                  <div class="stat-trend trend-up" id="statConfirmedTrend"></div>
                  <div class="stat-num" id="statConfirmed">–</div>
                  <div class="stat-lbl">Confirmed</div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="catering-stat cs-gold">
                  <div class="stat-icon-box sib-gold"><i class="bi bi-clock-fill"></i></div>
                  <div class="stat-trend trend-warn" id="statPendingTrend"></div>
                  <div class="stat-num" id="statPending">–</div>
                  <div class="stat-lbl" >Pending Approval</div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="catering-stat cs-red">
                  <div class="stat-icon-box sib-red"><i class="bi bi-cash-coin"></i></div>
                  <div class="stat-trend trend-up" id="statRevenueTrend"></div>
                  <div class="stat-num" id="statRevenue">–</div>
                  <div class="stat-lbl">Total Revenue</div>
                </div>
              </div>
            </div>

            <!-- CALENDAR + UPCOMING -->
            <div class="row g-3 mb-4">
              <div class="col-xl-8">
                <div class="ct-card h-100">
                  <div class="ct-card-header">
                    <div class="ct-card-title"><i class="bi bi-calendar3"></i> Booking Calendar</div>
                    <div style="display:flex;align-items:center;gap:8px">
                      <button class="cal-btn" onclick="changeMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                      <span class="cal-month-label" id="calMonthLabel"></span>
                      <button class="cal-btn" onclick="changeMonth(1)"><i class="bi bi-chevron-right"></i></button>
                    </div>
                  </div>
                  <div class="cal-grid-wrap">
                    <div class="cal-weekdays-row">
                      <div class="cal-wday">Sun</div><div class="cal-wday">Mon</div><div class="cal-wday">Tue</div>
                      <div class="cal-wday">Wed</div><div class="cal-wday">Thu</div><div class="cal-wday">Fri</div><div class="cal-wday">Sat</div>
                    </div>
                    <div class="cal-days-row" id="calDays"></div>
                  </div>
                  <div class="cal-legend-row">
                    <div class="leg-item"><div class="leg-dot gold"></div> Single Booking</div>
                    <div class="leg-item"><div class="leg-dot red"></div> Multiple Bookings</div>
                    <div class="leg-item"><div class="leg-dot blue"></div> Today</div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4">
                <div class="ct-card h-100" style="display:flex;flex-direction:column">
                  <div class="ct-card-header">
                    <div class="ct-card-title"><i class="bi bi-lightning-charge-fill"></i> Upcoming Bookings</div>
                    <span style="font-size:11px;color:#8a92a6">Next 6</span>
                  </div>
                  <div id="upcomingList" style="overflow-y:auto;flex:1"></div>
                </div>
              </div>
            </div>

            <!-- BOOKINGS TABLE -->
            <div class="ct-card">
              <div class="ct-table-toolbar">
                <div class="ct-card-title"><i class="bi bi-table"></i> All Bookings</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                    <span class="ct-card-title" >Show:</span>
                     <select id="pageSizeSelect" onchange="setPageSize(this.value)" style="background:#f4f6f9;border:1px solid #e2e6ea;border-radius:6px;padding:4px 8px;font-size:12px;color:#495057;cursor:pointer;outline:none;font-family:inherit;">
      <option value="5">5 / page</option>
      <option value="15" selected>15 / page</option>
      <option value="25">25 / page</option>
    </select>
                  <div class="ct-search-wrap">
                    
                    <i class="bi bi-search"></i>
                    <input class="ct-search" type="text" placeholder="Search bookings..." id="tableSearch" oninput="filterTable()"/>
                  </div>
                  <button class="ct-filter-btn active" onclick="setFilter('all',this)">All</button>
                  <button class="ct-filter-btn" onclick="setFilter('Pending',this)">Pending</button>
                  <button class="ct-filter-btn" onclick="setFilter('Info Sent',this)">Info Sent</button>
                  <button class="ct-filter-btn" onclick="setFilter('Confirmed',this)">Confirmed</button>               
                  <button class="ct-filter-btn" onclick="setFilter('Cancelled',this)">Cancelled</button>
                  <button class="ct-filter-btn" onclick="setFilter('Reminder Sent',this)">Reminder Sent</button>
                  <button class="ct-filter-btn" onclick="setFilter('Payment Done',this)">Payment Done</button>

                  <button class="ct-filter-btn" onclick="setFilter('Delivered',this)">Delivered</button>
                  
                </div>
              </div>
              <div style="overflow-x:auto">
                <table class="ct-table">
                  <thead>
                    <tr>
                      <th>ID</th><th>Client</th><th>Package Selected</th><th>Date</th>
                      <th>Guests</th><th>Venue</th><th>Amount</th><th>Status</th><th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="tableBody"></tbody>
                </table>
              </div>
             <div class="ct-table-footer">
  <div style="display:flex;align-items:center;gap:10px">
    <span id="tableCount">Showing all bookings</span>
  
  </div>
  <div class="pag-wrap" id="pagWrap"></div>
</div>
            </div>

          </div>
       
      
      
    <!-- EDIT MODAL -->
    <div class="ct-modal-overlay" id="editModal" onclick="closeEditBg(event)">
      <div class="ct-modal" style="max-width:520px">
        <div class="ct-modal-header">
          <div class="ct-modal-close" onclick="closeEdit()"><i class="bi bi-x-lg"></i></div>
          <div class="modal-bk-id" id="eMId"></div>
          <div class="modal-bk-name" style="font-size:16px">Edit Booking</div>
        </div>
        <div class="ct-modal-body" style="padding:18px 24px">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Client Name</label>
              <input id="eClient" class="ct-edit-input" type="text"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Contact</label>
              <input id="eContact" class="ct-edit-input" type="text"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Event Type</label>
              <input id="eType" class="ct-edit-input" type="text"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Date</label>
              <input id="eDate" class="ct-edit-input" type="date"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Time</label>
              <input id="eTime" class="ct-edit-input" type="text"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Guests</label>
              <input id="eGuests" class="ct-edit-input" type="number" min="1"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Venue</label>
              <input id="eVenue" class="ct-edit-input" type="text"/>
            </div>
            <div>
              <label class="dg-label" style="display:block;margin-bottom:4px">Amount</label>
              <input id="eAmount" class="ct-edit-input" type="text"/>
            </div>
            <div style="grid-column:span 2">
              <label class="dg-label" style="display:block;margin-bottom:4px">Status</label>
              <select id="eStatus" class="ct-edit-input">
                <option>Confirmed</option>
                <option>Pending</option>
                <option>Cancelled</option>
                <option>Payment Done</option>
                <option>Reminder Sent</option>
                <option>Delivered</option>
              </select>
            </div>
          </div>
          <label class="dg-label" style="display:block;margin-bottom:4px">Special Notes</label>
          <textarea id="eNotes" class="ct-edit-input" rows="3" style="resize:vertical"></textarea>
        </div>
      
      </div>
    </div>

    <!-- CONFIRM DIALOG -->
    <div class="ct-modal-overlay" id="confirmDialog" style="z-index:99999">
      <div class="ct-modal" style="max-width:380px">
        <div class="ct-modal-header" style="padding:18px 20px 14px">
          <div class="ct-modal-close" onclick="closeConfirmDialog()"><i class="bi bi-x-lg"></i></div>
          <div style="display:flex;align-items:center;gap:10px;margin-top:4px">
            <div id="confirmDialogIcon" style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0"></div>
            <div>
              <div class="modal-bk-name" style="font-size:15px" id="confirmDialogTitle"></div>
              <div style="font-size:12px;color:#6c757d;margin-top:2px" id="confirmDialogMsg"></div>
            </div>
          </div>
          
        </div>
        <div class="ct-modal-footer" style="padding:12px 20px">
          <button class="btn-ct btn-ct-outline" onclick="closeConfirmDialog()">No, Go Back</button>
          <button class="btn-ct" id="confirmDialogBtn" onclick="confirmDialogYes()"></button>
        </div>
      </div>
    </div>

    <!-- BOOKING MODAL -->
    <div class="ct-modal-overlay" id="ctModal" onclick="closeModalBg(event)">
      <div class="ct-modal">
        <div class="ct-modal-header">
          <div class="ct-modal-close" onclick="closeModal()"><i class="bi bi-x-lg"></i></div>
          <div class="modal-bk-id" id="mId"></div>
          <div class="modal-bk-name" id="mName"></div>
          <div class="modal-bk-sub">
            <i class="bi bi-calendar3 text-primary"></i><span id="mDate"></span>
            <span class="text-muted">|</span>
          <i class="bi bi-geo-alt text-primary"></i><span id="mVenue"></span>
            <span class="text-muted">|</span>
            <span id="mStatusBadge" class="row-badge"></span>
          </div>
        </div>
        <div class="ct-modal-body">
          <div class="detail-grid-2">
            <div class="dg-item"><div class="dg-label">Selected Package</div><div class="dg-value" id="mType"></div></div>
            <div class="dg-item"><div class="dg-label">Guests</div><div class="dg-value" id="mGuests"></div></div>
            <div class="dg-item"><div class="dg-label">Contact</div><div class="dg-value" id="mContact"></div></div>
            <div class="dg-item"><div class="dg-label">Amount</div><div class="dg-value amount-highlight" id="mAmount"></div></div>
            <div class="dg-item"><div class="dg-label">Time</div><div class="dg-value" id="mTime"></div></div>
            <div class="dg-item"><div class="dg-label">Booked On</div><div class="dg-value" id="mBookedOn"></div></div>
          </div>

          <div class="modal-sub-title"><i class="bi bi-egg-fried"></i> Items</div>
          <div class="menu-tags-wrap" id="mMenu1"></div>
          <div class="modal-sub-title"><i class="bi bi-egg-fried"></i> AddOns</div>
          <div class="menu-tags-wrap" id="mMenu"></div>
        
        
          <div id="mKidsSection" style="display:none;">
              <div class="modal-sub-title">
                  <i class="bi bi-emoji-smile"></i> Kids Package
                  <span id="mKidsCount" style="font-size:11px;color:#007bff;margin-left:6px;text-transform:none;letter-spacing:0;font-weight:600;"></span>
              </div>
              <div class="menu-tags-wrap" id="mKidsItems"></div>
          </div>
    

          <div class="modal-sub-title"><i class="bi bi-chat-left-text"></i> Special Notes</div>
          <div class="notes-text" id="mNotes"></div>
          <!--<div class="modal-sub-title"><i class="bi bi-clock-history"></i> Activity Timeline</div>
          <div class="ct-timeline" id="mTimeline"></div>-->


<!-- SEND INFO PANEL -->
<div id="sendInfoPanel" style="display:none; margin-top:4px; margin-bottom:4px;">
  <div class="modal-sub-title"><i class="bi bi-whatsapp" style="color:#25d366"></i> Send Booking Info</div>
  <div style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:9px;padding:14px 16px;">
    <label class="dg-label" style="display:block;margin-bottom:6px;color:#166534">
      Delivery Charge
    </label>
    <input
      id="sendInfoDeliveryInput"
      class="ct-edit-input"
      type="number"
      min="0"
      placeholder="Enter delivery charge..."
      style="border-color:#86efac;background:#fff;"
    />
 
  </div>
</div>
          <!-- ADVANCE PAYMENT PANEL (shown when Confirming) -->
<div id="advancePanel" style="display:none; margin-top:4px; margin-bottom:4px;">
  <div class="modal-sub-title"><i class="bi bi-cash-stack"></i> Advance Payment</div>
  <div style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:9px;padding:14px 16px;">
    <label class="dg-label" style="display:block;margin-bottom:6px;color:#166534">
      Amount Paid in Advance 
    </label>
    <input
      id="advanceAmountInput"
      class="ct-edit-input"
      type="number"
      min="0"
      placeholder="Enter advance amount received..."
      style="border-color:#86efac;background:#fff;"
    />
    <div style="font-size:11px;color:#6c757d;margin-top:6px">
      <i class="bi bi-info-circle"></i>
      Advanced amount must be >=50% of total.
    </div>
  </div>

  <!-- Delivery charge input (shown only for delivery orders) -->
<div id="deliveryChargeField" style="display:none; margin-top:12px;">
    <label class="dg-label" style="display:block;margin-bottom:6px;color:#1a6fa8">
        Delivery Charge to Send via WhatsApp
    </label>
    <input
        id="deliveryChargeInput"
        class="ct-edit-input"
        type="number"
        min="0"
        placeholder="Enter delivery charge amount..."
        style="border-color:#93c5fd;background:#fff;"
    />
    <div style="font-size:11px;color:#6c757d;margin-top:6px">
        <i class="bi bi-whatsapp" style="color:#25d366"></i>
        This amount will be sent to the customer via WhatsApp.
    </div>
</div>
</div>

<!-- REMAINING PAYMENT PANEL (shown when marking Payment Done) -->
<div id="remainingPanel" style="display:none; margin-top:4px; margin-bottom:4px;">
  <div class="modal-sub-title"><i class="bi bi-cash-coin"></i> Remaining Payment</div>
  <div style="background:#faf5ff;border:1.5px solid #c4b5fd;border-radius:9px;padding:14px 16px;">
    <label class="dg-label" style="display:block;margin-bottom:6px;color:#6d28d9">
      Amount Being Paid Now 
    </label>
    <input
      id="remainingAmountInput"
      class="ct-edit-input"
      type="number"
      min="0"
      placeholder="Enter amount received..."
      style="border-color:#c4b5fd;background:#fff;"
    />
    <div id="remainingBreakdown" style="font-size:11px;color:#6c757d;margin-top:6px">
      <i class="bi bi-info-circle"></i>
      Edit if partial . 
    </div>
  </div>
</div>
        </div>
<div class="ct-modal-footer" style="flex-direction:column;align-items:stretch;gap:10px">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap">
    <div style="display:flex;gap:8px">
      <button class="btn-ct btn-ct-danger" id="btnCancelBooking" onclick="actionCancel()">
        <i class="bi bi-x-circle"></i> Cancel Booking
      </button>
    </div>
    <div style="display:flex;gap:8px">
      <!-- added the sent info button here -->
      <button class="btn-ct btn-ct-info" id="btnSendInfo" onclick="actionSendInfo()">
        <i class="bi bi-whatsapp"></i> <span id="sendInfoBtnLabel">Send Info</span>
      </button>
      <button class="btn-ct btn-ct-primary" id="btnConfirmBooking" onclick="actionConfirm()">
        <i class="bi bi-check-circle"></i> <span id="confirmBtnLabel">Confirm Booking</span>
      </button>
      <button class="btn-ct btn-ct-payment" id="btnPaymentDone" onclick="actionPaymentDone()">
        <i class="bi bi-cash-coin"></i> <span id="paymentBtnLabel">Payment Done</span>
      </button>
      <button class="btn-ct btn-ct-reminder" id="btnSendReminder" onclick="actionSendReminder()">
        <i class="bi bi-whatsapp"></i> Send Reminder
      </button>
      <button class="btn-ct btn-ct-delivered" id="btnMarkDelivered" onclick="actionMarkDelivered()">
        <i class="bi bi-truck"></i> Delivered
      </button>
    </div>
  </div>
</div>
      </div>
    </div>

    <!-- TOAST -->
    <div id="ctToast" style="position:fixed;bottom:24px;right:24px;z-index:99999;display:none">
      <div style="background:#1a2035;color:#fff;padding:12px 18px;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,0.2);display:flex;align-items:center;gap:10px;min-width:260px;font-size:13px;font-family:'DM Sans',sans-serif">
        <span id="ctToastIcon" style="font-size:16px"></span>
        <span id="ctToastMsg"></span>
      </div>
    </div>



    <style>
      .ct-edit-input { width:100%; background:#f8fafc; border:1px solid #e2e6ea; border-radius:7px; padding:8px 12px; font-size:13px; color:#1a2035; outline:none; font-family:'DM Sans',sans-serif; transition:border-color 0.15s; }
      .ct-edit-input:focus { border-color:#007bff; background:#fff; }
      textarea.ct-edit-input { padding:8px 12px; }
    </style>
    <script>
       const bookings = @json($bookings);
    </script>
       <script>
        const UPDATE_STATUS_URL    = "{{ route('admin.update-status') }}";
        const RESERVATION_EDIT_URL = "{{ route('reservation') }}";
    </script>
   
    <script src="{{ asset('web/js/dashboard.js') }}"></script>



     <style>
     
      .app-main { background: #f4f6f9; }
      .app-content { background: #f4f6f9; padding: 24px 24px 60px; font-family: 'DM Sans','Source Sans 3',sans-serif; }

      /* STAT CARDS */
      .catering-stat { background:#fff; border-radius:10px; border:1px solid #e8ecf0; padding:20px 20px 16px; position:relative; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform 0.18s,box-shadow 0.18s; }
      .catering-stat:hover { transform:translateY(-2px); box-shadow:0 6px 24px rgba(0,0,0,0.10); }
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
      .stat-trend { position:absolute; top:18px; right:16px; font-size:11px; font-weight:600; padding:2px 8px; border-radius:20px; display:flex; align-items:center; gap:2px; }
      .trend-up   { background:#e9f7ec; color:#28a745; }
      .trend-warn { background:#fff8e1; color:#e6a817; }

      /* SECTION CARD */
      .ct-card { background:#fff; border-radius:10px; border:1px solid #e8ecf0; box-shadow:0 1px 6px rgba(0,0,0,0.05); overflow:hidden; }
      .ct-card-header { padding:16px 20px; border-bottom:1px solid #f0f2f5; display:flex; align-items:center; justify-content:space-between; }
      .ct-card-title { font-size:14px; font-weight:600; color:#1a2035; display:flex; align-items:center; gap:7px; }
      .ct-card-title i { color:#007bff; }

      /* CALENDAR */
      .cal-btn { width:28px; height:28px; border-radius:6px; background:#f4f6f9; border:1px solid #e2e6ea; color:#495057; font-size:13px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.15s; }
      .cal-btn:hover { background:#007bff; color:#fff; border-color:#007bff; }
      .cal-month-label { font-size:15px; font-weight:700; color:#1a2035; min-width:150px; text-align:center; }
      .cal-grid-wrap { padding:12px 20px 16px; }
      .cal-weekdays-row { display:grid; grid-template-columns:repeat(7,1fr); gap:3px; margin-bottom:6px; }
      .cal-wday { text-align:center; font-size:10px; font-weight:600; color:#adb5bd; text-transform:uppercase; letter-spacing:0.5px; padding:4px 0; }
      .cal-days-row { display:grid; grid-template-columns:repeat(7,1fr); gap:3px; }
      .cal-cell { aspect-ratio:1; display:flex; flex-direction:column; align-items:center; justify-content:center; border-radius:7px; font-size:12.5px; color:#495057; cursor:pointer; position:relative; transition:all 0.13s; min-height:36px; }
      .cal-cell:hover { background:#f0f4ff; }
      .cal-cell.empty { cursor:default; pointer-events:none; }
      .cal-cell.today { background:#e8f0fe; color:#007bff; font-weight:700; border:1.5px solid #007bff; }
      .cal-cell.has-booking { background:#fff8e1; color:#9b7c1a; font-weight:600; border:1.5px solid #f0c040; }
      .cal-cell.has-booking:hover { background:#fef3c7; transform:scale(1.09); box-shadow:0 3px 12px rgba(201,168,76,0.3); z-index:2; }
      .cal-cell.multi-booking { background:#fdecea; color:#c0392b; font-weight:600; border:1.5px solid #f5a9a3; }
      .cal-cell.multi-booking:hover { background:#fce4e1; transform:scale(1.09); box-shadow:0 3px 12px rgba(220,53,69,0.2); z-index:2; }
      .cal-dot { width:4px; height:4px; border-radius:50%; position:absolute; bottom:4px; background:#c9a84c; }
      .multi-booking .cal-dot { background:#dc3545; }
      .cal-multi-badge { position:absolute; top:3px; right:3px; width:14px; height:14px; border-radius:50%; background:#dc3545; color:#fff; font-size:8px; font-weight:700; display:flex; align-items:center; justify-content:center; }
      .cal-legend-row { display:flex; gap:16px; flex-wrap:wrap; padding:10px 20px 16px; border-top:1px solid #f0f2f5; }
      .leg-item { display:flex; align-items:center; gap:5px; font-size:11px; color:#6c757d; }
      .leg-dot { width:10px; height:10px; border-radius:3px; }
      .leg-dot.gold { background:#c9a84c; } .leg-dot.red { background:#dc3545; } .leg-dot.blue { background:#007bff; }

      /* UPCOMING */
      .upcoming-item { display:flex; align-items:flex-start; gap:12px; padding:12px 20px; border-bottom:1px solid #f5f7fa; cursor:pointer; transition:background 0.13s; }
      .upcoming-item:hover { background:#f8faff; }
      .upcoming-item:last-child { border-bottom:none; }
      .up-date-box { min-width:40px; text-align:center; background:#f4f6f9; border-radius:7px; padding:5px 4px; border:1px solid #e2e6ea; }
      .up-day { font-size:16px; font-weight:700; color:#1a2035; line-height:1; }
      .up-mon { font-size:9px; text-transform:uppercase; letter-spacing:1px; color:#8a92a6; }
      .up-info { flex:1; min-width:0; }
      .up-name { font-size:13px; font-weight:600; color:#1a2035; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
      .up-meta { font-size:11px; color:#8a92a6; margin-top:2px; }
      .up-badge { font-size:10px; font-weight:600; padding:2px 8px; border-radius:20px; white-space:nowrap; align-self:flex-start; margin-top:2px; text-transform:uppercase; letter-spacing:0.4px; }
      .ub-confirmed { background:#e9f7ec; color:#28a745; }
      .ub-pending   { background:#fff8e1; color:#e6a817; }
      .ub-cancelled { background:#fdecea; color:#dc3545; }
      

      /* TABLE */
      .ct-table-toolbar { padding:14px 20px; border-bottom:1px solid #f0f2f5; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
      .ct-search-wrap { position:relative; }
      .ct-search-wrap i { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#adb5bd; font-size:13px; }
      .ct-search { background:#f4f6f9; border:1px solid #e2e6ea; border-radius:7px; padding:7px 12px 7px 32px; font-size:13px; color:#495057; width:210px; outline:none; font-family:inherit; }
      .ct-search:focus { border-color:#007bff; background:#fff; }
      .ct-filter-btn { padding:6px 14px; border-radius:6px; background:#f4f6f9; border:1px solid #e2e6ea; font-size:12px; font-weight:500; color:#6c757d; cursor:pointer; transition:all 0.13s; font-family:inherit; }
      .ct-filter-btn:hover { background:#e8f0fe; color:#007bff; border-color:#b3d0ff; }
      .ct-filter-btn.active { background:#007bff; color:#fff; border-color:#007bff; }
      .ct-table { width:100%; border-collapse:collapse; }
      .ct-table thead th { padding:11px 16px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.7px; color:#8a92a6; background:#f8fafc; border-bottom:1px solid #edf0f5; text-align:left; white-space:nowrap; }
      .ct-table tbody tr { border-bottom:1px solid #f5f7fa; transition:background 0.12s; cursor:pointer; }
      .ct-table tbody tr:hover { background:#f8faff; }
      .ct-table tbody tr:last-child { border-bottom:none; }
      .ct-table td { padding:13px 16px; font-size:13px; color:#3d4a5c; vertical-align:middle; }
      .td-mute { color:#adb5bd; font-size:12px; }
      .client-cell { display:flex; align-items:center; gap:9px; }
      .cli-avatar { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
      .cli-name { font-weight:600; color:#1a2035; font-size:13px; }
      .cli-email { font-size:11px; color:#adb5bd; }
      .amount-col { font-weight:700; color:#1a2035; }
      .row-badge { font-size:10px; font-weight:600; padding:3px 9px; border-radius:20px; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; }
      .rb-confirmed { background:#e9f7ec; color:#28a745; }
      .rb-pending   { background:#fff8e1; color:#e6a817; }
      .rb-cancelled { background:#fdecea; color:#dc3545; }
      .rb-paymentdone  { background:#ede9fe; color:#7c3aed; }
      .ub-paymentdone  { background:#ede9fe; color:#7c3aed; }
      .row-actions { display:flex; gap:5px; }
      .row-action-btn { width:27px; height:27px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:12px; cursor:pointer; transition:all 0.13s; border:1px solid #e2e6ea; background:transparent; }
      .rab-view { color:#007bff; } .rab-view:hover { background:#e8f0fe; border-color:#b3d0ff; }
      .rab-edit { color:#28a745; } .rab-edit:hover { background:#e9f7ec; border-color:#a3d9af; }
      .rab-del  { color:#dc3545; } .rab-del:hover  { background:#fdecea; border-color:#f5a9a3; }
      .ct-table-footer { padding:12px 20px; border-top:1px solid #f0f2f5; display:flex; align-items:center; justify-content:space-between; font-size:12px; color:#8a92a6; }
      .pag-wrap { display:flex; gap:4px; }
      .pag-btn { width:28px; height:28px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:12px; cursor:pointer; background:#f4f6f9; border:1px solid #e2e6ea; color:#6c757d; transition:all 0.13s; }
      .pag-btn:hover { background:#e8f0fe; color:#007bff; border-color:#b3d0ff; }
      .pag-btn.active { background:#007bff; color:#fff; border-color:#007bff; font-weight:600; }

      /* MODAL */
      .ct-modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(4px); z-index:9999; display:none; align-items:center; justify-content:center; padding:16px; }
      .ct-modal-overlay.open { display:flex; animation:ctFadeIn 0.18s ease; }
      @keyframes ctFadeIn { from{opacity:0} to{opacity:1} }
      @keyframes ctSlideUp { from{opacity:0;transform:translateY(24px) scale(0.98)} to{opacity:1;transform:none} }
      .ct-modal { background:#fff; border-radius:12px; width:100%; max-width:660px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.18); animation:ctSlideUp 0.22s ease; }
      .ct-modal-header { padding:22px 24px 18px; border-bottom:1px solid #f0f2f5; position:relative; background:linear-gradient(135deg,#f8faff 0%,#fff 100%); }
      .ct-modal-header::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#007bff,#66b2ff); border-radius:12px 12px 0 0; }
      .ct-modal-close { position:absolute; top:16px; right:18px; width:30px; height:30px; border-radius:7px; background:#f4f6f9; border:1px solid #e2e6ea; color:#6c757d; font-size:14px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.13s; }
      .ct-modal-close:hover { background:#fdecea; color:#dc3545; border-color:#f5a9a3; }
      .modal-bk-id   { font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#007bff; margin-bottom:4px; }
      .modal-bk-name { font-size:20px; font-weight:700; color:#1a2035; margin-bottom:5px; }
      .modal-bk-sub  { font-size:12.5px; color:#6c757d; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
      .ct-modal-body { padding:20px 24px; }
      .detail-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:18px; }
      .dg-item { background:#f8fafc; border:1px solid #edf0f5; border-radius:8px; padding:10px 12px; }
      .dg-label { font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:#adb5bd; margin-bottom:3px; }
      .dg-value { font-size:13.5px; font-weight:500; color:#1a2035; }
      .dg-value.amount-highlight { color:#007bff; font-weight:700; }
      .modal-sub-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#adb5bd; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
      .modal-sub-title::after { content:''; flex:1; height:1px; background:#f0f2f5; }
      .menu-tags-wrap { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:16px; }
      .menu-tag-pill { padding:4px 11px; border-radius:20px; font-size:12px; background:#f4f6f9; border:1px solid #e2e6ea; color:#3d4a5c; }
      .notes-text { background:#f8fafc; border:1px solid #edf0f5; border-radius:8px; padding:11px 14px; font-size:12.5px; color:#3d4a5c; line-height:1.65; margin-bottom:16px; }
      .ct-timeline { position:relative; padding-left:18px; margin-bottom:8px; }
      .ct-timeline::before { content:''; position:absolute; left:5px; top:5px; bottom:5px; width:1px; background:#e2e6ea; }
      .ctl-item { position:relative; margin-bottom:12px; padding-left:16px; }
      .ctl-dot { position:absolute; left:-13px; top:3px; width:9px; height:9px; border-radius:50%; border:2px solid #007bff; background:#fff; }
      .ctl-time { font-size:10px; color:#adb5bd; margin-bottom:1px; }
      .ctl-text { font-size:12.5px; color:#3d4a5c; }
      .ct-modal-footer { padding:14px 24px; border-top:1px solid #f0f2f5; display:flex; align-items:center; justify-content:space-between; gap:8px; background:#fafbfc; }
      .btn-ct { padding:8px 18px; border-radius:7px; font-size:13px; font-weight:500; cursor:pointer; border:none; transition:all 0.13s; display:flex; align-items:center; gap:6px; font-family:inherit; }
      .btn-ct-primary { background:#007bff; color:#fff; } .btn-ct-primary:hover { background:#0069d9; }
      .btn-ct-outline { background:transparent; border:1px solid #ced4da; color:#6c757d; } .btn-ct-outline:hover { border-color:#007bff; color:#007bff; }
      .btn-ct-danger  { background:#fdecea; border:1px solid #f5a9a3; color:#dc3545; } .btn-ct-danger:hover { background:#fbd5d1; }
      .btn-ct-payment { background:#ede9fe; border:1px solid #c4b5fd; color:#7c3aed; }
      .btn-ct-payment:hover { background:#ddd6fe; }
      .rb-infosent  { background:#e0f2fe; color:#0369a1; }
      .ub-infosent  { background:#e0f2fe; color:#0369a1; }
      .btn-ct-info { background:#e0f2fe; border:1px solid #7dd3fc; color:#0369a1; }
      .btn-ct-info:hover { background:#bae6fd; }
      .rb-remindersent { background:#fff3e0; color:#c2660a; }
      .ub-remindersent { background:#fff3e0; color:#c2660a; }
      .btn-ct-reminder { background:#fff3e0; border:1px solid #ffb74d; color:#c2660a; }
      .btn-ct-reminder:hover { background:#ffe0b2; }
      .rb-delivered { background:#e8f5e9; color:#1b5e20; }
      .ub-delivered { background:#e8f5e9; color:#1b5e20; }
      .btn-ct-delivered { background:#e8f5e9; border:1px solid #81c784; color:#2e7d32; }
      .btn-ct-delivered:hover { background:#c8e6c9; }
      

    </style>

    @endsection