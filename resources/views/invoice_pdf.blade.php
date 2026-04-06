<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 40px;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Header Styles */
        .header-top {
            border-bottom: 3px solid #c53030;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-container {
            display: inline-block;
            vertical-align: middle;
        }
        .company-info {
            display: inline-block;
            vertical-align: middle;
            margin-left: 15px;
        }
        .logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #c53030;
            letter-spacing: -0.5px;
        }
        .invoice-title-block {
            text-align: right;
            float: right;
        }
        .invoice-label {
            font-size: 36px;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
            text-transform: uppercase;
        }
        .invoice-code {
            font-size: 14px;
            color: #6b7280;
            font-weight: 600;
        }

        /* Layout Helpers */
        .clearfix::after { content: ""; clear: both; display: table; }
        .flex-left { float: left; width: 48%; }
        .flex-right { float: right; width: 48%; text-align: right; }

        /* Section Styles */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .content-text {
            color: #374151;
            line-height: 1.6;
        }

        /* Table Styles */
        .table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .table thead th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: 700;
            font-size: 11px;
            padding: 12px;
            border-bottom: 2px solid #e5e7eb;
            text-transform: uppercase;
        }
        .table tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid #f3f4f6;
            color: #1f2937;
        }
        .total-row td {
            background-color: #f9fafb;
            font-weight: bold;
            font-size: 13px;
        }
        .grand-total td {
            background-color: #c53030;
            color: #fff !important;
            font-size: 16px;
            border: none;
        }

        /* Payment Info Box */
        .payment-box {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin-top: 30px;
            border-radius: 6px;
        }
        .payment-box h4 {
            margin: 0 0 10px 0;
            color: #92400e;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .bank-detail {
            margin-bottom: 5px;
            color: #78350f;
        }
        .bank-detail strong {
            color: #92400e;
            min-width: 80px;
            display: inline-block;
        }

        /* Footer & Disclaimer */
        .footer {
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .disclaimer {
            font-size: 9px;
            color: #9ca3af;
            font-style: italic;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            color: white;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
        }
        .bg-green { background-color: #10b981; }
        .bg-red { background-color: #ef4444; }

        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="header-top clearfix">
            <div class="flex-left">
                <div class="logo-container">
                    @php
                        $logoPath = public_path('images/logo-aurora.png');
                        $logoSrc = '';
                        if (file_exists($logoPath)) {
                            $data = file_get_contents($logoPath);
                            $logoSrc = 'data:image/png;base64,' . base64_encode($data);
                        }
                    @endphp
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="Logo" style="height: 55px; width: auto;">
                    @else
                        <div style="height: 55px; width: 55px; background: #c53030; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; border-radius: 8px;">A</div>
                    @endif
                </div>
                <div class="company-info">
                    <div class="logo-text">{{ $companyName }}</div>
                    <div style="margin-top: 4px; color: #6b7280; font-size: 11px; line-height: 1.4;">
                        {{ $companyAddress }}<br>
                        {{ $companyPhone }}
                    </div>
                </div>
            </div>

            <div class="invoice-title-block">
                <h1 class="invoice-label">Invoice</h1>
                <div class="invoice-code">#{{ $booking->booking_code }}</div>
                <div style="margin-top: 15px;">
                    <strong>Date:</strong> {{ $date }}<br>
                    <strong>Status:</strong>
                    @if($booking->status == 'confirmed' || $booking->status == 'paid')
                        <span class="badge bg-green">{{ ucfirst($booking->status) }}</span>
                    @else
                        <span class="badge bg-red">{{ ucfirst($booking->status) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bill To & Booking Info -->
        <div class="clearfix">
            <div class="flex-left">
                <div class="section-title">Billed To</div>
                <div class="content-text">
                    <strong>{{ $booking->customer_name }}</strong><br>
                    {{-- {{ $booking->customer_email }}<br>
                    {{ $booking->customer_phone }} --}}
                </div>
            </div>
            <div class="flex-right">
                <div class="section-title">Booking Details</div>
                <div class="content-text">
                    <strong>Type:</strong> {{ ucfirst($booking->type) }}<br>
                    <strong>Start Date:</strong> {{ $booking->start_date?->format('d M Y') ?? '-' }}<br>
                    <strong>End Date:</strong> {{ $booking->end_date?->format('d M Y') ?? '-' }}
                </div>
            </div>
        </div>

        <!-- Table Items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right" style="width: 15%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Unit Price</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong style="font-size: 13px;">
                            @if($booking->type === 'package' && $booking->package)
                                {{ $booking->package->name }}
                            @elseif($booking->type === 'rentcar' && $booking->rentCar)
                                {{ $booking->rentCar->name }}
                            @else
                                Manual Booking
                            @endif
                        </strong>
                        <div style="font-size: 10px; color: #9ca3af; margin-top: 4px;">Reference ID: {{ $booking->id }}</div>
                    </td>
                    <td class="text-right">{{ $booking->pax ?? 1 }} Pax</td>
                    <td class="text-right">
                        @php
                            $pax = $booking->pax ?? 1;
                            $unitPrice = ($pax > 0) ? $booking->total / $pax : $booking->total;
                        @endphp
                        Rp {{ number_format($unitPrice, 0, ',', '.') }}
                    </td>
                    <td class="text-right">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right">Subtotal</td>
                    <td class="text-right">Rp {{ number_format($booking->subtotal ?? $booking->total, 0, ',', '.') }}</td>
                </tr>
                <!-- Bisa tambahkan baris pajak/diskon di sini jika ada -->
                <tr class="grand-total">
                    <td colspan="3" class="text-right" style="padding: 15px 12px;">Grand Total</td>
                    <td class="text-right" style="padding: 15px 12px;">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Payment Instructions -->
        <div class="payment-box">
            <h4>Payment Instructions</h4>
            <div class="bank-detail">
                <strong>Bank Name:</strong> Bank Mandiri
            </div>
            <div class="bank-detail">
                <strong>Account No:</strong> 129.00.10273312
            </div>
            <div class="bank-detail">
                <strong>Account Name:</strong> PT Vismaya Visual Indonesia
            </div>
            <div style="margin-top: 10px; font-size: 10px; color: #92400e;">
                Please transfer the exact amount and confirm your payment via WhatsApp or Admin Panel.
            </div>
        </div>

        <!-- Footer & Disclaimer -->
        <div class="footer">
            <div class="disclaimer">
                Dokumen ini adalah invoice yang dihasilkan secara otomatis oleh sistem komputer dan sah tanpa memerlukan tanda tangan basah atau cap stempel perusahaan.
            </div>
            <p style="margin: 0; color: #6b7280; font-weight: 600;">Thank you for choosing {{ $companyName }}!</p>
            <p style="margin: 5px 0 0 0; color: #9ca3af; font-size: 10px;">Have a wonderful trip.</p>
        </div>
    </div>
</body>
</html>
