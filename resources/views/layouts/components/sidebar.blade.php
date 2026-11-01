{{-- Sidebar Block 07 (shadcn/ui sidebar-07 style with desktop collapse support & pink theme) --}}
<aside id="app-sidebar"
       class="fixed inset-y-0 left-0 z-50 bg-white border-r border-[#fed7dc] flex flex-col justify-between transition-all duration-200 ease-in-out select-none shadow-none"
       :class="{
           'w-64': sidebarExpanded,
           'w-20': !sidebarExpanded,
           'translate-x-0': mobileSidebarOpen,
           '-translate-x-full md:translate-x-0': !mobileSidebarOpen
       }">

    <div class="flex flex-col h-full overflow-hidden">
        {{-- ========================================== --}}
        {{-- 1. Workspace Switcher Header (sidebar-07) --}}
        {{-- ========================================== --}}
        <div class="h-16 flex items-center border-b border-[#fed7dc]/80 px-3">
            <div class="w-full flex items-center rounded-[18px] p-2"
                 :class="!sidebarExpanded ? 'justify-center' : ''">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-2xl bg-[#f43f5e] text-white flex items-center justify-center font-bold text-sm shrink-0">
                        <i class="bi bi-droplet-half"></i>
                    </div>
                    <div class="flex flex-col min-w-0" x-show="sidebarExpanded" x-cloak>
                        <span class="text-xs font-semibold text-[#14140f] truncate tracking-tight">
                            Red Menstruasi
                        </span>
                        <span class="text-[10px] text-[#6e6e64] truncate">TI 5D &bull; 2410010375</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 2. Navigation Groups (sidebar-07) --}}
        {{-- ========================================== --}}
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-5">
            {{-- Search Quick Filter Button --}}
            <div x-show="sidebarExpanded" x-cloak>
                <button type="button"
                        @click="searchOpen = true"
                        class="w-full flex items-center justify-between px-3 py-2 text-xs text-zinc-400 bg-[#fcf6f7] hover:bg-rose-50 border border-[#fed7dc] rounded-xl transition-all">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-search text-xs"></i>
                        <span>Cari menu...</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded bg-white text-[10px] font-mono border border-[#fed7dc] text-zinc-500">⌘K</span>
                </button>
            </div>

            {{-- Group 1: Utama --}}
            <div class="space-y-1">
                <div x-show="sidebarExpanded" x-cloak class="px-2 pb-1 eyebrow-label text-[10px]">
                    Platform
                </div>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all group relative {{ request()->routeIs('dashboard') || request()->is('/') ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#14140f] hover:bg-[#fff1f2] hover:text-[#f43f5e]' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''"
                   :title="!sidebarExpanded ? 'Dashboard Siklus' : ''">
                    <i class="bi bi-grid-1x2 text-sm"></i>
                    <span x-show="sidebarExpanded" x-cloak>Dashboard Siklus</span>
                </a>
            </div>

            {{-- Group 2: Data Master (Collapsible Treeview) --}}
            <div class="space-y-1" x-data="{ openMaster: true }">
                <div class="flex items-center justify-between px-2 pb-1 cursor-pointer select-none"
                     @click="openMaster = !openMaster"
                     x-show="sidebarExpanded" x-cloak>
                    <span class="eyebrow-label text-[10px]">Data Master</span>
                    <i class="bi bi-chevron-right text-[10px] text-zinc-400 transition-transform duration-200"
                       :class="{ 'rotate-90': openMaster }"></i>
                </div>

                <div class="space-y-1" x-show="!sidebarExpanded || openMaster">
                    {{-- Periode --}}
                    <a href="{{ route('periode.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('periode.*') ? 'bg-rose-100 text-rose-900 font-medium border border-rose-200' : 'text-[#14140f] hover:bg-[#fff1f2] hover:text-[#f43f5e]' }}"
                       :class="!sidebarExpanded ? 'justify-center' : 'justify-between'"
                       :title="!sidebarExpanded ? 'Master Periode' : ''">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i class="bi bi-calendar3 text-sm {{ request()->routeIs('periode.*') ? 'text-rose-600' : 'text-zinc-500' }}"></i>
                            <span x-show="sidebarExpanded" x-cloak>Periode</span>
                        </div>
                        <span x-show="sidebarExpanded" x-cloak class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-rose-200 text-rose-800">
                            CRUD
                        </span>
                    </a>

                    {{-- Siklus & Log Haid --}}
                    <a href="{{ route('cycles.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('cycles.*') ? 'bg-rose-100 text-rose-900 font-medium border border-rose-200' : 'text-[#14140f] hover:bg-[#fff1f2] hover:text-[#f43f5e]' }}"
                       :class="!sidebarExpanded ? 'justify-center' : ''"
                       :title="!sidebarExpanded ? 'Siklus & Log Haid' : ''">
                        <i class="bi bi-arrow-repeat text-sm {{ request()->routeIs('cycles.*') ? 'text-rose-600' : 'text-zinc-500' }}"></i>
                        <span x-show="sidebarExpanded" x-cloak>Siklus & Log Haid</span>
                    </a>

                    {{-- Master Gejala --}}
                    <a href="{{ route('symptoms.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('symptoms.*') ? 'bg-rose-100 text-rose-900 font-medium border border-rose-200' : 'text-[#14140f] hover:bg-[#fff1f2] hover:text-[#f43f5e]' }}"
                       :class="!sidebarExpanded ? 'justify-center' : ''"
                       :title="!sidebarExpanded ? 'Master Gejala' : ''">
                        <i class="bi bi-activity text-sm {{ request()->routeIs('symptoms.*') ? 'text-rose-600' : 'text-zinc-500' }}"></i>
                        <span x-show="sidebarExpanded" x-cloak>Master Gejala</span>
                    </a>

                    {{-- Obat & Suplemen --}}
                    <a href="{{ route('medications.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('medications.*') ? 'bg-rose-100 text-rose-900 font-medium border border-rose-200' : 'text-[#14140f] hover:bg-[#fff1f2] hover:text-[#f43f5e]' }}"
                       :class="!sidebarExpanded ? 'justify-center' : ''"
                       :title="!sidebarExpanded ? 'Obat & Suplemen' : ''">
                        <i class="bi bi-capsule text-sm {{ request()->routeIs('medications.*') ? 'text-rose-600' : 'text-zinc-500' }}"></i>
                        <span x-show="sidebarExpanded" x-cloak>Obat & Suplemen</span>
                    </a>
                </div>
            </div>

            {{-- Group 3: Pengingat & Integrasi MySQL --}}
            <div class="space-y-1">
                <div x-show="sidebarExpanded" x-cloak class="px-2 pb-1 eyebrow-label text-[10px]">
                    Fitur & Database
                </div>
                <a href="{{ route('reminders.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('reminders.*') ? 'bg-rose-100 text-rose-900 font-medium border border-rose-200' : 'text-[#14140f] hover:bg-[#fff1f2] hover:text-[#f43f5e]' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''"
                   :title="!sidebarExpanded ? 'Jadwal Pengingat' : ''">
                    <i class="bi bi-alarm text-sm {{ request()->routeIs('reminders.*') ? 'text-rose-600' : 'text-zinc-500' }}"></i>
                    <span x-show="sidebarExpanded" x-cloak>Jadwal Pengingat</span>
                </a>

                {{-- phpMyAdmin Link --}}
                <a href="http://localhost:8081" target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-emerald-800 hover:bg-emerald-50 transition-all group"
                   :class="!sidebarExpanded ? 'justify-center' : 'justify-between'"
                   :title="!sidebarExpanded ? 'phpMyAdmin' : ''">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <i class="bi bi-database-check text-sm text-emerald-600"></i>
                        <span x-show="sidebarExpanded" x-cloak>phpMyAdmin</span>
                    </div>
                    <i class="bi bi-box-arrow-up-right text-[10px] text-zinc-400 group-hover:text-emerald-700"
                       x-show="sidebarExpanded" x-cloak></i>
                </a>
            </div>
        </div>

    </div>
</aside>
