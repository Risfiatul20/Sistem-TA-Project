@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Dosen</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Statistik Bimbingan</div>
                <div class="card-body">
                    <p>Total Bimbingan: {{ $totalBimbingan }}</p>
                    <p>Total Penguji: {{ $totalPenguji }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Proposal Bimbingan</div>
                <div class="card-body">
                    <table class="table">
                        @foreach($proposals as $proposal)
                        <tr>
                            <td>{{ $proposal->judul }}</td>
                            <td>{{ $proposal->user->name }}</td>
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
                            <td>{{ $sempro->proposal->user->name }}</td>
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
        // Contoh grafik aktivitas bimbingan
        var ctx = document.getElementById('bimbinganChart').getContext('2d');
        var bimbinganChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Bimbingan', 'Total Penguji'],
                datasets: [{
                    label: 'Aktivitas Bimbingan',
                    data: [{{ $totalBimbingan }}, {{ $totalPenguji }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
@endpush
@endsection