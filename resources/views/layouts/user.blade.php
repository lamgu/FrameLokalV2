<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') — Frame Lokal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --brand: #f5c518;
            --brand-dim: #c9a014;
            --surface: #111111;
            --surface-2: #1a1a1a;
            --surface-3: #242424;
            --dark: #0a0a0a;
        }
        html { scroll-behavior: smooth; }
        body {
            background-color: var(--dark);
            font-family: 'DM Sans', sans-serif;
            color: #e5e5e5;
        }
        .font-display { font-family: 'Bebas Neue', sans-serif; }

        /* Navbar scroll effect */
        #navbar { transition: background 0.4s ease; }
        #navbar.scrolled { background: rgba(10,10,10,0.98) !important; backdrop-filter: blur(12px); }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 2px; }

        /* Carousel */
        .film-row { overflow-x: auto; overflow-y: visible; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .film-row::-webkit-scrollbar { display: none; }
        .film-card { scroll-snap-align: start; flex-shrink: 0; }
        .film-card:hover .film-overlay { opacity: 1; }
        .film-card:hover .film-poster { transform: scale(1.04); }
        .film-poster { transition: transform 0.3s ease; }
        .film-overlay { opacity: 0; transition: opacity 0.3s ease; }

        /* Hero gradient */
        .hero-gradient {
            background: linear-gradient(
                to right,
                rgba(10,10,10,0.92) 0%,
                rgba(10,10,10,0.60) 50%,
                rgba(10,10,10,0.15) 100%
            ),
            linear-gradient(
                to top,
                rgba(10,10,10,1) 0%,
                rgba(10,10,10,0) 40%
            );
        }

        /* Star rating */
        .star { color: #f5c518; }
        .star-empty { color: #444; }

        /* Skeleton */
        .skeleton { background: linear-gradient(90deg, #1a1a1a 25%, #242424 50%, #1a1a1a 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* Nav active */
        .nav-link.active { color: #f5c518; }
        .nav-link { transition: color 0.2s; }
        .nav-link:hover { color: #ffffff; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">

    <!-- NAVBAR -->
    <nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-gradient-to-b from-black/80 to-transparent">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0">
                    <div class="w-8 h-8 bg-[#f5c518] rounded-lg flex items-center justify-center">
                        <i class="ti ti-movie text-black text-sm"></i>
                    </div>
                    <span class="font-display text-2xl tracking-widest text-[#f5c518]">Frame-Lokal</span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-7 text-sm font-medium text-gray-300">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('explore') }}" class="nav-link {{ request()->routeIs('explore') ? 'active' : '' }}">Eksplorasi</a>
                    <a href="{{ route('map') }}" class="nav-link {{ request()->routeIs('map') ? 'active' : '' }}">Peta Film</a>
                    <a href="#" class="nav-link">About Us</a>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition-colors">
                            <div class="w-8 h-8 rounded-full bg-[#f5c518] flex items-center justify-center text-black text-xs font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#f5c518] transition-colors px-3 py-1.5 rounded-lg border border-white/10 hover:border-[#f5c518]/40">
                                <i class="ti ti-logout text-base"></i>
                                <span class="hidden sm:block">Keluar</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm bg-[#f5c518] hover:bg-[#c9a014] text-black font-semibold px-4 py-1.5 rounded-lg transition-colors">Daftar</a>
                    @endauth

                    <!-- Mobile Hamburger -->
                    <button id="mobile-menu-btn" class="md:hidden w-9 h-9 flex items-center justify-center text-gray-400 hover:text-white">
                        <i class="ti ti-menu-2 text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#111]/95 backdrop-blur-md border-t border-white/5">
            <div class="px-6 py-4 flex flex-col gap-4 text-sm font-medium text-gray-300">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('explore') }}" class="nav-link {{ request()->routeIs('explore') ? 'active' : '' }}">Eksplorasi</a>
                <a href="{{ route('map') }}" class="nav-link {{ request()->routeIs('map') ? 'active' : '' }}">Peta Film</a>
                <a href="#" class="nav-link">About Us</a>
                @auth
                    <a href="{{ route('profile.edit') }}" class="nav-link">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-left w-full text-red-400 hover:text-red-300">Keluar</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-white/[0.06] mt-20 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-[#f5c518] rounded-md flex items-center justify-center">
                        <i class="ti ti-movie text-black text-xs"></i>
                    </div>
                    <span class="font-display text-xl tracking-widest text-[#f5c518]">Frame-Lokal</span>
                </div>
                <p class="text-xs text-gray-600 text-center">Merayakan sinema lokal Indonesia. &copy; {{ date('Y') }} Frame Lokal. Seluruh hak dilindungi.</p>
                <div class="flex items-center gap-4 text-xs text-gray-600">
                    <a href="#" class="hover:text-gray-400 transition-colors">Tentang</a>
                    <a href="#" class="hover:text-gray-400 transition-colors">Kebijakan</a>
                    <a href="#" class="hover:text-gray-400 transition-colors">Kontak</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            nav.classList.toggle('scrolled', window.scrollY > 60);
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
