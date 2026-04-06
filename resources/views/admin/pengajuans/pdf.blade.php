<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Budget</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 40px; color: #333; }

        /* Header dengan Logo */
        .header-table { width: 100%; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 25px; }
        .logo-img { width: 100px; height: auto; margin-right: 15px; }
        .company-info { vertical-align: top; }
        .company-info h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .company-info p { margin: 2px 0; font-size: 11px; line-height: 1.4; }

        .section-title { text-align: center; margin: 20px 0; }
        .section-title h3 { margin: 0; font-size: 13px; font-weight: bold; text-transform: uppercase; }

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table .label { width: 150px; font-weight: 600; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #333; padding: 6px; text-align: left; }
        .data-table th { background-color: #f0f0f0; text-align: center; }
        .data-table .text-right { text-align: right; }
        .data-table .text-center { text-align: center; }

        .total-row { font-weight: bold; background-color: #f9f9f9; }

        .signature-block { margin-top: 50px; width: 100%; }
        .signatures { display: table; width: 100%; margin-top: 20px; }
        .sign-col { display: table-cell; width: 50%; text-align: center; vertical-align: top; }

        /* Style untuk TTD */
        .sign-box { height: 80px; position: relative; display: flex; justify-content: center; align-items: flex-end; }
        .ttd-img { max-height: 100px; max-width: 120px; object-fit: contain; }
        .sign-name { margin-top: 1px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <!-- Header Kop Surat dengan Logo -->
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td width="90" style="text-align: center; vertical-align: top;">
                <!-- Ganti path sesuai lokasi logo di folder public -->
                <img src="{{ public_path('images/logo-aurora.png') }}" class="logo-img" alt="Logo">
            </td>
            <td class="company-info">
                <h2>CV. AURORA SUMBA</h2>
                <p>Jl. Rambu Duka, RT 026/RW 009, Kelurahan Prailiu,</p>
                <p>Kecamatan Kambera, Kabupaten Sumba Timur, NTT</p>
                <p>Telepon / wa: +62 812-4699-4982</p>
            </td>
        </tr>
    </table>

    <!-- Judul Surat -->
    <div class="section-title">
        <h3>LAPORAN PENGAJUAN BUDGET BIAYA BENSIN & OPERASIONAL TRIP & TRAVEL STORYSUMBA</h3>
        <br>
        <table style="margin-top: 10px; text-align: left;">
            <tr>
                <td style="width: 80px;">Nomor</td>
                <td>: {{ $pengajuan->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $pengajuan->tanggal_surat->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Data Perjalanan -->
    <p style="font-weight: bold; text-decoration: underline;">Data Perjalanan</p>
    <table class="info-table">
        <tr><td class="label">Nama Kegiatan</td><td>: {{ $pengajuan->nama_kegiatan }}</td></tr>
        <tr><td class="label">Tujuan</td><td>: {{ $pengajuan->tujuan }}</td></tr>
        <tr><td class="label">Tanggal Berangkat</td><td>: {{ $pengajuan->tanggal_berangkat->format('d F Y') }}</td></tr>
        <tr><td class="label">Tanggal Kembali</td><td>: {{ $pengajuan->tanggal_kembali->format('d F Y') }}</td></tr>
        <tr><td class="label">Jumlah Personil</td><td>: {{ $pengajuan->jumlah_personil }} Orang</td></tr>
        <tr><td class="label">Kendaraan</td><td>: {{ $pengajuan->kendaraan }}</td></tr>
    </table>

    <!-- Rincian Pendapatan -->
    <p style="font-weight: bold;">Rincian Pendapatan</p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Uraian</th>
                <th>Perhitungan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan->rincian_pendapatan as $i => $item)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $item['uraian'] }}</td>
                <td>{{ $item['perhitungan'] }}</td>
                <td class="text-right">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-center">Total Pendapatan</td>
                <td class="text-right">Rp {{ number_format($pengajuan->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Rincian Pengajuan -->
    <p style="font-weight: bold;">Rincian Pengajuan Budget</p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Uraian</th>
                <th>Perhitungan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan->rincian_pengajuan as $i => $item)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $item['uraian'] }}</td>
                <td>{{ $item['perhitungan'] }}</td>
                <td class="text-right">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-center">Total Pengajuan</td>
                <td class="text-right">Rp {{ number_format($pengajuan->total_pengajuan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tujuan Penggunaan Dana -->
    <p style="font-weight: bold;">Tujuan Penggunaan Dana</p>
    <p style="margin-top: 0; text-align: justify;">
        Dana tersebut akan digunakan untuk mendukung kelancaran perjalanan dalam rangka:<br>
        - {{ $pengajuan->tujuan_dana ?? '-' }}
    </p>

    <!-- Penutup -->
    <p>Demikian pengajuan budget ini kami sampaikan. Besar harapan kami agar pengajuan ini dapat disetujui guna mendukung kelancaran kegiatan.</p>

    <!-- Tanda Tangan -->
    <div class="signatures">
        <div class="sign-col">
            <p style="font-weight: bold;">Pengaju,</p>
            <div class="sign-box">
                @if($pengajuan->ttd_pengaju)
                    <!-- Gunakan public_path agar DomPDF bisa membaca file lokal -->
                    <img src="{{ public_path($pengajuan->ttd_pengaju) }}" class="ttd-img">
                @endif
            </div>
            <div class="sign-name">{{ $pengajuan->nama_pengaju }}</div>
        </div>
        <div class="sign-col">
            <p style="font-weight: bold;">Menyetujui,</p>
            <!-- Jika ada TTD Menyetujui, logikanya sama seperti di atas -->
            <div class="sign-box"></div>
            <div class="sign-name">{{ $pengajuan->nama_menyyetujui }}</div>
        </div>
    </div>

</body>
</html>
