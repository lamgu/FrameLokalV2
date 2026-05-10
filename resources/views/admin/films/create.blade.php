@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold">Tambah <span class="text-yellow">Film Baru</span></h2>
    <p class="text-muted">Pastikan semua data terisi dengan benar untuk promosi film lokal.</p>
</div>

<div class="card shadow-sm mb-5">
    <div class="card-body p-4">
        <form action="{{ route('admin.films.index') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Film</label>
                        <input type="text" name="title" class="form-control" placeholder="Masukkan judul film..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sinopsis</label>
                        <textarea name="synopsis" id="editor" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Provinsi Asal</label>
                            <select id="province_id" class="form-select">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kabupaten/Kota</label>
                            <select name="regency_id" id="regency_id" class="form-select" required disabled>
                                <option value="">-- Pilih Provinsi Dahulu --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Poster Film</label>
                        <input type="file" name="poster" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG. Max: 2MB [cite: 28]</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Rilis</label>
                        <input type="number" name="year" class="form-control" placeholder="Contoh: 2024" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Genre</label>
                        <div class="bg-dark p-3 rounded border border-secondary" style="max-height: 200px; overflow-y: auto;">
                            @foreach($genres as $genre)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genres[]" value="{{ $genre->id }}" id="genre{{ $genre->id }}">
                                <label class="form-check-label" for="genre{{ $genre->id }}">
                                    {{ $genre->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-secondary">
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.films.index') }}" class="btn btn-outline-light me-2">Batal</a>
                <button type="submit" class="btn btn-yellow px-5">Simpan Film</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    // Inisialisasi CKEditor [cite: 21, 81]
    CKEDITOR.replace('editor');

    // Logika AJAX Dropdown Berjenjang [cite: 25, 118]
    $('#province_id').on('change', function() {
        var provinceID = $(this).val();
        if(provinceID) {
            $.ajax({
                url: '/admin/get-regencies/' + provinceID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#regency_id').empty().append('<option value="">-- Pilih Kabupaten --</option>');
                    $.each(data, function(key, value) {
                        $('#regency_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                    $('#regency_id').prop('disabled', false);
                }
            });
        } else {
            $('#regency_id').empty().prop('disabled', true);
        }
    });
</script>
@endpush