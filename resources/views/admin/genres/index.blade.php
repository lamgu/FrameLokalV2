@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Manajemen <span class="text-yellow">Genre</span></h2>
    <a href="{{ route('admin.genres.create') }}" class="btn btn-yellow">
        <i class="bi bi-plus-lg me-1"></i> Tambah Genre
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4" width="5%">No</th>
                        <th>Nama Genre</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse($genres as $key => $genre)
                    <tr>
                        <td class="ps-4">{{ $genres->firstItem() + $key }}</td>
                        <td class="fw-bold">{{ $genre->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.genres.edit', $genre->id) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus genre ini?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data genre.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">
    {{ $genres->links('pagination::bootstrap-5') }}
</div>
@endsection