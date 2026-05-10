<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Frame-Lokal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #121212; color: #e0e0e0; }
        .bg-dark-custom { background-color: #1e1e1e; border-right: 1px solid #333; }
        .text-yellow { color: #ffca28; }
        .btn-yellow { background-color: #ffca28; color: #121212; font-weight: 600; }
        .btn-yellow:hover { background-color: #ffd54f; color: #121212; }
        .card { background-color: #1e1e1e; border: 1px solid #333; color: #fff; }
        .sidebar-link { color: #bdbdbd; text-decoration: none; padding: 10px 15px; display: block; border-radius: 8px; }
        .sidebar-link:hover, .sidebar-link.active { background-color: #333; color: #ffca28; }
        .table { color: #e0e0e0; }
        .form-control, .form-select { background-color: #2a2a2a; border: 1px solid #444; color: #fff; }
        .form-control:focus { background-color: #333; color: #fff; border-color: #ffca28; box-shadow: none; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-dark-custom min-vh-100 p-3">
            <h4 class="text-yellow fw-bold mb-4">Frame-Lokal</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.films.index') }}" class="sidebar-link active"><i class="bi bi-film me-2"></i> Film</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.genres.index') }}" class="sidebar-link"><i class="bi bi-tags me-2"></i> Genre</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="sidebar-link"><i class="bi bi-geo-alt me-2"></i> Wilayah</a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>