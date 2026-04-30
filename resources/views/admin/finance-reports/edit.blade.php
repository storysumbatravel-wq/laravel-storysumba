{{-- resources/views/admin/finance-reports/edit.blade.php --}}

@extends('layouts.admin')

@section('title', 'Edit Transaksi - Finance Report')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    <div class="mb-6">
        <a href="{{ route('admin.finance-reports.index') }}" class="inline-flex items-center gap-2 text-[#484848] hover:text-[#111111] text-sm mb-4">
            <span class="iconify" data-icon="solar:arrow-left-linear" data-width="18"></span>
            Kembali ke Laporan
        </a>
        <h1 class="text-2xl font-bold text-[#111111]">Edit Transaksi</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.finance-reports.update', $financeReport->id) }}" method="POST" class="bg-white rounded-xl border border-[#E1E1E1] p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Item --}}
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Item / Keterangan</label>
                <input type="text" name="item" value="{{ old('item', $financeReport->item) }}"
                       class="w-full border border-[#E1E1E1] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
            </div>

            {{-- Month --}}
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Bulan</label>
                <select name="month" class="w-full border border-[#E1E1E1] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
                    @foreach($months as $m)
                        <option value="{{ $m }}" {{ old('month', $financeReport->month) == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Dates --}}
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Tanggal Mulai</label>
                <input type="date" name="rental_start_date" value="{{ old('rental_start_date', $financeReport->rental_start_date->format('Y-m-d')) }}"
                       class="w-full border border-[#E1E1E1] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
            </div>
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Tanggal Selesai</label>
                <input type="date" name="rental_end_date" value="{{ old('rental_end_date', $financeReport->rental_end_date->format('Y-m-d')) }}"
                       class="w-full border border-[#E1E1E1] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
            </div>

            <div class="md:col-span-2 border-t border-dashed my-2 pt-4">
                <p class="font-semibold text-[#111111] mb-2">Data Finansial</p>
            </div>

            {{-- Rental Price --}}
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Rental Price (Per Hari)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="rental_price" value="{{ old('rental_price', $financeReport->rental_price) }}" min="0"
                           class="w-full border border-[#E1E1E1] rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
                </div>
            </div>

            {{-- Expenses --}}
            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Expense BBM</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="expense_bbm" value="{{ old('expense_bbm', $financeReport->expense_bbm) }}" min="0"
                           class="w-full border border-[#E1E1E1] rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
                </div>
            </div>

            <div>
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Expense Operational</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="expense_operational" value="{{ old('expense_operational', $financeReport->expense_operational) }}" min="0"
                           class="w-full border border-[#E1E1E1] rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]" required>
                </div>
            </div>

            {{-- Notes --}}
            <div class="md:col-span-2">
                <label class="block text-xs text-[#484848] uppercase tracking-wider mb-2">Catatan</label>
                <textarea name="notes" rows="2"
                          class="w-full border border-[#E1E1E1] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#E8B03F]">{{ old('notes', $financeReport->notes) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-[#E1E1E1]">
            <a href="{{ route('admin.finance-reports.index') }}"
               class="px-6 py-2.5 border border-[#E1E1E1] rounded-full text-sm font-medium text-[#484848] hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 bg-[#E8B03F] text-[#111111] rounded-full text-sm font-medium hover:bg-[#d4a03a] transition-colors">
                Update Transaksi
            </button>
        </div>
    </form>

</div>
@endsection
