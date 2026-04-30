{{-- resources/views/admin/finance-reports/pdf.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Finance Report - Storysumba Travel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            padding: 15px;
            color: #111;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #1B3B36;
            color: white;
            padding: 5px 3px;
            text-align: center;
            font-size: 8px;
            vertical-align: middle;
        }
        td {
            padding: 4px 3px;
            border-bottom: 1px solid #ddd;
            font-size: 8px;
            vertical-align: middle;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Row Styles */
        .month-header {
            background-color: #E8B03F;
            color: #111;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }
        .subtotal-row {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-row {
            background-color: #FFF8E7;
            font-weight: bold;
            border-top: 2px solid #E8B03F;
        }

        /* Utility */
        .whitespace-nowrap { white-space: nowrap; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Finance Report</h1>
        <p>Storysumba Travel - Tahun {{ $year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">ITEM</th>
                <th rowspan="2">MONTH</th>
                <th rowspan="2">RENTAL DATE</th>
                <th rowspan="2">DUR</th>
                <th rowspan="2">PRICE</th>
                <th rowspan="2">INCOME</th>
                <!-- Expense Header -->
                <th colspan="3" style="background-color: #2a554e;">EXPENSE</th>
                <th rowspan="2">GRAND TOTAL</th>
                <th rowspan="2">FEE 25%</th>
                <th rowspan="2">NET PROFIT</th>
            </tr>
            <tr>
                <th style="background-color: #3a6b64;">BBM</th>
                <th style="background-color: #3a6b64;">OP.</th>
                <th style="background-color: #3a6b64;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $monthsOrder = ['December', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'];
                $monthNames = App\Models\RentalTransaction::getMonthsIndonesian();
            @endphp

            @forelse($groupedTransactions->sortKeysUsing(function($a, $b) use ($monthsOrder) {
                return array_search($a, $monthsOrder) <=> array_search($b, $monthsOrder);
            }) as $month => $items)

                {{-- Month Header (13 columns) --}}
                <tr>
                    <td colspan="13" class="month-header">{{ strtoupper($monthNames[$month] ?? $month) }}</td>
                </tr>

                @foreach($items as $t)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $t->item }}</td>
                        <td class="text-center">{{ $monthNames[$t->month] ?? $t->month }}</td>
                        <td class="text-center whitespace-nowrap">{{ $t->rental_date_range }}</td>
                        <td class="text-center">{{ $t->duration }}</td>

                        <td class="text-right">{{ number_format($t->rental_price, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($t->income, 0, ',', '.') }}</td>

                        <td class="text-right">{{ number_format($t->expense_bbm, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($t->expense_operational, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($t->total_expense, 0, ',', '.') }}</td>

                        <td class="text-right">{{ number_format($t->grand_total, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($t->fee, 0, ',', '.') }}</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($t->net_profit, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                {{-- Subtotal (13 columns) --}}
                @php $subtotal = $monthlySubtotals[$month]; @endphp
                <tr class="subtotal-row">
                    <td colspan="4">Subtotal</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{ number_format($subtotal['income'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($items->sum('expense_bbm'), 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($items->sum('expense_operational'), 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($subtotal['total_expense'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($subtotal['grand_total'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($subtotal['fee'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($subtotal['net_profit'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center" style="padding: 20px;">Tidak ada data</td>
                </tr>
            @endforelse

            @if($transactions->count() > 0)
                {{-- Grand Total Footer (13 columns) --}}
                <tr class="total-row">
                    <td colspan="4" class="text-right" style="padding-right: 5px;">GRAND TOTAL</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{ number_format($grandTotal['income'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($transactions->sum('expense_bbm'), 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($transactions->sum('expense_operational'), 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($grandTotal['total_expense'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($grandTotal['grand_total'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($grandTotal['fee'], 0, ',', '.') }}</td>
                    <td class="text-right" style="font-size: 9px;">{{ number_format($grandTotal['net_profit'], 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: center; font-size: 8px; color: #666;">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>
