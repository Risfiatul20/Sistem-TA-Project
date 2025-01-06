@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Kaprodi</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Statistik Civitas</div>
                <div class="card-body">
                    <p>Total Mahasiswa: {{ $stats['total_mahasiswa'] }}</p>
                    <p>Total Dosen: {{ $stats['total_dosen'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Status Proposal</div>
                <div class="card-body">
                    @foreach($stats['proposals_by_status'] as $status)
                        <p>{{ ucfirst($status->status) }}: {{ $status->count }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Status Seminar Proposal</div>
                <div class="card-body">
                    @foreach($stats['sempros_by_status'] as $status)
                        <p>{{ ucfirst($status->status) }}: {{ $status->count }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection