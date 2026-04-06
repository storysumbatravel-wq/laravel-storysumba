<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('nama_kegiatan');
            $table->string('tujuan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->integer('jumlah_personil');
            $table->string('kendaraan');

            // Disimpan sebagai JSON untuk fleksibilitas
            $table->json('rincian_pendapatan')->nullable();
            $table->json('rincian_pengajuan')->nullable();

            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->decimal('total_pengajuan', 15, 2)->default(0);

            $table->text('tujuan_dana')->nullable();
            $table->string('nama_pengaju');
            $table->string('nama_menyyetujui');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
};
