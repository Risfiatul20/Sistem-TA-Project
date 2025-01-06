@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Dashboard Kaprodi</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Statistik Proposal</div>
                <div class="card-body">
                    <canvas id="proposalChart"></canvas>
                    <ul class="list-unstyled mt-3">
                        <li>Total: {{ $proposalStats['total'] }}</li>
                        <li>Draft: {{ $proposalStats['draft'] }}</li>
                        <li>Diajukan: {{ $proposalStats['diajukan'] }}</li>
                        <li>Disetujui: {{ $proposalStats['disetujui'] }}</li>
                        <li>Ditolak: {{ $proposalStats['ditolak'] }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Statistik Sempro</div>
                <div class="card-body">
                    <canvas id="semproChart"></canvas>
                    <ul class="list-unstyled mt-3">
                        <li>Total: {{ $semproStats['total'] }}</li>
                        <li>Dijadwalkan: {{ $semproStats['dijadwalkan'] }}</li>
                        <li>Berlangsung: {{ $semproStats['berlangsung'] }}</li>
                        <li>Selesai: {{ $semproStats['selesai'] }}</li>
                        <li>Ditunda: {{ $semproStats['ditunda'] }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Civitas Akademika</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Total Mahasiswa</span>
                        <span class="badge bg-primary">{{ $totalMahasiswa }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total Dosen</span>
                        <span class="badge bg-success">{{ $totalDosen }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Aksi Cepat</div>
                <div class="card-body">
                    <a href="{{ route('proposals.index') }}" class="btn btn-outline-primary btn-block mb-2">
                        Kelola Proposal
                    </a>
                    <a href="{{ route('sempros.index') }}" class="btn btn-outline-success btn-block mb-2">
                        Jadwal Sempro
                    </a>
                    <a href="{{ route('dashboard.export') }}" class="btn btn-outline-danger btn-block">
                        Export Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Proposal Terbaru</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Mahasiswa</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProposals as $proposal)
                            <tr>
                                <td>{{ $proposal->judul }}</td>
                                <td>{{ $proposal->user->name }}</td>
                                <td>
                                    <span class="badge 
                                        @switch($proposal->status)
                                            @case('draft') bg-secondary @break
                                            @case('diajukan') bg-warning @break
                                            @case('disetujui') bg-success @break
                                            @case('ditolak') bg-danger @break
                                        @endswitch
                                    ">
                                        {{ ucfirst($proposal->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('proposals.show', $proposal) }}" 
                                       class="btn btn-sm btn-info">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Jadwal Sempro Terbaru</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Proposal</th>
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSempros as $sempro)
                            <tr>
                                <td>{{ $sempro->proposal->judul }}</td>
                                <td>{{ $sempro->proposal->user->name }}</td>
                                <td>{{ $sempro->tanggal->format('d M Y') }}</td>
                                <td>
                                    <span class="badge 
                                        @switch($sempro->status)
                                            @case('dijadwalkan') bg-warning @break
                                            @case('berlangsung') bg-primary @break
                                            @case('selesai') bg-success @break
                                            @case('ditunda') bg-danger @break
                                        @endswitch
                                    ">
                                        {{ ucfirst($sempro->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('sempros.show', $sempro) }}" 
                                       class="btn btn-sm btn-info">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Proposal
        var ctxProposal = document.getElementById('proposalChart').getContext('2d');
        var proposalChart = new Chart(ctxProposal, {
            type: 'doughnut',
            data: {
                labels: ['Draft', 'Diajukan', 'Disetujui', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $proposalStats['draft'] }},
                        {{ $proposalStats['diajukan'] }},
                        {{ $proposalStats['disetujui'] }},
                        {{ $proposalStats['ditolak'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Status Proposal'
                }
            }
        });

        // Chart Sempro
        var ctxSempro = document.getElementById('semproChart').getContext('2d');
        var semproChart = new Chart(ctxSempro, {
            type: 'pie',
            data: {
                labels: ['Dijadwalkan', 'Berlangsung', 'Selesai', 'Ditunda'],
                datasets: [{
                    data: [
                        {{ $semproStats['dijadwalkan'] }},
                        {{ $semproStats['berlangsung'] }},
                        {{ $semproStats['selesai'] }},
                        {{ $semproStats['ditunda'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Status Sempro'
                }
            }
        });
    });
</script>
@endpush
@endsection