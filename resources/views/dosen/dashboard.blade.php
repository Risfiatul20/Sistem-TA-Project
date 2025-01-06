@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Dosen</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Statistik Bimbingan</div>
                <div class="card-body">
                    <p>Total Bimbingan: {{ $stats['total_bimbingan'] }}</p>
                    <p>Total Penguji: {{ $stats['total_penguji'] }}</p>
                    <p>Proposal Dibimbing: {{ $stats['proposals_dibimbing'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection