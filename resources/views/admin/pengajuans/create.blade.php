@extends('layouts.admin')

@section('title', 'Buat Pengajuan Baru')

@push('scripts')
<script>
    function addRow(tableId, type) {
        const table = document.getElementById(tableId);
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);

        row.innerHTML = `
            <td class="px-4 py-2 border">${rowCount}.</td>
            <td class="px-4 py-2 border">
                <input type="text" name="${type}_uraian[]"
                class="w-full border-0 focus:ring-0" placeholder="Uraian">
            </td>
            <td class="px-4 py-2 border">
                <input type="text" name="${type}_perhitungan[]"
                class="w-full border-0 focus:ring-0" placeholder="Perhitungan">
            </td>
            <td class="px-4 py-2 border">
                <input type="text" name="${type}_jumlah[]"
                class="w-full border-0 focus:ring-0" placeholder="Jumlah">
            </td>
            <td class="px-4 py-2 border text-center">
                <button type="button"
                onclick="this.parentElement.parentElement.remove()"
                class="text-red-500 font-bold">X</button>
            </td>
        `;
    }
</script>
@endpush

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm">

    <h2 class="text-2xl font-bold mb-6 text-luxury-900">
        Form Pengajuan Budget
    </h2>

    <form action="{{ route('admin.pengajuans.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <!-- ========================= -->
        <!-- DATA UTAMA -->
        <!-- ========================= -->

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Nomor Surat
                </label>
                <input type="text" name="nomor_surat"
                    value="001/SPJ-TRIP/{{ date('m') }}/{{ date('Y') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tanggal Surat
                </label>
                <input type="date" name="tanggal_surat"
                    value="{{ date('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">
                    Nama Kegiatan
                </label>
                <input type="text" name="nama_kegiatan"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Sewa kendaraan untuk Shooting" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tujuan</label>
                <input type="text" name="tujuan"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Pulau Sumba" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kendaraan</label>
                <input type="text" name="kendaraan"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Mobil Operasional (Toyota Hiace)" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tanggal Berangkat
                </label>
                <input type="date" name="tanggal_berangkat"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tanggal Kembali
                </label>
                <input type="date" name="tanggal_kembali"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Jumlah Personil
                </label>
                <input type="number" name="jumlah_personil"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

        </div>


        <!-- ========================= -->
        <!-- RINCIAN PENDAPATAN -->
        <!-- ========================= -->

        <div class="mb-8">
            <h3 class="text-lg font-bold mb-3 text-luxury-800">
                Rincian Pendapatan
            </h3>

            <div class="overflow-x-auto border rounded-lg">
                <table id="table-pendapatan" class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border w-10">No</th>
                            <th class="px-4 py-2 border">Uraian</th>
                            <th class="px-4 py-2 border">Perhitungan</th>
                            <th class="px-4 py-2 border">Jumlah (Rp)</th>
                            <th class="px-4 py-2 border w-10">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 border">1.</td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="pendapatan_uraian[]"
                                class="w-full border-0 focus:ring-0"
                                placeholder="Pendapatan sewa mobil">
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="pendapatan_perhitungan[]"
                                class="w-full border-0 focus:ring-0"
                                placeholder="6 Hari x 1.600.000">
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="pendapatan_jumlah[]"
                                class="w-full border-0 focus:ring-0"
                                placeholder="9.600.000">
                            </td>
                            <td class="px-4 py-2 border"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button"
                onclick="addRow('table-pendapatan','pendapatan')"
                class="mt-2 text-sm text-red-600 font-medium hover:underline">
                + Tambah Baris Pendapatan
            </button>
        </div>


        <!-- ========================= -->
        <!-- RINCIAN PENGAJUAN -->
        <!-- ========================= -->

        <div class="mb-8">
            <h3 class="text-lg font-bold mb-3 text-luxury-800">
                Rincian Pengajuan Budget
            </h3>

            <div class="overflow-x-auto border rounded-lg">
                <table id="table-pengajuan" class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border w-10">No</th>
                            <th class="px-4 py-2 border">Uraian</th>
                            <th class="px-4 py-2 border">Perhitungan</th>
                            <th class="px-4 py-2 border">Jumlah (Rp)</th>
                            <th class="px-4 py-2 border w-10">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 border">1.</td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="pengajuan_uraian[]"
                                class="w-full border-0 focus:ring-0"
                                placeholder="Bensin">
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="pengajuan_perhitungan[]"
                                class="w-full border-0 focus:ring-0"
                                placeholder="6 Hari x 1 Mobil">
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="pengajuan_jumlah[]"
                                class="w-full border-0 focus:ring-0"
                                placeholder="1.500.000">
                            </td>
                            <td class="px-4 py-2 border"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button"
                onclick="addRow('table-pengajuan','pengajuan')"
                class="mt-2 text-sm text-red-600 font-medium hover:underline">
                + Tambah Baris Pengajuan
            </button>
        </div>


        <!-- ========================= -->
        <!-- PENUTUP + TTD -->
        <!-- ========================= -->

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tujuan Penggunaan Dana
                </label>
                <textarea name="tujuan_dana" rows="3"
                    class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Dana tersebut akan digunakan untuk..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Nama Pengaju
                    </label>
                    <input type="text" name="nama_pengaju"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        value="{{ auth()->user()->name ?? 'Hasanudin' }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Menyetujui
                    </label>
                    <input type="text" name="nama_menyyetujui"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="Hapid Yusuf" required>
                </div>
            </div>

            <!-- ===== TTD PENGAJU ===== -->
            <div class="md:col-span-2 border-t pt-4 mt-2">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanda Tangan Pengaju (Upload Gambar)
                </label>

                @if(isset($pengajuan) && $pengajuan->ttd_pengaju)
                    <div class="mb-2">
                        <img src="{{ asset($pengajuan->ttd_pengaju) }}"
                             class="h-16 border bg-gray-50 p-1 rounded">
                    </div>
                @endif

                <input type="file" name="ttd_pengaju"
                    class="w-full text-sm
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-red-50 file:text-red-700
                    hover:file:bg-red-100">
            </div>

        </div>


        <!-- ========================= -->
        <!-- BUTTON -->
        <!-- ========================= -->

        <div class="flex justify-end gap-4">

            <a href="{{ route('admin.pengajuans.index') }}"
                class="px-6 py-2 border border-gray-300 rounded-lg
                       text-gray-700 hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                class="px-6 py-2 bg-red-500 text-white rounded-lg
                       hover:bg-red-600 shadow-sm">
                Simpan Pengajuan
            </button>

        </div>

    </form>
</div>
@endsection
