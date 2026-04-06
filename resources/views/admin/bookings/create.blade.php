@extends('layouts.admin')

@section('title', 'Add Manual Booking')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.bookings.index') }}"
       class="inline-flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Bookings
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury p-8 max-w-5xl mx-auto">
    <h1 class="text-2xl font-display font-bold text-luxury-900 mb-8">
        Add New Manual Booking
    </h1>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">Please fix the following errors:</p>
                    <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.bookings.store-manual') }}">
        @csrf

        <!-- BOOKING TYPE -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-luxury-700 mb-2">Booking Type *</label>
            <select name="type" id="booking_type"
                class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
                <option value="package" {{ old('type') == 'package' ? 'selected' : '' }}>Tour Package</option>
                <option value="rentcar" {{ old('type') == 'rentcar' ? 'selected' : '' }}>Rent Car</option>
            </select>
        </div>

        <!-- CUSTOMER INFO -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-luxury-700 mb-2">Customer Name *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-luxury-700 mb-2">Email *</label>
                <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-luxury-700 mb-2">Phone *</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
            </div>
        </div>

        <!-- PACKAGE SECTION -->
        <div id="package_section" class="bg-luxury-50 rounded-2xl p-6 mb-8">
            <h3 class="font-semibold text-luxury-900 mb-4">Package Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Select Package *</label>
                    <select name="package_id" id="package_select"
                            class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                        <option value="">Select Package...</option>
                        @foreach($packages as $package)
                        <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                            {{ $package->name_en ?? $package->name ?? 'Unnamed Package' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Number of Pax *</label>
                    <select name="pax" id="pax_select"
                            class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl" disabled>
                        <option value="">Select package first</option>
                    </select>
                    <input type="hidden" id="pkg_price" value="0">
                    <input type="hidden" id="pkg_cost" value="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" id="pkg_start_date" value="{{ old('start_date') }}"
                           class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">End Date *</label>
                    <input type="date" name="end_date" id="pkg_end_date" value="{{ old('end_date') }}"
                           class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                </div>
            </div>
        </div>

        <!-- RENTCAR SECTION -->
        <div id="rentcar_section" class="bg-luxury-50 rounded-2xl p-6 mb-8 hidden">
            <h3 class="font-semibold text-luxury-900 mb-4">Rent Car Details</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Select Car *</label>
                    <select name="rent_car_id" id="rentcar_select"
                            class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                        <option value="">Select Car...</option>
                        @if(isset($rentCars))
                            @foreach($rentCars as $car)
                            <option value="{{ $car->id }}"
                                data-price="{{ $car->price_per_day }}"
                                data-cost="{{ $car->cost_price_per_day ?? 0 }}"
                                data-driver="{{ $car->driver_price_per_day ?? 0 }}"
                                {{ old('rent_car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->name }} ({{ $car->plate_number }})
                            </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Include Driver?</label>
                    <select name="with_driver" id="with_driver"
                            class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                        <option value="0" {{ old('with_driver') == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('with_driver') == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <!-- INPUT: Harga Sewa Manual -->
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Manual Price / Day</label>
                    <input type="number" name="manual_price_per_day" id="manual_price_per_day"
                           value="{{ old('manual_price_per_day') }}"
                           placeholder="Use system price if empty"
                           class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl" step="0.01">
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" id="rent_start_date" value="{{ old('start_date') }}"
                           class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">End Date *</label>
                    <input type="date" name="end_date" id="rent_end_date" value="{{ old('end_date') }}"
                           class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl">
                </div>
            </div>

            <!-- INPUT: Biaya Tambahan (Additional Charges) -->
            <div class="border-t border-luxury-200 pt-6 mt-6">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h4 class="font-semibold text-luxury-800">Biaya Tambahan (Additional Charges)</h4>
                        <p class="text-xs text-gray-500">Biaya tambahan yang ditagihkan ke penyewa (misal: Tol, Parkir, Biaya Anter).</p>
                    </div>
                    <button type="button" id="add_cost_row"
                            class="text-sm px-3 py-1.5 bg-white border border-luxury-300 rounded-lg text-luxury-700 hover:bg-luxury-100 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Charge
                    </button>
                </div>

                <div id="other_costs_container" class="space-y-3 mt-4">
                    <!-- Baris biaya dinamis akan muncul di sini -->
                </div>
            </div>
        </div>

        <!-- SUMMARY & ITEM DETAILS -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-200">
            <h3 class="font-semibold text-gray-800 mb-4">Booking Summary</h3>

            <!-- Main Totals -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-xs text-gray-500 uppercase">Grand Total</p>
                    <p class="text-xl font-bold text-green-600" id="display_total">Rp 0</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-xs text-gray-500 uppercase">Cost</p>
                    <p class="text-xl font-bold text-gray-900" id="display_cost">Rp 0</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-xs text-gray-500 uppercase">Profit</p>
                    <p class="text-xl font-bold text-red-600" id="display_profit">Rp 0</p>
                </div>
            </div>

            <!-- Breakdown Items -->
            <div id="rentcar_summary_items" class="hidden border-t border-gray-200 pt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Price Breakdown:</h4>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="pb-2">Item</th>
                            <th class="pb-2 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="summary_item_list">
                        <!-- Item Sewa & Driver akan diisi JS -->
                    </tbody>
                    <tbody id="summary_other_costs_list">
                        <!-- Biaya Tambahan akan diisi JS -->
                    </tbody>
                    <tfoot class="border-t border-gray-300">
                        <tr class="font-bold text-gray-900">
                            <td class="pt-2">Grand Total Tagihan</td>
                            <td class="pt-2 text-right" id="summary_grand_total">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Hidden Inputs untuk Controller -->
        <input type="hidden" name="subtotal" id="input_subtotal"> <!-- Sewa + Driver -->
        <input type="hidden" name="total" id="input_total">       <!-- Grand Total -->
        <input type="hidden" name="cost" id="input_cost">
        <input type="hidden" name="profit" id="input_profit">

        <!-- STATUS -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-luxury-700 mb-2">Status *</label>
            <select name="status"
                class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl">
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
        </div>

        <button type="submit"
            class="w-full py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition-colors">
            Save Booking
        </button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function() {

    // 1. Toggle Section Type
    function toggleType() {
        let type = $('#booking_type').val();
        if(type === 'package') {
            $('#package_section').removeClass('hidden');
            $('#rentcar_section').addClass('hidden');
            $('#rentcar_summary_items').addClass('hidden');

            $('#pkg_start_date, #pkg_end_date').prop('disabled', false);
            $('#rent_start_date, #rent_end_date').prop('disabled', true);

        } else {
            $('#package_section').addClass('hidden');
            $('#rentcar_section').removeClass('hidden');
            $('#rentcar_summary_items').removeClass('hidden');

            $('#pkg_start_date, #pkg_end_date').prop('disabled', true);
            $('#rent_start_date, #rent_end_date').prop('disabled', false);
        }
        resetSummary();
    }

    $('#booking_type').on('change', toggleType);
    toggleType(); // Trigger on load

    // ---------------------------------------------------------
    // LOGIC PACKAGE
    // ---------------------------------------------------------
    $('#package_select').on('change', function() {
        let packageId = $(this).val();
        let paxSelect = $('#pax_select');

        paxSelect.html('<option value="">Loading...</option>').prop('disabled', true);
        resetSummary();

        if (packageId) {
            $.ajax({
                url: '/admin/bookings/get-pricing/' + packageId,
                type: 'GET',
                success: function(data) {
                    let html = '';
                    if (data.pricing_options && data.pricing_options.length > 0) {
                        html += '<option value="">Select Pax</option>';
                        data.pricing_options.forEach(opt => {
                            let priceFormatted = numberFormat(opt.price);
                            html += `<option value="${opt.pax}" data-price="${opt.price}" data-cost="${opt.cost}">
                                        ${opt.pax} Pax - Rp ${priceFormatted} / pax
                                    </option>`;
                        });
                    } else {
                        $('#pkg_price').val(data.price || 0);
                        $('#pkg_cost').val(data.cost_price || 0);
                        html += '<option value="">Select Pax</option>';
                        for(let i=1; i<=20; i++) {
                            html += `<option value="${i}">${i} Pax</option>`;
                        }
                    }
                    paxSelect.html(html).prop('disabled', false);
                },
                error: function() {
                    paxSelect.html('<option value="">Error loading data</option>');
                }
            });
        } else {
            paxSelect.html('<option value="">Select package first</option>');
        }
    });

    $('#pax_select').on('change', function() {
        let selectedOption = $(this).find(':selected');
        let pax = $(this).val() || 0;
        let pricePerPax = selectedOption.data('price');
        let totalCost = selectedOption.data('cost');

        if (pricePerPax !== undefined) {
            let totalRevenue = pricePerPax * pax;
            let profit = totalRevenue - totalCost;
            $('#input_subtotal').val(totalRevenue);
            updateSummary(totalRevenue, totalCost, profit);
        } else {
            let price = $('#pkg_price').val() || 0;
            let cost = $('#pkg_cost').val() || 0;
            let total = price * pax;
            let totalCost = cost * pax;
            let profit = total - totalCost;
            $('#input_subtotal').val(total);
            updateSummary(total, totalCost, profit);
        }
    });

    // ---------------------------------------------------------
    // LOGIC RENT CAR (MODIFIED)
    // ---------------------------------------------------------
    let costRowIndex = 0;

    function addCostRow(desc = '', price = '') {
        costRowIndex++;
        let template = `
            <div class="grid grid-cols-12 gap-3 items-center cost-row" data-row-id="${costRowIndex}">
                <div class="col-span-5">
                    <input type="text" name="other_costs[${costRowIndex}][desc]" value="${desc}"
                           placeholder="Deskripsi (e.g: Tol, Parkir)"
                           class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm other-cost-desc">
                </div>
                <div class="col-span-5">
                    <input type="number" name="other_costs[${costRowIndex}][price]" value="${price}"
                           placeholder="Harga" step="0.01"
                           class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm other-cost-price">
                </div>
                <div class="col-span-2 text-center">
                    <button type="button" class="remove-cost-row text-red-500 hover:text-red-700 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        $('#other_costs_container').append(template);

        // Tambah baris di summary
        $('#summary_other_costs_list').append(`
            <tr class="other-cost-item hidden" data-row-id="${costRowIndex}">
                <td class="py-1 text-gray-600 other-cost-desc-display">${desc}</td>
                <td class="py-1 text-right text-gray-600 other-cost-price-display">Rp 0</td>
            </tr>
        `);
    }

    $('#add_cost_row').on('click', function() {
        addCostRow();
    });

    $(document).on('click', '.remove-cost-row', function() {
        let rowId = $(this).closest('.cost-row').data('row-id');
        $(this).closest('.cost-row').remove();
        $(`.other-cost-item[data-row-id="${rowId}"]`).remove();
        recalculateRentCar();
    });

    // Event Listener
    $('#rentcar_select, #with_driver, #rent_start_date, #rent_end_date, #manual_price_per_day').on('change input', recalculateRentCar);

    $(document).on('input', '.other-cost-desc, .other-cost-price', function() {
        let row = $(this).closest('.cost-row');
        let rowId = row.data('row-id');
        let desc = row.find('.other-cost-desc').val();
        let price = parseFloat(row.find('.other-cost-price').val()) || 0;

        let summaryRow = $(`.other-cost-item[data-row-id="${rowId}"]`);

        if(summaryRow.length === 0) {
             $('#summary_other_costs_list').append(`
                <tr class="other-cost-item" data-row-id="${rowId}">
                    <td class="py-1 text-gray-600 other-cost-desc-display">${desc}</td>
                    <td class="py-1 text-right text-gray-600 other-cost-price-display">Rp ${numberFormat(price)}</td>
                </tr>
            `);
        } else {
            summaryRow.find('.other-cost-desc-display').text(desc || 'Biaya Tambahan');
            summaryRow.find('.other-cost-price-display').text('Rp ' + numberFormat(price));
        }

        if(price > 0 || desc) {
             summaryRow.removeClass('hidden');
        } else {
             summaryRow.addClass('hidden');
        }

        recalculateRentCar();
    });

    function recalculateRentCar() {
        let selected = $('#rentcar_select').find(':selected');

        // Data Dasar Sistem
        let systemCarPrice = selected.data('price') || 0;
        let carCost = selected.data('cost') || 0; // Biaya internal (untuk profit calculation)
        let systemDriverPrice = selected.data('driver') || 0;
        let withDriver = $('#with_driver').val() == '1';

        // Input Manual
        let manualPriceInput = $('#manual_price_per_day').val();
        let manualPrice = parseFloat(manualPriceInput) || 0;

        let start = $('#rent_start_date').val();
        let end = $('#rent_end_date').val();

        // Reset Tabel Summary
        $('#summary_item_list').html('');

        let days = 0;
        let baseRentRevenue = 0; // Ini adalah "Harga Sewa" (baik manual maupun sistem)

        if (start && end) {
            let startDate = new Date(start);
            let endDate = new Date(end);

            if (endDate >= startDate) {
                let diffTime = Math.abs(endDate - startDate);
                days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                // -------------------------------------------------------
                // LOGIKA PERHITUNGAN HARGA SEWA (REVENUE)
                // -------------------------------------------------------
                let carName = selected.text() || 'Car Rental';

                // 1. Cek apakah ada input Manual Price?
                if (manualPrice > 0) {
                    // KASUS MANUAL: Gunakan Harga Manual.
                    // Asumsi: Harga manual sudah final untuk sewa (termasuk driver jika ada).
                    baseRentRevenue = manualPrice * days;

                    $('#summary_item_list').append(`
                        <tr>
                            <td class="py-1 text-gray-700">${carName} (Manual Price) x ${days} Days</td>
                            <td class="py-1 text-right text-gray-700">Rp ${numberFormat(baseRentRevenue)}</td>
                        </tr>
                    `);
                } else {
                    // KASUS SISTEM: Gunakan logika standar (Mobil + Driver terpisah)
                    let carPart = systemCarPrice * days;
                    let driverPart = 0;

                    if (withDriver && systemDriverPrice > 0) {
                        driverPart = systemDriverPrice * days;
                    }

                    baseRentRevenue = carPart + driverPart;

                    // Tampilkan detail
                    if(carPart > 0) {
                        $('#summary_item_list').append(`
                            <tr>
                                <td class="py-1 text-gray-700">${carName} x ${days} Days</td>
                                <td class="py-1 text-right text-gray-700">Rp ${numberFormat(carPart)}</td>
                            </tr>
                        `);
                    }
                    if (driverPart > 0) {
                        $('#summary_item_list').append(`
                            <tr>
                                <td class="py-1 text-gray-700">Driver x ${days} Days</td>
                                <td class="py-1 text-right text-gray-700">Rp ${numberFormat(driverPart)}</td>
                            </tr>
                        `);
                    }
                }

                // -------------------------------------------------------
                // HITUNG BIAYA TAMBAHAN
                // -------------------------------------------------------
                let totalAdditionalCharges = 0;
                $('.other-cost-price').each(function() {
                    let val = $(this).val();
                    if (val && !isNaN(val)) {
                        totalAdditionalCharges += parseFloat(val);
                    }
                });

                // -------------------------------------------------------
                // GRAND TOTAL = HARGA SEWA + BIAYA TAMBAHAN
                // -------------------------------------------------------
                let grandTotal = baseRentRevenue + totalAdditionalCharges;

                // -------------------------------------------------------
                // COST & PROFIT (Internal Calculation)
                // Cost tetap diambil dari data sistem, bukan manual price
                // -------------------------------------------------------
                let baseCost = carCost * days;
                let profit = grandTotal - baseCost;

                // Update Tampilan
                $('#summary_grand_total').text('Rp ' + numberFormat(grandTotal));

                // Update Hidden Inputs untuk Controller
                $('#input_subtotal').val(baseRentRevenue);   // Subtotal adalah harga sewa
                $('#input_total').val(grandTotal);           // Total adalah Grand Total final
                $('#input_cost').val(baseCost);
                $('#input_profit').val(profit);

                // Update Kotak Besar
                updateSummary(grandTotal, baseCost, profit);
            } else {
                resetSummary();
            }
        } else {
            resetSummary();
        }
    }

    // ---------------------------------------------------------
    // HELPER FUNCTIONS
    // ---------------------------------------------------------
    function resetSummary() {
        updateSummary(0,0,0);
        $('#summary_item_list').html('');
        $('#summary_grand_total').text('Rp 0');
        $('#input_subtotal').val(0);
        $('#input_total').val(0);
        $('.other-cost-item').remove();
    }

    function updateSummary(total, cost, profit) {
        $('#display_total').text('Rp ' + numberFormat(total));
        $('#display_cost').text('Rp ' + numberFormat(cost));
        $('#display_profit').text('Rp ' + numberFormat(profit));

        $('#input_total').val(total);
        $('#input_cost').val(cost);
        $('#input_profit').val(profit);
    }

    function numberFormat(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
});
</script>
@endsection
