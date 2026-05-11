<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Frame-Lokal Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        yellow: {
                            primary: '#f5c518',
                            dim:     '#c9a014',
                            pale:    'rgba(245,197,24,0.10)',
                        },
                        surface: {
                            DEFAULT: '#111111',
                            2:       '#1a1a1a',
                            3:       '#242424',
                        },
                        dark: '#0a0a0a',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Bebas Neue', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { background-color: #0a0a0a; }
        .sidebar-link.active { color: #f5c518; background: rgba(245,197,24,0.10); }
        .sidebar-link.active::before { content:''; position:absolute; left:0; top:0; bottom:0; width:3px; background:#f5c518; border-radius:0 2px 2px 0; }
        .sidebar-link { position: relative; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 2px; }
        .nav-badge { background:#f5c518; color:#000; font-size:10px; font-weight:500; padding:2px 7px; border-radius:20px; }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen overflow-hidden font-sans text-gray-100">

    {{-- SIDEBAR --}}
    <aside class="w-[220px] bg-surface border-r border-white/[0.07] flex flex-col flex-shrink-0">

        {{-- Brand --}}
        <div class="flex items-center gap-3 px-5 py-6 border-b border-white/[0.07]">
            <div class="w-9 h-9 bg-[#f5c518] rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="ti ti-movie text-black text-lg"></i>
            </div>
            <div>
                <div class="font-display text-xl tracking-widest text-[#f5c518]">Frame-Lokal</div>
                <div class="text-[10px] text-gray-500 tracking-[2px] uppercase">Admin Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-4 overflow-y-auto">
            <p class="text-[10px] text-gray-600 tracking-[2px] uppercase px-5 pt-3 pb-1.5">Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard w-[18px] text-base"></i> Dashboard
            </a>

            <a href="{{ route('admin.films.index') }}"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors {{ request()->routeIs('admin.films.*') ? 'active' : '' }}">
                <i class="ti ti-movie w-[18px] text-base"></i> Film
                <span class="ml-auto nav-badge">{{ \App\Models\Film::count() }}</span>
            </a>

            <a href="{{ route('admin.genres.index') }}"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors {{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
                <i class="ti ti-tags w-[18px] text-base"></i> Genre
            </a>

            <a href="{{ route('admin.provinces.index') }}"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors {{ request()->routeIs('admin.provinces.*') ? 'active' : '' }}">
                <i class="ti ti-map-pin w-[18px] text-base"></i> Lokasi
            </a>

            <p class="text-[10px] text-gray-600 tracking-[2px] uppercase px-5 pt-5 pb-1.5">Komunitas</p>

            <a href="#"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors">
                <i class="ti ti-message w-[18px] text-base"></i> Ulasan
                <span class="ml-auto nav-badge">{{ \App\Models\Review::count() }}</span>
            </a>

            <a href="#"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors">
                <i class="ti ti-users w-[18px] text-base"></i> Pengguna
            </a>

            <p class="text-[10px] text-gray-600 tracking-[2px] uppercase px-5 pt-5 pb-1.5">Sistem</p>

            <a href="#"
               class="sidebar-link flex items-center gap-3 px-5 py-2.5 text-[13px] text-gray-400 hover:text-gray-100 hover:bg-surface-2 transition-colors">
                <i class="ti ti-settings w-[18px] text-base"></i> Pengaturan
            </a>
        </nav>

        {{-- Footer --}}
        <div class="px-5 py-4 border-t border-white/[0.07]">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#f5c518] flex items-center justify-center text-black text-xs font-medium flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div>
                    <p class="text-[13px] font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <span class="text-[11px] text-gray-500">Super Admin</span>
                </div>
                <a href="#" title="Logout" class="ml-auto text-gray-500 hover:text-[#f5c518] transition-colors">
    <i class="ti ti-logout text-base"></i>
</a>
            </div>
        </div>
    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOPBAR --}}
        <header class="bg-surface border-b border-white/[0.07] h-[58px] flex items-center gap-4 px-7 flex-shrink-0">
            <h1 class="font-display text-[22px] tracking-wide text-[#f5c518] flex-1">@yield('page-title', 'Dashboard')</h1>

            <div class="flex items-center gap-2 bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-1.5 w-56">
                <i class="ti ti-search text-gray-500 text-[15px]"></i>
                <input type="text" placeholder="Cari film, genre..."
                       class="bg-transparent border-none outline-none text-[13px] text-gray-100 placeholder-gray-500 w-full font-sans">
            </div>

            <button class="relative w-9 h-9 rounded-lg border border-white/[0.07] bg-surface-2 flex items-center justify-center text-gray-400 hover:text-[#f5c518] hover:border-[#c9a014] transition-colors">
                <i class="ti ti-bell text-base"></i>
                <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-[#f5c518] rounded-full border border-surface"></span>
            </button>
            <button class="w-9 h-9 rounded-lg border border-white/[0.07] bg-surface-2 flex items-center justify-center text-gray-400 hover:text-[#f5c518] hover:border-[#c9a014] transition-colors">
                <i class="ti ti-user text-base"></i>
            </button>
        </header>

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
        <div class="mx-7 mt-5 flex items-center gap-3 bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl px-4 py-3 text-sm" id="flash-success">
            <i class="ti ti-circle-check text-base flex-shrink-0"></i>
            {{ session('success') }}
            <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-green-400/60 hover:text-green-400">
                <i class="ti ti-x text-sm"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="mx-7 mt-5 flex items-center gap-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl px-4 py-3 text-sm" id="flash-error">
            <i class="ti ti-alert-circle text-base flex-shrink-0"></i>
            {{ session('error') }}
            <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-red-400/60 hover:text-red-400">
                <i class="ti ti-x text-sm"></i>
            </button>
        </div>
        @endif

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-7">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
