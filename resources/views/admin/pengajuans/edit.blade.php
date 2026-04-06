@extends('layouts.admin')

@section('title', 'Edit Pengajuan')

@push('scripts')
<script>
    function addRow(tableId, type, data = {}) {
        const table = document.getElementById(tableId);
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);

        row.innerHTML = `
            <td class="px-4 py-2 border">${rowCount}.</td>
            <td class="px-4 py-2 border"><input type="text" name="${type}_uraian[]" value="\${data.uraian || ''}" class="w-full border-0 focus:ring-0" placeholder="Uraian"></td>
            <td class="px-4 py-2 border"><input type="text" name="${type}_perhitungan[]" value="\${data.perhitungan || ''}" class="w-full border-0 focus:ring-0" placeholder="Perhitungan"></td>
            <td class="px-4 py-2 border"><input type="text" name="${type}_jumlah[]" value="\${data.jumlah || ''}" class="w-full border-0 focus:ring-0" placeholder="Jumlah"></td>
            <td class="px-4 py-2 border text-center"><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-500 font-bold">X</button></td>
        `;
    }
</script>
@endpush

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold mb-6 text-luxury-900">Edit Pengajuan Budget</h2>

    <form action="{{ route('admin.pengajuans.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ $pengajuan->nomor_surat }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                <input type="date" name="tanggal_surat" value="{{ $pengajuan->tanggal_surat->format('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" value="{{ $pengajuan->nama_kegiatan }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>
                <input type="text" name="tujuan" value="{{ $pengajuan->tujuan }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                <input type="text" name="kendaraan" value="{{ $pengajuan->kendaraan }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" value="{{ $pengajuan->tanggal_berangkat->format('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ $pengajuan->tanggal_kembali->format('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Personil</label>
                <input type="number" name="jumlah_personil" value="{{ $pengajuan->jumlah_personil }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>
        </div>

        <!-- Rincian Pendapatan -->
        <div class="mb-8">
            <h3 class="text-lg font-bold mb-3 text-luxury-800">Rincian Pendapatan</h3>
            <div class="overflow-x-auto border rounded-lg">
                <table id="table-pendapatan" class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border text-left w-10">No</th>
                            <th class="px-4 py-2 border text-left">Uraian</th>
                            <th class="px-4 py-2 border text-left">Perhitungan</th>
                            <th class="px-4 py-2 border text-left">Jumlah (Rp)</th>
                            <th class="px-4 py-2 border w-10">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Diisi oleh script dibawah -->
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addRow('table-pendapatan', 'pendapatan')" class="mt-2 text-sm text-red-600 font-medium hover:underline">+ Tambah Baris</button>
        </div>

        <!-- Rincian Pengajuan -->
        <div class="mb-8">
            <h3 class="text-lg font-bold mb-3 text-luxury-800">Rincian Pengajuan Budget</h3>
            <div class="overflow-x-auto border rounded-lg">
                <table id="table-pengajuan" class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border text-left w-10">No</th>
                            <th class="px-4 py-2 border text-left">Uraian</th>
                            <th class="px-4 py-2 border text-left">Perhitungan</th>
                            <th class="px-4 py-2 border text-left">Jumlah (Rp)</th>
                            <th class="px-4 py-2 border w-10">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Diisi oleh script dibawah -->
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addRow('table-pengajuan', 'pengajuan')" class="mt-2 text-sm text-red-600 font-medium hover:underline">+ Tambah Baris</button>
        </div>

        <!-- Penutup -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Penggunaan Dana</label>
                <textarea name="tujuan_dana" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm">{{ $pengajuan->tujuan_dana }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengaju</label>
                    <input type="text" name="nama_pengaju" value="{{ $pengajuan->nama_pengaju }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Menyetujui</label>
                    <input type="text" name="nama_menyyetujui" value="{{ $pengajuan->nama_menyyetujui }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.pengajuans.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm">Update Pengajuan</button>
        </div>
    </form>
</div>

<!-- Script untuk load data existing -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load data pendapatan existing
        @foreach($pengajuan->rincian_pendapatan as $item)
            addRow('table-pendapatan', 'pendapatan', {
                uraian: "{{ $item['uraian'] }}",
                perhitungan: "{{ $item['perhitungan'] }}",
                jumlah: "{{ $item['jumlah'] }}"
            });
        @endforeach

        // Load data pengajuan existing
        @foreach($pengajuan->rincian_pengajuan as $item)
            addRow('table-pengajuan', 'pengajuan', {
                uraian: "{{ $item['uraian'] }}",
                perhitungan: "{{ $item['perhitungan'] }}",
                jumlah: "{{ $item['jumlah'] }}"
            });
        @endforeach
    });
</script>
@endsection
