@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Seminar Proposal</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @can('create', App\Models\Sempro::class)
    <a href="{{ route('sempros.create') }}" class="btn btn-primary mb-3">
        Jadwalkan Sempro Baru
    </a>
    @endcan

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('sempros.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="dijadwalkan">Dijadwalkan</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditunda">Ditunda</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-secondary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Proposal</th>
                        <th>Mahasiswa</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sempros as $index => $sempro)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sempro->proposal->judul }}</td>
                        <td>{{ $sempro->proposal->user->name }}</td>
                        <td>{{ $sempro->tanggal->format('d M Y') }}</td>
                        <td>{{ $sempro->jam }}</td>
                        <td>{{ $sempro->ruang }}</td>
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
                            <div class="btn-group" role="group">
                                @can('view', $sempro)
                                <a href="{{ route('sempros.show', $sempro) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan

                                @can('update', $sempro)
                                <a href="{{ route('sempros.edit', $sempro) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('delete', $sempro)
                                <form action="{{ route('sempros.destroy', $sempro) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus jadwal sempro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan

                                @can('changeStatus', $sempro)
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" 
                                            type="button" 
                                            data-bs-toggle="dropdown">
                                        Ubah Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('sempros.change-status', 
                                               ['sempro' => $sempro, 'status' => 'dijadwalkan']) }}">
                                                Dijadwalkan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('sempros.change-status', 
                                               ['sempro' => $sempro, 'status' => 'berlangsung']) }}">
                                                Berlangsung
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('sempros.change-status', 
                                               ['sempro' => $sempro, 'status' => 'selesai']) }}">
                                                Selesai
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('sempros.change-status', 
                                               ['sempro' => $sempro, 'status' => 'ditunda']) }}">
                                                Ditunda
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada jadwal sempro
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @can('create', App\Models\Sempro::class)
    <div class="mt-3">
        <a href="{{ route('sempros.generate-report') }}" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Generate Laporan
        </a>
    </div>
   
    @endcan
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus jadwal sempro?')) {
                    e.preventDefault();
                }
            });
        });

        // Filter dinamis
        const statusFilter = document.querySelector('select[name="status"]');
        const startDateFilter = document.querySelector('input[name="start_date"]');
        const endDateFilter = document.querySelector('input[name="end_date"]');

        [statusFilter, startDateFilter, endDateFilter].forEach(filter => {
            filter.addEventListener('change', function() {
                // Validasi tanggal
                if (startDateFilter.value && endDateFilter.value) {
                    if (new Date(startDateFilter.value) > new Date(endDateFilter.value)) {
                        alert('Tanggal mulai harus lebih awal dari tanggal akhir');
                        return false;
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection