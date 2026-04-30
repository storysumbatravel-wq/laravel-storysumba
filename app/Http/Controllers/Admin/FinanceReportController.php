<?php
// app/Http/Controllers/Admin/FinanceReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $months = $request->get('months', []);

        $query = RentalTransaction::byYear($year)->latestFirst();

        if (!empty($months)) {
            $query->whereIn('month', $months);
        }

        $transactions = $query->get();
        $groupedTransactions = $transactions->groupBy('month');

        // Calculate subtotals per month using accessors
    $monthlySubtotals = [];
    foreach ($groupedTransactions as $month => $items) {
        $monthlySubtotals[$month] = [
            'rental_price' => $items->sum('rental_price'),
            'income' => $items->sum('income'),
            'expense_bbm' => $items->sum('expense_bbm'),
            'expense_operational' => $items->sum('expense_operational'),
            'total_expense' => $items->sum('total_expense'),
            'grand_total' => $items->sum('grand_total'),
            'fee' => $items->sum('fee'),
            'net_profit' => $items->sum('net_profit'), // <-- TAMBAHKAN INI
        ];
    }

    // Calculate grand total
    $grandTotal = [
        'rental_price' => $transactions->sum('rental_price'),
        'income' => $transactions->sum('income'),
        'expense_bbm' => $transactions->sum('expense_bbm'),
        'expense_operational' => $transactions->sum('expense_operational'),
        'total_expense' => $transactions->sum('total_expense'),
        'grand_total' => $transactions->sum('grand_total'),
        'fee' => $transactions->sum('fee'),
        'net_profit' => $transactions->sum('net_profit'), // <-- TAMBAHKAN INI
    ];


        $availableYears = RentalTransaction::select(DB::raw('YEAR(rental_start_date) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.finance-reports.index', compact(
            'transactions', 'groupedTransactions', 'monthlySubtotals', 'grandTotal',
            'year', 'availableYears', 'months'
        ));
    }

    public function create()
    {
        $months = RentalTransaction::getMonths();
        return view('admin.finance-reports.create', compact('months'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'month' => 'required|string',
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
            'rental_price' => 'required|numeric|min:0',
            'expense_bbm' => 'required|numeric|min:0',
            'expense_operational' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        RentalTransaction::create($validated);

        return redirect()
            ->route('admin.finance-reports.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(RentalTransaction $financeReport)
    {
        $months = RentalTransaction::getMonths();
        return view('admin.finance-reports.edit', compact('financeReport', 'months'));
    }

    public function update(Request $request, RentalTransaction $financeReport)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'month' => 'required|string',
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
            'rental_price' => 'required|numeric|min:0',
            'expense_bbm' => 'required|numeric|min:0',
            'expense_operational' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $financeReport->update($validated);

        return redirect()
            ->route('admin.finance-reports.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(RentalTransaction $financeReport)
    {
        $financeReport->delete();
        return redirect()
            ->route('admin.finance-reports.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function export(Request $request)
    {
        // Implementation for CSV export
        $year = $request->get('year', date('Y'));
        $transactions = RentalTransaction::byYear($year)->latestFirst()->get();

        $filename = "finance-report-{$year}.csv";
        $headers = ['Content-Type' => 'text/csv'];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Item', 'Month', 'Date Range', 'Duration', 'Rental Price', 'Income', 'Exp BBM', 'Exp Op', 'Total Exp', 'Grand Total', 'Fee 25%']);

            foreach($transactions as $i => $t) {
                fputcsv($file, [
                    $i+1, $t->item, $t->month, $t->rental_date_range, $t->duration,
                    $t->rental_price, $t->income, $t->expense_bbm, $t->expense_operational,
                    $t->total_expense, $t->grand_total, $t->fee
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function pdf(Request $request)
    {
        $year = $request->get('year', date('Y'));
    $transactions = RentalTransaction::byYear($year)->latestFirst()->get();
    $groupedTransactions = $transactions->groupBy('month');

    // Hitung subtotal per bulan
    $monthlySubtotals = [];
    foreach ($groupedTransactions as $month => $items) {
        $monthlySubtotals[$month] = [
            'income' => $items->sum('income'),
            'total_expense' => $items->sum('total_expense'),
            'grand_total' => $items->sum('grand_total'),
            'fee' => $items->sum('fee'),
            'net_profit' => $items->sum('net_profit'),
        ];
    }

    // Hitung Grand Total
    $grandTotal = [
        'income' => $transactions->sum('income'),
        'total_expense' => $transactions->sum('total_expense'),
        'grand_total' => $transactions->sum('grand_total'),
        'fee' => $transactions->sum('fee'),
        'net_profit' => $transactions->sum('net_profit'),
    ];

    return view('admin.finance-reports.pdf', compact(
        'transactions',
        'groupedTransactions',
        'monthlySubtotals',
        'grandTotal',
        'year'
    ));
    }
}
