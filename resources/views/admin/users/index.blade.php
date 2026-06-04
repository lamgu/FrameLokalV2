@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')

{{-- HEADER ROW --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-400 text-sm">Total <span class="text-[#f5c518] font-medium">{{ $users->total() }}</span> pengguna terdaftar</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-[#f5c518] hover:bg-[#f5c518]/90 text-black px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        <i class="ti ti-plus"></i> Tambah Pengguna
    </a>
</div>

{{-- FILTER BAR --}}
<div class="bg-surface border border-white/[0.07] rounded-xl px-5 py-4 mb-5 flex items-center gap-4">
    <div class="flex items-center gap-2 bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 flex-1 max-w-sm">
        <i class="ti ti-search text-gray-500 text-sm"></i>
        <input type="text" id="search-input" placeholder="Cari nama atau email..."
               class="bg-transparent border-none outline-none text-[13px] text-gray-100 placeholder-gray-500 w-full font-sans">
    </div>
    <select id="role-filter" class="bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 text-[13px] text-gray-300 outline-none font-sans cursor-pointer">
        <option value="">Semua Role</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>
</div>

{{-- TABLE --}}
<div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
    <table class="w-full" id="users-table">
        <thead>
            <tr class="border-b border-white/[0.07]">
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-12">#</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Pengguna</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Role</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Ulasan</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Terdaftar</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-24">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr class="user-row border-b border-white/[0.04] hover:bg-surface-2 transition-colors"
                data-search="{{ strtolower($user->name . ' ' . $user->email) }}"
                data-role="{{ $user->role }}">
                <td class="px-5 py-4 text-[13px] text-gray-500">{{ $users->firstItem() + $index }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-surface-3 flex items-center justify-center text-gray-300 font-medium flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-[14px] font-medium text-gray-100">
                                {{ $user->name }}
                                @if(auth()->id() === $user->id)
                                    <span class="ml-1 text-[10px] text-[#f5c518]">(Anda)</span>
                                @endif
                            </p>
                            <p class="text-[12px] text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4">
                    @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-[#f5c518]/10 text-[#f5c518] text-[11px] font-medium border border-[#f5c518]/20">
                            <i class="ti ti-shield-check text-[13px]"></i> Admin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-surface-3 text-gray-300 text-[11px] font-medium border border-white/[0.07]">
                            <i class="ti ti-user text-[13px]"></i> User
                        </span>
                    @endif
                </td>
                <td class="px-5 py-4 text-[13px] text-gray-300">
                    {{ $user->reviews_count }} ulasan
                </td>
                <td class="px-5 py-4 text-[13px] text-gray-300">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-5 py-4">
                    <div class="flex gap-1.5">
                        {{-- Form Ubah Role --}}
                        @if(auth()->id() !== $user->id)
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                <button type="submit"
                                        title="Jadikan {{ $user->role === 'admin' ? 'User' : 'Admin' }}"
                                        onclick="return confirm('Ubah role {{ $user->name }} menjadi {{ $user->role === 'admin' ? 'User' : 'Admin' }}?')"
                                        class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-blue-400 hover:border-blue-400/40 transition-colors">
                                    <i class="ti ti-switch-horizontal text-sm"></i>
                                </button>
                            </form>
                        
                            {{-- Form Hapus --}}
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus pengguna \'{{ addslashes($user->name) }}\'? Semua ulasannya mungkin akan ikut terhapus sesuai aturan database.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        title="Hapus Pengguna"
                                        class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-red-400 hover:border-red-500/40 transition-colors">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </form>
                        @else
                            {{-- Disable actions for self --}}
                            <div class="w-8 h-8 rounded-lg border border-white/[0.02] flex items-center justify-center text-gray-600 bg-surface-2 cursor-not-allowed" title="Tidak bisa mengubah akun sendiri">
                                <i class="ti ti-lock text-sm"></i>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-16 text-center">
                    <i class="ti ti-users-minus text-3xl text-gray-600 block mb-3"></i>
                    <p class="text-gray-500 text-sm">Belum ada pengguna.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Empty search state --}}
    <div id="no-results" class="hidden px-5 py-16 text-center">
        <i class="ti ti-search-off text-3xl text-gray-600 block mb-3"></i>
        <p class="text-gray-500 text-sm">Tidak ada pengguna yang cocok dengan pencarian.</p>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-5">
    {{ $users->links() }}
</div>

@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search-input');
    const roleFilter  = document.getElementById('role-filter');
    const rows        = document.querySelectorAll('.user-row');
    const noResults   = document.getElementById('no-results');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const role   = roleFilter.value;
        let visible  = 0;

        rows.forEach(row => {
            const matchSearch = row.dataset.search.includes(search);
            const matchRole   = !role || row.dataset.role === role;
            
            const show = matchSearch && matchRole;
            row.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        noResults.classList.toggle('hidden', visible > 0 || rows.length === 0);
    }

    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
</script>
@endpush
