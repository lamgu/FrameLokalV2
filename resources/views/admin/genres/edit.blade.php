@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold">Edit <span class="text-yellow">Genre</span></h2>
</div>

<div class="card shadow-sm col-md-6">
    <div class="card-body p-4">
        <form action="{{ route('admin.genres.update', $genre->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Genre</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $genre->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.genres.index') }}" class="btn btn-outline-light me-2">Batal</a>
                <button type="submit" class="btn btn-yellow px-4">Update Genre</button>
            </div>
        </form>
    </div>
</div>
@endsection
