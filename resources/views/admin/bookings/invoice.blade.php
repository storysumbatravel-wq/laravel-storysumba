<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $booking->booking_code }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 40px; }
        .header { border-bottom: 2px solid #c53030; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #c53030; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .table th { background: #f3f4f6; padding: 10px; }
        .table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total td { background: #f3f4f6; font-weight: bold; }
        .text-right { text-align: right; }
        .mt-4 { margin-top: 20px; }
        .badge { padding: 3px 8px; border-radius: 4px; color: white; font-size: 10px; text-transform: uppercase; }
        .bg-green { background-color: #38a169; }
        .bg-red { background-color: #c53030; }
        .flex-container { display: block; width: 100%; }
        .flex-left { float: left; width: 60%; }
        .flex-right { float: right; width: 40%; text-align: right; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header clearfix">
            <div class="flex-left">
                <div style="display: flex; align-items: center;">
                    @php
                        $logoPath = public_path('images/logo-aurora.png');
                        $logoSrc = '';
                        $showImage = false;
                        if (file_exists($logoPath) && extension_loaded('gd')) {
                            try {
                                $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                                $data = file_get_contents($logoPath);
                                $logoSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                $showImage = true;
                            } catch (\Exception $e) { $showImage = false; }
                        }
                    @endphp

                    @if($showImage)
                        <img src="{{ $logoSrc }}" alt="Logo" style="height: 50px; width: auto; margin-right: 15px;">
                    @else
                        <div style="height: 50px; width: 50px; background: #eee; display: inline-block; text-align: center; line-height: 50px; margin-right: 15px; font-size: 10px; color: #999;">Logo</div>
                    @endif

                    <div style="display: inline-block; vertical-align: top;">
                        <div class="logo">{{ $companyName }}</div>
                        <div style="margin-top: 5px; color: #666; font-size: 11px;">
                            {{ $companyAddress }}<br>{{ $companyPhone }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-right">
                <h1 style="margin: 0; font-size: 30px; color: #333;">INVOICE</h1>
                <h2 style="margin: 5px 0 0 0; font-size: 16px; color: #666;">#{{ $booking->booking_code }}</h2>
                <div style="margin-top: 10px;">
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

        <div class="clearfix" style="margin-bottom: 20px;">
            <div class="flex-left">
                <strong>Bill To:</strong><br>
                {{ $booking->customer_name }}<br>
                {{ $booking->customer_email }}<br>
                {{ $booking->customer_phone }}
            </div>
            <div class="flex-right">
                <strong>Booking Details:</strong><br>
                Type: {{ ucfirst($booking->type) }}<br>
                Start Date: {{ $booking->start_date?->format('d M Y') ?? '-' }}<br>
                End Date: {{ $booking->end_date?->format('d M Y') ?? '-' }}
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @if($booking->type === 'rentcar')
                    @php
                        // Hitung Hari
                        $days = 1;
                        if ($booking->start_date && $booking->end_date) {
                            $diff = $booking->start_date->diffInDays($booking->end_date);
                            $days = $diff + 1;
                        }

                        // Ambil Biaya Lainnya
                        $otherCosts = [];
                        $otherCostTotal = 0;

                        // Decode JSON dengan aman
                        if (!empty($booking->other_costs)) {
                            if (is_string($booking->other_costs)) {
                                $decoded = json_decode($booking->other_costs, true);
                                $otherCosts = is_array($decoded) ? $decoded : [];
                            } elseif (is_array($booking->other_costs) || is_object($booking->other_costs)) {
                                $otherCosts = (array) $booking->other_costs;
                            }

                            foreach($otherCosts as $cost) {
                                if(isset($cost['price'])) {
                                    $otherCostTotal += floatval($cost['price']);
                                }
                            }
                        }

                        // Hitung Harga Sewa Dasar (Total Final - Biaya Lainnya)
                        $baseRentPrice = $booking->total;
                        $dailyPrice = ($days > 0) ? $baseRentPrice / $days : 0;
                    @endphp

                    <tr>
                        <td>
                            <strong>{{ $booking->rentCar->name ?? 'Car Rental' }}</strong>
                            <div style="font-size: 10px; color: #666;">
                                {{ $booking->start_date?->format('d M Y') }} - {{ $booking->end_date?->format('d M Y') }}
                                @if($booking->with_driver)
                                    <br><span style="color:#c53030;">(With Driver)</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-right">{{ $days }} Days</td>
                        <td class="text-right">Rp {{ number_format($dailyPrice, 0, ',', '.') }}</td>
<td class="text-right">Rp {{ number_format($dailyPrice * $days, 0, ',', '.') }}</td>
                    </tr>

                    @if(count($otherCosts) > 0)
                        @foreach($otherCosts as $cost)
                            <tr>
                                <td style="background-color: #f9f9f9; padding-left: 20px;">
                                    {{ $cost['desc'] ?? 'Additional' }}
                                </td>
                                <td class="text-right" style="background-color: #f9f9f9;">1</td>
                                <td class="text-right" style="background-color: #f9f9f9;">Rp {{ number_format($cost['price'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right" style="background-color: #f9f9f9;">Rp {{ number_format($cost['price'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif

                @else
                    {{-- LOGIC FOR PACKAGE --}}
                    @php
                        $pax = $booking->pax ?? 1;
                        $unitPrice = ($pax > 0) ? $booking->total / $pax : $booking->total;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $booking->package->name ?? 'Tour Package' }}</strong>
                            <div style="font-size: 10px; color: #666;">Booking ID: {{ $booking->id }}</div>
                        </td>
                        <td class="text-right">{{ $pax }} Pax</td>
                        <td class="text-right">Rp {{ number_format($unitPrice, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="3" class="text-right">Grand Total</td>
                    <td class="text-right">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4" style="text-align: center; color: #666; font-size: 10px; border-top: 1px solid #eee; padding-top: 20px;">
            <p>Thank you for choosing {{ $companyName }}. Have a wonderful trip!</p>
            <p>This is a computer generated invoice and does not require signature.</p>
        </div>
    </div>
</body>
</html>
