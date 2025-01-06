@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Proposal Baru</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proposals.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="judul">Judul Proposal</label>
            <input 
                type="text" 
                class="form-control" 
                id="judul" 
                name="judul" 
                value="{{ old('judul') }}"
                required
                maxlength="255"
            >
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi Proposal</label>
            <textarea 
                class="form-control" 
                id="deskripsi" 
                name="deskripsi" 
                rows="5"
                maxlength="1000"
            >{{ old('deskripsi') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Proposal
        </button>
        <a href="{{ route('proposals.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection