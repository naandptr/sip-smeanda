<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Prakerin - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            font-size: 12px;
            padding: 20px;
            line-height: 1.15;
        }

        h4 {
            margin: 0;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-info td {
            padding: 4px 8px;
        }

        .table-nilai, .table-absen {
            border: 0.5px solid black;
            margin-top: 20px;
        }

        .table-absen {
            width: 50%;
        }

        .table-absen th {
            text-align: left;
            padding: 6px;
        }

        .table-nilai th, .table-nilai td,
        .table-absen td {
            border: 1px solid black;
            padding: 6px;
        }

        .table-nilai th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .catatan {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid black;
        }

        .footer-ttd {
            margin-top: 50px;
        }

        .footer-ttd table {
            width: 100%;
        }

        .footer-ttd .ttd-item {
            vertical-align: top;
            text-align: left;
        }
    </style>
</head>
<body>
    <h4>SMKN 2 KOTA JAMBI</h4>
    <h4>Tahun Ajaran {{ $penilaian->penetapanPrakerin->tahunAjar->tahun_ajaran ?? '-' }}</h4>

    <table class="table-info">
        <tr><td>Nama Peserta Didik</td><td>:  {{ $siswa->nama }}</td></tr>
        <tr><td>NIS</td><td>:  {{ $siswa->nis }}</td></tr>
        <tr><td>Kelas</td><td>:  {{ $siswa->kelas->nama_kelas }}</td></tr>
        <tr><td>Program Keahlian</td><td>:  {{ $siswa->kelas->jurusan->nama_jurusan }}</td></tr>
        <tr><td>Konsentrasi Keahlian</td><td>:  {{ $siswa->kelas->jurusan->nama_jurusan }}</td></tr>
        <tr><td>Tempat PKL</td><td>:  {{ $dudi->nama_dudi }}</td></tr>
        <tr><td>Tanggal PKL</td><td>:  {{ \Carbon\Carbon::parse($penilaian->penetapanPrakerin->tanggal_mulai)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($penilaian->penetapanPrakerin->tanggal_selesai)->translatedFormat('d F Y') }}</td></tr>
        <tr><td>Nama Instruktur</td><td>:  {{ $penilaian->nama_instruktur }}</td></tr>
        <tr><td>Nama Pembimbing</td><td>:  {{ $penilaian->penetapanPrakerin->dudiJurusan->pembimbing->nama ?? '-' }}</td></tr>
    </table>

    <table class="table-nilai">
        <thead>
            <tr>
                <th style="width: 45%;">Tujuan Pembelajaran</th>
                <th style="width: 10%;">Skor</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaianDetail as $detail)
            <tr>
                <td>{{ $detail->tujuan_pembelajaran }}</td>
                <td style="text-align: center;">{{ $detail->skor }}</td>
                <td>{{ $detail->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="catatan">
        Catatan: {{ $penilaian->catatan ?? '-' }}
    </div>

    <table class="table-absen">
        <thead>
            <tr>
                <th colspan="2">Ketidakhadiran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sakit</td>
                <td>: {{ $ketidakhadiran->sakit ?? 0 }} hari</td>
            </tr>
            <tr>
                <td>Ijin</td>
                <td>: {{ $ketidakhadiran->ijin ?? 0 }} hari</td>
            </tr>
            <tr>
                <td>Tanpa Keterangan</td>
                <td>: {{ $ketidakhadiran->tanpa_keterangan ?? 0 }} hari</td>
            </tr>
        </tbody>
    </table>

    <div class="footer-ttd">
        <table>
            <tr>
                <td style="width: 70%;"></td>
                <td class="tgl-item">
                    Kota Jambi, {{ now()->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td class="ttd-item">
                    Guru Pembimbing<br><br><br><br><br>
                    {{ $penilaian->penetapanPrakerin->dudiJurusan->pembimbing->nama ?? '-' }}<br>
                    <strong>.................................................</strong><br>
                    NIP. {{ $penilaian->penetapanPrakerin->dudiJurusan->pembimbing->nip ?? '' }}
                </td>
                <td class="ttd-item">
                    Pembimbing Dunia Kerja<br><br><br><br><br>
                    {{ $penilaian->nama_instruktur }}<br>
                    <strong>.................................................</strong><br>
                    NIP.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
