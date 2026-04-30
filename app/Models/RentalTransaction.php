<?php
// app/Models/RentalTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RentalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'month',
        'rental_start_date',
        'rental_end_date',
        'rental_price', // Diubah dari rental_fee
        'expense_bbm',
        'expense_operational',
        'notes',
    ];

    protected $casts = [
        'rental_start_date' => 'date',
        'rental_end_date' => 'date',
        'rental_price' => 'decimal:2',
        'expense_bbm' => 'decimal:2',
        'expense_operational' => 'decimal:2',
    ];

    // =======================
    // ACCESSORS (KALKULASI OTOMATIS)
    // =======================

    // Duration: Selisih hari + 1 (inklusive)
    public function getDurationAttribute(): int
    {
        if (!$this->rental_start_date || !$this->rental_end_date) return 0;
        return $this->rental_start_date->diffInDays($this->rental_end_date) + 1;
    }

    // Income: Rental Price x Duration
    public function getIncomeAttribute(): float
    {
        return $this->rental_price * $this->duration;
    }

    // Total Expense: BBM + Operational
    public function getTotalExpenseAttribute(): float
    {
        return $this->expense_bbm + $this->expense_operational;
    }

    // Grand Total (Profit): Income - Total Expense
    public function getGrandTotalAttribute(): float
    {
        return $this->income - $this->total_expense;
    }

    // Fee 25%: Grand Total x 25%
    public function getFeeAttribute(): float
    {
        // Jika Grand Total negatif (rugi), fee dianggap 0
        return $this->grand_total > 0 ? $this->grand_total * 0.25 : 0;
    }

    // =======================
    // NET PROFIT (BARU)
    // =======================

    /**
     * Net Profit: Grand Total - Fee 25%
     */
    public function getNetProfitAttribute(): float
    {
        return $this->grand_total - $this->fee;
    }

    // Helper untuk display durasi
    public function getDurationLabelAttribute(): string
    {
        return $this->duration . ' Hari';
    }

    public function getRentalDateRangeAttribute(): string
    {
        $start = $this->rental_start_date->format('d');
        $end = $this->rental_end_date->format('d M Y');
        return "{$start} - {$end}";
    }

    // =======================
    // SCOPES
    // =======================

    public function scopeByMonth($query, string $month)
    {
        return $query->where('month', $month);
    }

    public function scopeByYear($query, int $year)
    {
        return $query->whereYear('rental_start_date', $year);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('rental_start_date', 'desc');
    }

    // =======================
    // STATIC HELPERS
    // =======================

    public static function getMonths(): array
    {
        return [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    }

    public static function getMonthsIndonesian(): array
    {
        return [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
    }
}
