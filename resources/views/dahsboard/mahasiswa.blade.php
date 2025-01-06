@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Mahasiswa</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Statistik Proposal</div>
                <div class="card-body">
                    <p>Total Proposal: {{ $totalProposals }}</p>
                    <p>Proposal Disetujui: {{ $approvedProposals }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Proposal Terbaru</div>
                <div class="card-body">
                    <table class="table">
                        @foreach($proposals as $proposal)
                        <tr>
                            <td>{{ $proposal->judul }}</td>
                            <td>{{ $proposal->status }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Jadwal Sempro</div>
                <div class="card-body">
                    <table class="table">
                    @foreach($sempros as $sempro)
                        <tr>
                            <td>{{ $sempro->proposal->judul }}</td>
                            <td>{{ $sempro->tanggal->format('d M Y') }}</td>
                            <td>{{ $sempro->jam }}</td>
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
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Contoh penggunaan Chart.js untuk visualisasi
        @if($proposals->count())
        var ctx = document.getElementById('proposalChart').getContext('2d');
        var proposalChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Draft', 'Diajukan', 'Disetujui', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $proposals->where('status', 'draft')->count() }},
                        {{ $proposals->where('status', 'diajukan')->count() }},
                        {{ $proposals->where('status', 'disetujui')->count() }},
                        {{ $proposals->where('status', 'ditolak')->count() }}
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
        @endif
    });
</script>
@endpush
@endsection