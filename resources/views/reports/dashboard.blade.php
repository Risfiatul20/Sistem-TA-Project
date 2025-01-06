<!DOCTYPE html>
<html>
<head>
    <title>Laporan Dashboard Sistem TA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .stats {
            display: flex;
            justify-content: space-between;
        }
        .stats-card {
            width: 48%;
            border: 1px solid #ddd;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Dashboard Sistem Tugas Akhir</h1>
        <p>Tanggal Cetak: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div class="section">
        <h2>Statistik Proposal</h2>
        <div class="stats">
            <div class="stats-card">
                <h3>Ringkasan</h3>
                <p>Total Proposal: {{ $proposalStats['total'] }}</p>
                <p>Draft: {{ $proposalStats['draft'] }}</p>
                <p>Diajukan: {{ $proposalStats['diajukan'] }}</p>
                <p>Disetujui: {{ $proposalStats['disetujui'] }}</p>
                <p>Ditolak: {{ $proposalStats['ditolak'] }}</p>
            </div>
            <div class="stats-card">
                <h3>Civitas Akademika</h3>
                <p>Total Mahasiswa: {{ $totalMahasiswa }}</p>
                <p>Total Dosen: {{ $totalDosen }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Proposal Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Mahasiswa</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentProposals as $proposal)
                <tr>
                    <td>{{ $proposal->judul }}</td>
                    <td>{{ $proposal->user->name }}</td>
                    <td>{{ $proposal->status }}</td>
                    <td>{{ $proposal->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Jadwal Sempro Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>Proposal</th>
                    <th>Mahasiswa</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSempros as $sempro)
                <tr>
                    <td>{{ $sempro->proposal->judul }}</td>
                    <td>{{ $sempro->proposal->user->name }}</td>
                    <td>{{ $sempro->tanggal->format('d M Y') }}</td>
                    <td>{{ $sempro->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Statistik Sempro</h2>
        <div class="stats">
            <div class="stats-card">
                <h3>Ringkasan</h3>
                <p>Total Sempro: {{ $semproStats['total'] }}</p>
                <p>Dijadwalkan: {{ $semproStats['dijadwalkan'] }}</p>
                <p>Berlangsung: {{ $semproStats['berlangsung'] }}</p>
                <p>Selesai: {{ $semproStats['selesai'] }}</p>
                <p>Ditunda: {{ $semproStats['ditunda'] }}</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Laporan dibuat secara otomatis oleh Sistem Informasi Tugas Akhir</p>
    </div>
</body>
</html>