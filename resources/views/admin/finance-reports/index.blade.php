{{-- resources/views/admin/finance-reports/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Revisi Rekap Finance Report - Storysumba Travel')

@section('content')
<div class="max-w-[1700px] mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#111111] tracking-tight">
                    Revisi Rekap Finance Report
                </h1>
                <p class="text-[#484848] text-sm mt-1">Storysumba Travel</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.finance-reports.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-[#1B3B36] text-white rounded-full text-sm font-medium hover:bg-[#2a554e] transition-colors">
                    <span class="iconify" data-icon="solar:add-circle-linear" data-width="18"></span>
                    Tambah Transaksi
                </a>
                <a href="{{ route('admin.finance-reports.export', request()->query()) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E1E1E1] rounded-full text-sm font-medium text-[#111111] hover:bg-gray-50 transition-colors">
                    <span class="iconify" data-icon="solar:download-linear" data-width="18"></span>
                    Export CSV
                </a>
                 <a href="{{ route('admin.finance-reports.pdf', request()->query()) }}"
                   target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E1E1E1] rounded-full text-sm font-medium text-[#111111] hover:bg-gray-50 transition-colors">
                    <span class="iconify" data-icon="solar:printer-linear" data-width="18"></span>
                    Print PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl p-4 border border-[#E1E1E1] mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-1">Tahun</label>
                <select name="year" class="border border-[#E1E1E1] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                    @if($availableYears->isEmpty())
                        <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                    @endif
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-[#E8B03F] text-[#111111] rounded-lg text-sm font-medium hover:bg-[#d4a03a] transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.finance-reports.index') }}" class="px-4 py-2 bg-gray-100 text-[#484848] rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Reset
            </a>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-[#E1E1E1]">
            <p class="text-xs text-[#484848] uppercase tracking-wider mb-1">Total Income</p>
            <p class="text-lg font-bold text-green-600">Rp {{ number_format($grandTotal['income'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-[#E1E1E1]">
            <p class="text-xs text-[#484848] uppercase tracking-wider mb-1">Total Expense</p>
            <p class="text-lg font-bold text-red-500">Rp {{ number_format($grandTotal['total_expense'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-[#E1E1E1]">
            <p class="text-xs text-[#484848] uppercase tracking-wider mb-1">Grand Total (Gross)</p>
            <p class="text-lg font-bold text-blue-600">Rp {{ number_format($grandTotal['grand_total'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-[#E1E1E1]">
            <p class="text-xs text-[#484848] uppercase tracking-wider mb-1">Total Fee (25%)</p>
            <p class="text-lg font-bold text-[#E8B03F]">Rp {{ number_format($grandTotal['fee'], 0, ',', '.') }}</p>
        </div>
        {{-- CARD NET PROFIT BARU --}}
        <div class="bg-[#1B3B36] rounded-xl p-4 text-white">
            <p class="text-xs uppercase tracking-wider mb-1 opacity-80">NET PROFIT</p>
            <p class="text-xl font-bold">Rp {{ number_format($grandTotal['net_profit'], 0, ',', '.') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-[#E1E1E1] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs md:text-sm">
                <thead>
                    <tr>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold w-10 align-middle">NO</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">ITEM</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">MONTH</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">RENTAL DATE</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">DURATION</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">RENTAL PRICE</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">INCOME</th>
                        <th colspan="3" class="bg-[#1B3B36] text-white px-2 py-1 text-center font-semibold border-x border-[#2a554e]">EXPENSE</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">GRAND TOTAL</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">FEE 25%</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle bg-opacity-90">NET PROFIT</th>
                        <th rowspan="2" class="bg-[#1B3B36] text-white px-2 py-2 text-center font-semibold align-middle">ACTION</th>
                    </tr>
                    <tr>
                        <th class="bg-[#2a554e] text-white px-2 py-1 text-center font-semibold">BBM</th>
                        <th class="bg-[#2a554e] text-white px-2 py-1 text-center font-semibold">OP.</th>
                        <th class="bg-[#2a554e] text-white px-2 py-1 text-center font-semibold">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $monthsOrder = ['December', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'];
                        $no = 1;
                        $monthNames = App\Models\RentalTransaction::getMonthsIndonesian();
                    @endphp

                    @forelse($groupedTransactions->sortKeysUsing(function($a, $b) use ($monthsOrder) {
                        return array_search($a, $monthsOrder) <=> array_search($b, $monthsOrder);
                    }) as $month => $items)

                        {{-- Month Header (14 columns) --}}
                        <tr>
                            <td colspan="14" class="bg-[#E8B03F] text-[#111111] text-center font-bold py-2 uppercase text-sm">
                                {{ $monthNames[$month] ?? $month }}
                            </td>
                        </tr>

                        {{-- Transaction Rows --}}
                        @foreach($items as $transaction)
                            <tr class="border-l-4 border-[#E8B03F] hover:bg-gray-50 transition-colors">
                                <td class="text-center px-2 py-2 border-b border-[#E1E1E1]">{{ $no++ }}</td>
                                <td class="px-2 py-2 border-b border-[#E1E1E1]">{{ $transaction->item }}</td>
                                <td class="text-center px-2 py-2 border-b border-[#E1E1E1]">{{ $monthNames[$transaction->month] ?? $transaction->month }}</td>
                                <td class="text-center px-2 py-2 border-b border-[#E1E1E1] whitespace-nowrap">{{ $transaction->rental_date_range }}</td>
                                <td class="text-center px-2 py-2 border-b border-[#E1E1E1]">{{ $transaction->duration_label }}</td>
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1]">Rp {{ number_format($transaction->rental_price, 0, ',', '.') }}</td>
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-green-600 font-medium">Rp {{ number_format($transaction->income, 0, ',', '.') }}</td>

                                {{-- Expenses --}}
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-red-500">Rp {{ number_format($transaction->expense_bbm, 0, ',', '.') }}</td>
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-red-500">Rp {{ number_format($transaction->expense_operational, 0, ',', '.') }}</td>
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-red-600 font-medium">Rp {{ number_format($transaction->total_expense, 0, ',', '.') }}</td>

                                {{-- Results --}}
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] font-bold {{ $transaction->grand_total >= 0 ? 'text-blue-600' : 'text-red-700' }}">
                                    Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-[#E8B03F] font-bold">
                                    Rp {{ number_format($transaction->fee, 0, ',', '.') }}
                                </td>

                                {{-- NET PROFIT COLUMN --}}
                                <td class="text-right px-2 py-2 border-b border-[#E1E1E1] font-bold text-[#1B3B36] bg-green-50 bg-opacity-50">
                                    Rp {{ number_format($transaction->net_profit, 0, ',', '.') }}
                                </td>

                                {{-- ACTION COLUMN --}}
                                <td class="text-center px-2 py-2 border-b border-[#E1E1E1]">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.finance-reports.edit', $transaction->id) }}"
                                           class="p-1.5 text-blue-600 hover:text-white hover:bg-blue-500 rounded transition-all duration-200"
                                           title="Edit">
                                            <span class="iconify" data-icon="solar:pen-linear" data-width="16"></span>
                                        </a>
                                        <form action="{{ route('admin.finance-reports.destroy', $transaction->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 text-red-500 hover:text-white hover:bg-red-500 rounded transition-all duration-200"
                                                    title="Hapus">
                                                <span class="iconify" data-icon="solar:trash-bin-trash-linear" data-width="16"></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Subtotal (14 columns) --}}
                        @php $subtotal = $monthlySubtotals[$month]; @endphp
                        <tr class="bg-gray-100 font-semibold text-xs">
                            <td colspan="5" class="text-right px-2 py-2 border-b border-[#E1E1E1]">Subtotal {{ $monthNames[$month] ?? $month }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1]">Rp {{ number_format($subtotal['rental_price'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-green-600">Rp {{ number_format($subtotal['income'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1]">Rp {{ number_format($subtotal['expense_bbm'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1]">Rp {{ number_format($subtotal['expense_operational'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-red-600">Rp {{ number_format($subtotal['total_expense'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-blue-600">Rp {{ number_format($subtotal['grand_total'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-[#E8B03F]">Rp {{ number_format($subtotal['fee'], 0, ',', '.') }}</td>
                            {{-- Net Profit Subtotal --}}
                            <td class="text-right px-2 py-2 border-b border-[#E1E1E1] text-[#1B3B36]">Rp {{ number_format($subtotal['net_profit'], 0, ',', '.') }}</td>
                            <td class="border-b border-[#E1E1E1]"></td> {{-- Empty Action --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center py-8 text-[#484848]">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="iconify text-gray-300" data-icon="solar:document-text-linear" data-width="48"></span>
                                    <p>Belum ada data transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    @if($transactions->count() > 0)
                        {{-- Grand Total Footer (14 columns) --}}
                        <tr class="bg-[#FFF8E7] font-bold border-t-2 border-[#E8B03F]">
                            <td colspan="5" class="text-right px-2 py-3">GRAND TOTAL</td>
                            <td class="text-right px-2 py-3">Rp {{ number_format($grandTotal['rental_price'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-3 text-green-600">Rp {{ number_format($grandTotal['income'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-3 text-red-500">Rp {{ number_format($grandTotal['expense_bbm'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-3 text-red-500">Rp {{ number_format($grandTotal['expense_operational'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-3 text-red-600">Rp {{ number_format($grandTotal['total_expense'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-3 text-blue-600">Rp {{ number_format($grandTotal['grand_total'], 0, ',', '.') }}</td>
                            <td class="text-right px-2 py-3 text-[#E8B03F]">Rp {{ number_format($grandTotal['fee'], 0, ',', '.') }}</td>
                            {{-- Net Profit Grand Total --}}
                            <td class="text-right px-2 py-3 text-[#1B3B36] text-lg">Rp {{ number_format($grandTotal['net_profit'], 0, ',', '.') }}</td>
                            <td class="px-2 py-3"></td> {{-- Empty Action --}}
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
