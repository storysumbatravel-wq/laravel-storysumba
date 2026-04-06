<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat', 'tanggal_surat', 'nama_kegiatan', 'tujuan',
        'tanggal_berangkat', 'tanggal_kembali', 'jumlah_personil', 'kendaraan',
        'rincian_pendapatan', 'rincian_pengajuan',
        'total_pendapatan', 'total_pengajuan',
        'tujuan_dana', 'nama_pengaju', 'nama_menyyetujui', 'ttd_pengaju',
    ];

    protected $casts = [
        'rincian_pendapatan' => 'array',
        'rincian_pengajuan' => 'array',
        'tanggal_surat' => 'date',
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date',
    ];
}
