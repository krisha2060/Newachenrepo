{{-- resources/views/admin/printall.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Bookings Report – {{ $from }} to {{ $to }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { 
            box-sizing:border-box; 
            margin:0; 
            padding:0;
        }
        body { background:#f5f5f5; font-family:'DM Sans',Arial,sans-serif; }
        .print-doc {
            font-family:'DM Sans',Arial,sans-serif; color:#1a1a1a; background:#ffffff;
            padding:32px 36px; max-width:1100px; margin:20px auto;
            border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }
        .print-logo-row {
            display:flex; align-items:center; justify-content:space-between;
            border-bottom:2px solid #333; padding-bottom:14px; margin-bottom:22px;
        }
        .print-logo-name { font-size:20px; font-weight:800; color:#1a1a1a; letter-spacing:-0.5px; }
        .print-logo-sub { font-size:11px; color:#666; margin-top:2px; }
        .print-doc-title { font-size:13px; font-weight:700; color:#1a1a1a; }
        .print-doc-sub { font-size:11px; color:#666; }
        
        .summary-stats {
            display:grid; grid-template-columns:repeat(4, 1fr);
            gap:12px; margin-bottom:24px;
        }
        .stat-card {
            background:#fafafa; border:1px solid #ddd; border-radius:8px;
            padding:16px; text-align:center;
        }
        .stat-num { font-size:26px; font-weight:700; color:#1a1a1a; }
        .stat-label { font-size:10px; font-weight:600; text-transform:uppercase;
            letter-spacing:0.7px; color:#666; margin-top:5px; }
        
        .print-all-table {
            width:100%; border-collapse:collapse; font-size:11px; margin-top:12px;
        }
        .print-all-table th {
            background:#f0f0f0; color:#000000; padding:10px 12px; text-align:left;
            font-size:10px; text-transform:uppercase; letter-spacing:0.6px;
            border-bottom:2px solid #ddd;
        }
        .print-all-table td {
            padding:10px 12px; border-bottom:1px solid #eee; vertical-align:top; color:#000000;
        }
        .print-all-table tr:nth-child(even) td { background:#fafafa; }
        .print-all-table .items-col { font-size:10px; color:#000000; line-height:1.5; }
        
        .row-badge {
            display:inline-block; padding:3px 9px; border-radius:20px;
            font-size:9px; font-weight:600; text-transform:uppercase;
            background:#e8e8e8; color:#333; border:1px solid #ccc;
        }

        .no-amount-note {
            background:#f0f0f0; border:1px dashed #bbb; border-radius:6px;
            padding:8px 14px; font-size:11px; color:#555;
            margin-bottom:18px; display:inline-block;
        }
        
        .print-footer {
            margin-top:24px; padding-top:12px; border-top:1px solid #ddd;
            font-size:10px; color:#000000; display:flex; justify-content:space-between;
        }
        
        .print-btn {
            display:flex; gap:10px; justify-content:flex-end; padding:16px 36px;
            max-width:1100px; margin:0 auto 20px;
        }
        .print-btn button {
            padding:8px 20px; border-radius:7px; font-size:13px; font-weight:500;
            cursor:pointer; border:1px solid #ccc; font-family:'DM Sans',Arial,sans-serif;
            transition:all 0.13s; background:#fff; color:#333;
        }
        .btn-pr { background:#1a1a1a; color:#fff; border:none; }
        .btn-pr:hover { background:#333; }
        .btn-ex { background:#fff; color:#333; border:1px solid #ccc; }
        .btn-ex:hover { background:#f0f0f0; }
        .btn-cl { background:#fff; border:1px solid #ccc; color:#333; }
        .btn-cl:hover { background:#f0f0f0; }
        
        @media print {
            body { background:#fff; }
            .print-doc { margin:0; border-radius:0; box-shadow:none; padding:20px; }
            .print-btn { display:none; }
            tr { page-break-inside:avoid; break-inside:avoid; }
            .print-all-table th { background:#e8e8e8; }
            .print-all-table tr:nth-child(even) td { background:#f5f5f5; }
        }
    </style>
</head>
<body>
    @php
        // show_amount: default true; pass ?show_amount=0 to hide amounts
        $showAmount = request('show_amount', '1') !== '0';

        // Filter bookings by ids if provided (comma-separated list from JS)
        $idsParam = request('ids');
        if ($idsParam) {
            $allowedIds = explode(',', $idsParam);
            $bookings   = collect($bookings)->filter(fn($b) => in_array($b['id'], $allowedIds))->values()->all();
        }

        // Recompute stats from the filtered set
        $total     = count($bookings);
        $confirmed = count(array_filter($bookings, fn($b) => $b['status'] === 'Confirmed'));
        $paid      = count(array_filter($bookings, fn($b) => $b['status'] === 'Payment Done'));
        $revenue   = array_sum(array_map(fn($b) => $b['status'] === 'Payment Done' ? ($b['amountRaw'] ?? 0) : 0, $bookings));

        // Status label for header badge
        $statusLabel = request('status') ? request('status') : null;
    @endphp

    <div class="print-btn">
        <button class="btn-cl" onclick="window.close()">Close</button>
        <!-- <button class="btn-ex" onclick="exportToExcel()"><i class="bi bi-file-earmark-spreadsheet"></i> Export Excel</button> -->
        <button class="btn-pr" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
    </div>
    
    <div class="print-doc">
        <div class="print-logo-row">
            <div>
                <div class="print-logo-name">NewaChen</div>
                <div class="print-logo-sub">Bookings Report{{ $statusLabel ? ' · ' . $statusLabel : '' }}</div>
            </div>
            <div style="text-align:right">
                <div class="print-doc-title">Date Range: {{ date('M d, Y', strtotime($from)) }} – {{ date('M d, Y', strtotime($to)) }}</div>
                <div class="print-doc-sub">Printed: {{ now()->format('M d, Y ') }}</div>
            </div>
        </div>

        @if(!$showAmount)
            <div class="no-amount-note"><i class="bi bi-eye-slash"></i> &nbsp;Amounts are hidden in this print.</div>
        @endif

        <!-- <div class="summary-stats">
            <div class="stat-card">
                <div class="stat-num">{{ $total }}</div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">{{ $confirmed }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">{{ $paid }}</div>
                <div class="stat-label">Paid</div>
            </div>
            @if($showAmount)
            <div class="stat-card">
                <div class="stat-num">${{ number_format($revenue, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
            @else
            <div class="stat-card">
                <div class="stat-num">—</div>
                <div class="stat-label">Total Revenue</div>
            </div>
            @endif
        </div> -->

        {{-- BOOKINGS TABLE --}}
        <table class="print-all-table" id="bookingsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Package</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Items</th>
                    @if($showAmount)
                    <th>Amount</th>
                    @endif
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    @php
                        $mainItems = array_merge($booking['menu1'] ?? [], $booking['menu'] ?? []);
                        $kidsItems = $booking['kids_items'] ?? [];
                        $allItems  = array_merge($mainItems, $kidsItems);
                    @endphp
                    <tr>
                        <td style="font-weight:600;font-size:10px;color:#1a1a1a">{{ $booking['id'] }}</td>
                        <td>
                            <div><strong>{{ $booking['client'] }}</strong></div>
                            <div style="color:#000000;font-size:10px">{{ $booking['contact'] }}</div>
                        </td>
                        <td>{{ $booking['type'] }}</td>
                        <td>{{ date('M d, Y', strtotime($booking['date'])) }}</td>
                        <td>{{ $booking['guests'] }}{{ isset($booking['kids_count']) && $booking['kids_count'] > 0 ? ' + ' . $booking['kids_count'] . 'Kids' : '' }}</td>
                        <td class="items-col">
                            @forelse($allItems as $item)
                                <span>{{ $item }}{{ !$loop->last ? ', ' : '' }}</span>
                            @empty
                                –
                            @endforelse
                        </td>
                        @if($showAmount)
                        <td style="font-weight:700;color:#1a1a1a">{{ $booking['amount'] }}</td>
                        @endif
                        <td>
                            <span class="row-badge">{{ $booking['status'] }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $showAmount ? 8 : 7 }}" style="text-align:center;padding:20px;color:#999">
                            No bookings found for this date range
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

     
    </div>

    <script>
        function exportToExcel() {
            const from = '{{ $from }}';
            const to   = '{{ $to }}';
            const ids  = '{{ request("ids") }}';
            window.location.href = `/admin/export-excel?from=${from}&to=${to}${ids ? '&ids=' + ids : ''}`;
        }
  
        window.onload = function() {
        window.print();
    };
       window.onafterprint = function() {
        window.close();
    };
</script>
</body>
</html>