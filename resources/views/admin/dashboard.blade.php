@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Statistik</div>
                <div class="card-body">
                    <p>Total Pengguna: {{ $stats['total_users'] }}</p>
                    <p>Total Proposal: {{ $stats['total_proposals'] }}</p>
                    <p>Total Seminar: {{ $stats['total_sempros'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection