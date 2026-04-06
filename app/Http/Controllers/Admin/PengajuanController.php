<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;                 // ✅ TAMBAHAN
use Illuminate\Support\Facades\File;        // ✅ TAMBAHAN

class PengajuanController extends Controller
{
    // =======================
    // INDEX
    // =======================
    public function index()
    {
        $pengajuans = Pengajuan::latest()->get();
        return view('admin.pengajuans.index', compact('pengajuans'));
    }

    // =======================
    // CREATE
    // =======================
    public function create()
    {
        return view('admin.pengajuans.create');
    }

    // =======================
    // STORE (CREATE DATA)
    // =======================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'nama_kegiatan' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'jumlah_personil' => 'required|integer',
            'kendaraan' => 'required|string',
            'nama_pengaju' => 'required|string',
            'nama_menyyetujui' => 'required|string',
            'tujuan_dana' => 'nullable|string',

            // Rincian Pendapatan
            'pendapatan_uraian.*' => 'required_with:pendapatan_jumlah.*|string',
            'pendapatan_perhitungan.*' => 'nullable|string',
            'pendapatan_jumlah.*' => 'nullable|numeric',

            // Rincian Pengajuan
            'pengajuan_uraian.*' => 'required_with:pengajuan_jumlah.*|string',
            'pengajuan_perhitungan.*' => 'nullable|string',
            'pengajuan_jumlah.*' => 'nullable|numeric',

            // ✅ VALIDASI TTD
            'ttd_pengaju' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // =======================
        // UPLOAD TTD
        // =======================
        $ttdPath = null;

        if ($request->hasFile('ttd_pengaju')) {

            $file = $request->file('ttd_pengaju');

            $filename = 'ttd_' .
                Str::slug($request->nama_pengaju) .
                '_' . time() .
                '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/ttd');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            $ttdPath = 'uploads/ttd/' . $filename;
        }

        // =======================
        // RINCIAN PENDAPATAN
        // =======================
        $rincianPendapatan = [];
        $totalPendapatan = 0;

        if ($request->pendapatan_uraian) {
            foreach ($request->pendapatan_uraian as $i => $item) {
                if (!empty($item)) {
                    $jumlah = (int) str_replace('.', '', $request->pendapatan_jumlah[$i] ?? 0);

                    $rincianPendapatan[] = [
                        'uraian' => $item,
                        'perhitungan' => $request->pendapatan_perhitungan[$i] ?? '',
                        'jumlah' => $jumlah,
                    ];

                    $totalPendapatan += $jumlah;
                }
            }
        }

        // =======================
        // RINCIAN PENGAJUAN
        // =======================
        $rincianPengajuan = [];
        $totalPengajuan = 0;

        if ($request->pengajuan_uraian) {
            foreach ($request->pengajuan_uraian as $i => $item) {
                if (!empty($item)) {
                    $jumlah = (int) str_replace('.', '', $request->pengajuan_jumlah[$i] ?? 0);

                    $rincianPengajuan[] = [
                        'uraian' => $item,
                        'perhitungan' => $request->pengajuan_perhitungan[$i] ?? '',
                        'jumlah' => $jumlah,
                    ];

                    $totalPengajuan += $jumlah;
                }
            }
        }

        // =======================
        // SIMPAN DATA
        // =======================
        Pengajuan::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tujuan' => $request->tujuan,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah_personil' => $request->jumlah_personil,
            'kendaraan' => $request->kendaraan,
            'nama_pengaju' => $request->nama_pengaju,
            'nama_menyyetujui' => $request->nama_menyyetujui,
            'tujuan_dana' => $request->tujuan_dana,
            'rincian_pendapatan' => $rincianPendapatan,
            'rincian_pengajuan' => $rincianPengajuan,
            'total_pendapatan' => $totalPendapatan,
            'total_pengajuan' => $totalPengajuan,
            'ttd_pengaju' => $ttdPath, // ✅ SIMPAN PATH
        ]);

        return redirect()
            ->route('admin.pengajuans.index')
            ->with('success', 'Pengajuan berhasil dibuat');
    }

    // =======================
    // EDIT
    // =======================
    public function edit(Pengajuan $pengajuan)
    {
        return view('admin.pengajuans.edit', compact('pengajuan'));
    }

    // =======================
    // UPDATE
    // =======================
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'ttd_pengaju' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // =======================
        // UPDATE TTD
        // =======================
        $ttdPath = $pengajuan->ttd_pengaju;

        if ($request->hasFile('ttd_pengaju')) {

            // Hapus file lama
            if ($pengajuan->ttd_pengaju &&
                File::exists(public_path($pengajuan->ttd_pengaju))) {

                File::delete(public_path($pengajuan->ttd_pengaju));
            }

            $file = $request->file('ttd_pengaju');

            $filename = 'ttd_' .
                Str::slug($request->nama_pengaju) .
                '_' . time() .
                '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/ttd');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            $ttdPath = 'uploads/ttd/' . $filename;
        }

        // =======================
        // RINCIAN (SAMA SEPERTI STORE)
        // =======================
        $rincianPendapatan = [];
        $totalPendapatan = 0;

        if ($request->pendapatan_uraian) {
            foreach ($request->pendapatan_uraian as $i => $item) {
                if (!empty($item)) {
                    $jumlah = (int) str_replace('.', '', $request->pendapatan_jumlah[$i] ?? 0);

                    $rincianPendapatan[] = [
                        'uraian' => $item,
                        'perhitungan' => $request->pendapatan_perhitungan[$i] ?? '',
                        'jumlah' => $jumlah,
                    ];

                    $totalPendapatan += $jumlah;
                }
            }
        }

        $rincianPengajuan = [];
        $totalPengajuan = 0;

        if ($request->pengajuan_uraian) {
            foreach ($request->pengajuan_uraian as $i => $item) {
                if (!empty($item)) {
                    $jumlah = (int) str_replace('.', '', $request->pengajuan_jumlah[$i] ?? 0);

                    $rincianPengajuan[] = [
                        'uraian' => $item,
                        'perhitungan' => $request->pengajuan_perhitungan[$i] ?? '',
                        'jumlah' => $jumlah,
                    ];

                    $totalPengajuan += $jumlah;
                }
            }
        }

        $pengajuan->update([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tujuan' => $request->tujuan,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah_personil' => $request->jumlah_personil,
            'kendaraan' => $request->kendaraan,
            'nama_pengaju' => $request->nama_pengaju,
            'nama_menyyetujui' => $request->nama_menyyetujui,
            'tujuan_dana' => $request->tujuan_dana,
            'rincian_pendapatan' => $rincianPendapatan,
            'rincian_pengajuan' => $rincianPengajuan,
            'total_pendapatan' => $totalPendapatan,
            'total_pengajuan' => $totalPengajuan,
            'ttd_pengaju' => $ttdPath,
        ]);

        return redirect()
            ->route('admin.pengajuans.index')
            ->with('success', 'Pengajuan berhasil diupdate');
    }

    // =======================
    // DELETE
    // =======================
    public function destroy(Pengajuan $pengajuan)
    {
        // Hapus file TTD jika ada
        if ($pengajuan->ttd_pengaju &&
            File::exists(public_path($pengajuan->ttd_pengaju))) {

            File::delete(public_path($pengajuan->ttd_pengaju));
        }

        $pengajuan->delete();

        return back()->with('success', 'Berhasil dihapus');
    }

    // =======================
    // PDF EXPORT
    // =======================
    public function pdf(Pengajuan $pengajuan)
    {
        $pdf = Pdf::loadView('admin.pengajuans.pdf', compact('pengajuan'));

        return $pdf->stream('pengajuan-' . $pengajuan->id . '.pdf');
    }
}
