// resources/views/mahasiswa/sempro/create.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pengajuan Seminar Proposal</h1>
    
    <form action="{{ route('sempro.store') }}" method="POST">
        @csrf
        <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
        
        <div class="form-group">
            <label>Judul Proposal</label>
            <input type="text" class="form-control" value="{{ $proposal->judul }}" readonly>
        </div>

        <div class="form-group">
            <label>Pilih Dosen Pembimbing</label>
            <select name="dosen_pembimbing_id" class="form-control">
                @foreach($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Catatan Tambahan</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Sempro</button>
    </form>
</div>
@endsection