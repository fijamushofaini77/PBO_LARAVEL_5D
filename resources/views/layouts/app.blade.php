<!DOCTYPE html>
<html lang="id" class="h-full bg-[#fdfafb]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Red Menstruasi') }} — Dashboard Admin</title>

    {{-- Fonts per docs/design --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons for Compatibility with Lecturer's Module --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- AlpineJS for Snappy UI Interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: #14140f;
            background-color: #fdfafb;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full antialiased selection:bg-rose-100 selection:text-rose-900"
      x-data="{
          sidebarExpanded: localStorage.getItem('sidebar_expanded') !== 'false',
          mobileSidebarOpen: false,
          searchOpen: false,
          toggleSidebar() {
              this.sidebarExpanded = !this.sidebarExpanded;
              localStorage.setItem('sidebar_expanded', this.sidebarExpanded);
          }
      }"
      @keydown.window.ctrl.b.prevent="toggleSidebar()"
      @keydown.window.cmd.b.prevent="toggleSidebar()"
      @keydown.window.ctrl.k.prevent="searchOpen = !searchOpen"
      @keydown.window.cmd.k.prevent="searchOpen = !searchOpen"
      @keydown.escape.window="searchOpen = false; mobileSidebarOpen = false">

    <div class="min-h-full flex flex-col">
        {{-- Sidebar Component (shadcn sidebar-07 style with desktop collapse support) --}}
        @include('layouts.components.sidebar')

        {{-- Mobile Overlay Backdrop --}}
        <div x-show="mobileSidebarOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebarOpen = false"
             class="fixed inset-0 z-40 bg-zinc-900/40 backdrop-blur-xs md:hidden"></div>

        {{-- Main Page Shell --}}
        <div class="flex-1 flex flex-col transition-all duration-200 ease-in-out"
             :class="sidebarExpanded ? 'md:pl-64' : 'md:pl-20'">

            {{-- Top Header (shadcn dashboard-01 top bar) --}}
            @include('layouts.components.header')

            {{-- Main Content Canvas --}}
            <main class="flex-1 p-5 md:p-8 max-w-[1320px] w-full mx-auto space-y-6">
                {{-- Breadcrumb Area --}}
                @hasSection('breadcrumb')
                    <div class="mb-2">
                        @yield('breadcrumb')
                    </div>
                @endif

                {{-- Global Flash Alerts per docs/design --}}
                @if (session('success'))
                    <div class="p-4 rounded-[20px] bg-emerald-50/90 border border-emerald-200 text-emerald-900 flex items-center justify-between" role="alert">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm shrink-0">
                                <i class="bi bi-check-lg"></i>
                            </span>
                            <div>
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-emerald-900">Operasi Sukses</h4>
                                <p class="text-xs text-emerald-800">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 p-1.5 rounded-lg" aria-label="Tutup">
                            <i class="bi bi-x-lg text-xs"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-4 rounded-[20px] bg-rose-50/90 border border-rose-200 text-rose-900 flex items-center justify-between" role="alert">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-sm shrink-0">
                                <i class="bi bi-exclamation-triangle"></i>
                            </span>
                            <div>
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-rose-900">Peringatan</h4>
                                <p class="text-xs text-rose-800">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 p-1.5 rounded-lg" aria-label="Tutup">
                            <i class="bi bi-x-lg text-xs"></i>
                        </button>
                    </div>
                @endif

                {{-- Yield View Content --}}
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Interactive Command Palette / Search Dialog (Ctrl+K / Cmd+K) --}}
    <div x-show="searchOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20 flex items-start justify-center"
         role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div x-show="searchOpen"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-zinc-900/40 backdrop-blur-sm"
             @click="searchOpen = false"></div>

        {{-- Modal Dialog --}}
        <div x-show="searchOpen"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-lg bg-white rounded-[24px] border border-[#fed7dc] shadow-2xl overflow-hidden"
             x-data="{
                 searchQuery: '',
                 items: [
                     { title: 'Dashboard Siklus Menstruasi', desc: 'Halaman utama metrik & prediksi', url: '{{ route('dashboard') }}', tag: 'Utama' },
                     { title: 'Master Periode (Modul 5)', desc: 'Tabel master data periode kuliah', url: '{{ route('periode.index') }}', tag: 'Modul 5' },
                     { title: 'Tambah Periode Baru', desc: 'Form tambah data periode', url: '{{ route('periode.create') }}', tag: 'Form' },
                     { title: 'Siklus & Log Haid', desc: 'Pencatatan tanggal awal-akhir siklus', url: '{{ route('cycles.index') }}', tag: 'Siklus' },
                     { title: 'Catat Siklus Baru', desc: 'Mulai pencatatan siklus baru', url: '{{ route('cycles.create') }}', tag: 'Form' },
                     { title: 'Master Gejala (Symptoms)', desc: 'Katalog keluhan & gejala fisik', url: '{{ route('symptoms.index') }}', tag: 'Master' },
                     { title: 'Obat & Suplemen', desc: 'Daftar vitamin, obat & pereda nyeri', url: '{{ route('medications.index') }}', tag: 'Master' },
                     { title: 'Jadwal Pengingat', desc: 'Notifikasi & alarm minum pil', url: '{{ route('reminders.index') }}', tag: 'Fitur' },
                     { title: 'phpMyAdmin', desc: 'Buka panel database', url: 'http://localhost:8081', tag: 'External' }
                 ],
                 get filteredItems() {
                     if (!this.searchQuery) return this.items;
                     return this.items.filter(item =>
                         item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                         item.desc.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                         item.tag.toLowerCase().includes(this.searchQuery.toLowerCase())
                     );
                 }
             }">

            {{-- Input Bar --}}
            <div class="flex items-center px-4 border-b border-[#fed7dc]/80">
                <i class="bi bi-search text-zinc-400 text-sm"></i>
                <input type="text"
                       x-model="searchQuery"
                       placeholder="Ketik untuk mencari menu, aksi, atau tabel..."
                       class="w-full px-3 py-3.5 text-xs text-[#14140f] placeholder-zinc-400 focus:outline-none"
                       autofocus>
                <span class="px-2 py-0.5 rounded bg-zinc-100 text-zinc-500 text-[10px] font-mono">ESC</span>
            </div>

            {{-- Results List --}}
            <div class="max-h-80 overflow-y-auto p-2 divide-y divide-zinc-50">
                <template x-for="item in filteredItems" :key="item.url">
                    <a :href="item.url"
                       class="flex items-center justify-between p-3 rounded-xl hover:bg-rose-50/70 group transition-colors">
                        <div>
                            <div class="text-xs font-semibold text-zinc-900 group-hover:text-rose-600 transition-colors" x-text="item.title"></div>
                            <div class="text-[11px] text-zinc-500" x-text="item.desc"></div>
                        </div>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-zinc-100 group-hover:bg-rose-100 text-zinc-600 group-hover:text-rose-700 transition-colors" x-text="item.tag"></span>
                    </a>
                </template>
                <div x-show="filteredItems.length === 0" class="py-8 text-center text-xs text-zinc-500">
                    Tidak ditemukan hasil untuk "<span x-text="searchQuery"></span>"
                </div>
            </div>

            {{-- Footer Hint --}}
            <div class="p-3 bg-[#fdfafb] border-t border-[#fed7dc]/60 flex items-center justify-between text-[11px] text-zinc-400">
                <span>Navigasi Cepat &bull; Red Menstruasi</span>
                <span class="font-mono">PBO 2 TI 5D</span>
            </div>
        </div>
    </div>
</body>
</html>
