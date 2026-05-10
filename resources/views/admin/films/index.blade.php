@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Manajemen <span class="text-yellow">Film</span></h2>
    <a href="{{ route('admin.films.create') }}" class="btn btn-yellow">
        <i class="bi bi-plus-lg me-1"></i> Tambah Film
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Poster</th>
                        <th>Judul</th>
                        <th>Asal Daerah</th>
                        <th>Tahun</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach($films as $film)
                    <tr>
                        <td class="ps-4">
                            <img src="{{ asset('storage/' . $film->poster) }}" width="60" class="rounded shadow-sm">
                        </td>
                        <td class="fw-bold">{{ $film->title }}</td>
                        <td>{{ $film->regency->name }}</td>
                        <td>{{ $film->year }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-pencil"></i></a>
                            <form action="#" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection