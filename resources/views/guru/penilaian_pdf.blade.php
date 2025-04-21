<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penilaian - {{ $siswa->nama }}</title>
</head>
<body>
    <h1>Penilaian Praktik Kerja Industri</h1>
    <h2>{{ $siswa->nama }}</h2>
    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
    <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>
    <p><strong>Program Keahlian:</strong> {{ $siswa->kelas->jurusan->nama_jurusan }}</p>
    <p><strong>Kompetensi Keahlian:</strong> {{ $siswa->kelas->jurusan->nama_jurusan }}</p>
    <p><strong>Tempat PKL:</strong> {{ $dudi->nama_dudi }}</p>
    <p><strong>Instruktur:</strong> {{ $penilaian->nama_instruktur }}</p>
    <p><strong>Catatan:</strong> {{ $penilaian->catatan }}</p>

    <h3>Detail Penilaian</h3>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tujuan Pembelajaran</th>
                <th>Skor</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaianDetail as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->tujuan_pembelajaran }}</td>
                <td>{{ $detail->skor }}</td>
                <td>{{ $detail->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Ketidakhadiran</h3>
    <p><strong>Sakit:</strong> {{ $ketidakhadiran->sakit }}</p>
    <p><strong>Ijin:</strong> {{ $ketidakhadiran->ijin }}</p>
    <p><strong>Tanpa Keterangan:</strong> {{ $ketidakhadiran->tanpa_keterangan }}</p>
</body>
</html>
