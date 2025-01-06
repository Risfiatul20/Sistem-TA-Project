@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Proposal</h1>

    @if(session('success'))
        <div class="alert alert-success
        ">
    {{ session('success') }}
</div>
@endif

@if(auth()->user()->role == 'mahasiswa')
<a href="{{ route('proposals.create') }}" class="btn btn-primary mb-3">
    Buat Proposal Baru
</a>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Mahasiswa</th>
            <th>Status</th>
            <th>Tanggal Pengajuan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($proposals as $index => $proposal)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $proposal->judul }}</td>
            <td>{{ $proposal->user->name }}</td>
            <td>
                <span class="badge 
                    @switch($proposal->status)
                        @case('draft') bg-secondary @break
                        @case('diajukan') bg-warning @break
                        @case('disetujui') bg-success @break
                        @case('ditolak') bg-danger @break
                    @endswitch
                ">
                    {{ ucfirst($proposal->status) }}
                </span>
            </td>
            <td>{{ $proposal->tanggal_pengajuan->format('d M Y') }}</td>
            <td>
                <div class="btn-group" role="group">
                    <a href="{{ route('proposals.show', $proposal) }}" 
                       class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Lihat
                    </a>

                    @can('update', $proposal)
                    <a href="{{ route('proposals.edit', $proposal) }}" 
                       class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @endcan

                    @can('delete', $proposal)
                    <form action="{{ route('proposals.destroy', $proposal) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus proposal?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan

                    @if(auth()->user()->role == 'kaprodi')
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" 
                                type="button" 
                                data-bs-toggle="dropdown">
                            Ubah Status
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" 
                                   href="{{ route('proposals.change-status', 
                                   ['proposal' => $proposal, 'status' => 'diajukan']) }}">
                                    Diajukan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" 
                                   href="{{ route('proposals.change-status', 
                                   ['proposal' => $proposal, 'status' => 'disetujui']) }}">
                                    Disetujui
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" 
                                   href="{{ route('proposals.change-status', 
                                   ['proposal' => $proposal, 'status' => 'ditolak']) }}">
                                    Ditolak
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">
                Tidak ada proposal
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection