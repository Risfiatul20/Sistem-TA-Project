@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Penilaian Seminar Proposal</h1>
    <form action="{{ route('sempro.penilaian.store', $sempro->id) }}" method="POST">
        @csrf
        <div id="penilaian-container">
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Aspek Penilaian</label>
                    <input type="text" name="aspek_penilaian[]" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Nilai (0-100)</label>
                    <input type="number" name="nilai[]" class="form-control" min="0" max="100" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success mt-4" id="tambah-aspek">+</button>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan Penilaian</button>
    </form>
</div>

<script>
document.getElementById('tambah-aspek').addEventListener('click', function() {
    const container = document.getElementById('penilaian-container');
    const newRow = document.createElement('div');
    newRow.classList.add('form-group', 'row', 'mt-2');
    newRow.innerHTML = `
        <div class="col-md-6">
            <input type="text" name="aspek_penilaian[]" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="nilai[]" class="form-control" min="0" max="100" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button>
        </div>
    `;
    container.appendChild(newRow);
});
</script>
@endsection