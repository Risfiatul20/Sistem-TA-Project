@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Mahasiswa</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Statistik Proposal</div>
                <div class="card-body">
                    <p>Total Proposal: {{ $stats['total_proposals'] }}</p>
                    <h5>Status Proposal:</h5>
                    @foreach($stats['proposals_by_status'] as $status)
                        <p>{{ ucfirst($status->status) }}: {{ $status->count }}</p>
                    @endforeach
                    <p>Seminar Proposal Terjadwal: {{ $stats['sempros_terjadwal'] }}</p>
                </div>
            </div>
        </div>
    
    </div>
</div>
@endsection