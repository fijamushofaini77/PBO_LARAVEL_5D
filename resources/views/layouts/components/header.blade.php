{{-- Top Navigation Header (shadcn dashboard-01 top bar + SidebarTrigger) --}}
<header class="sticky top-0 z-30 h-16 bg-white/95 backdrop-blur-md border-b border-[#fed7dc] px-4 md:px-8 flex items-center justify-between">
    {{-- Left: Desktop & Mobile Sidebar Trigger + Breadcrumbs --}}
    <div class="flex items-center gap-3">
        {{-- Sidebar Trigger Button (Active for both Desktop and Mobile per shadcn) --}}
        <button type="button"
                @click="window.innerWidth < 768 ? mobileSidebarOpen = !mobileSidebarOpen : toggleSidebar()"
                class="p-2 rounded-xl text-zinc-600 hover:text-[#f43f5e] hover:bg-rose-50 border border-transparent hover:border-[#fed7dc] transition-all"
                title="Toggle Sidebar (Ctrl+B / ⌘B)">
            <i class="bi bi-layout-sidebar-inset text-base"></i>
        </button>

        {{-- Dynamic Breadcrumbs --}}
        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('dashboard') }}" class="text-[#6e6e64] hover:text-[#f43f5e] font-medium transition-colors">
                Red Menstruasi
            </a>
            <span class="text-zinc-300">/</span>
            <span class="text-[#14140f] font-semibold tracking-tight">
                @hasSection('header_title')
                    @yield('header_title')
                @else
                    Dashboard
                @endif
            </span>
        </div>
    </div>

    {{-- Right Controls: Search button, Notifications dropdown, Profile pill --}}
    <div class="flex items-center gap-2.5">
        {{-- Command Palette Quick Button --}}
        <button type="button"
                @click="searchOpen = true"
                class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-xs text-zinc-500 bg-[#fdfafb] hover:bg-rose-50 border border-[#fed7dc] rounded-full transition-colors">
            <i class="bi bi-search text-xs text-zinc-400"></i>
            <span>Cari cepat...</span>
            <span class="px-1.5 py-0.2 bg-white text-[10px] font-mono border border-[#fed7dc] rounded text-zinc-500">⌘K</span>
        </button>


        {{-- Notifications Dropdown Component --}}
        <div class="relative" x-data="{ notifOpen: false }">
            <button type="button"
                    @click="notifOpen = !notifOpen"
                    class="relative p-2 rounded-xl text-zinc-600 hover:text-[#f43f5e] hover:bg-rose-50 transition-colors"
                    title="Notifikasi Siklus">
                <i class="bi bi-bell text-base"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#f43f5e] ring-2 ring-white"></span>
            </button>

            {{-- Notifications Popover --}}
            <div x-show="notifOpen"
                 x-cloak
                 @click.outside="notifOpen = false"
                 x-transition:enter="ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 class="absolute right-0 top-12 w-80 bg-white rounded-[24px] border border-[#fed7dc] shadow-2xl p-4 z-50 space-y-3">

                <div class="flex items-center justify-between pb-2 border-b border-zinc-100">
                    <h5 class="text-xs font-semibold uppercase tracking-wider text-[#14140f]">Notifikasi & Pengingat</h5>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 font-bold">2 Baru</span>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="p-2.5 rounded-[18px] bg-rose-50 border border-rose-100 flex items-start gap-2.5">
                        <span class="w-7 h-7 rounded-full bg-[#f43f5e] text-white flex items-center justify-center shrink-0 text-xs">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                        <div>
                            <strong class="text-zinc-900 block text-xs">Prediksi Haid Mendatang</strong>
                            <p class="text-[11px] text-zinc-600 mt-0.5">Siklus berikutnya diprediksi 14 hari lagi (14 Nov 2026).</p>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-[18px] bg-zinc-50 border border-zinc-200 flex items-start gap-2.5">
                        <span class="w-7 h-7 rounded-full bg-zinc-800 text-white flex items-center justify-center shrink-0 text-xs">
                            <i class="bi bi-capsule"></i>
                        </span>
                        <div>
                            <strong class="text-zinc-900 block text-xs">Pengingat Vitamin</strong>
                            <p class="text-[11px] text-zinc-600 mt-0.5">Sangobion (Zat Besi) dijadwalkan setiap pukul 20:00 WITA.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-zinc-100 text-center">
                    <a href="{{ route('reminders.index') }}" class="text-[11px] text-[#f43f5e] font-semibold hover:underline">
                        Kelola Semua Pengingat &rarr;
                    </a>
                </div>
            </div>
        </div>

        {{-- User Profile Pill (Fast indicator) --}}
        <div class="flex items-center gap-2 pl-2 border-l border-zinc-200">
            <div class="w-8 h-8 rounded-full bg-[#f43f5e] text-white text-xs font-bold flex items-center justify-center">
                FM
            </div>
            <div class="hidden md:flex flex-col text-left leading-none">
                <span class="text-xs font-semibold text-[#14140f]">Fija Mushofaini</span>
                <span class="text-[10px] text-[#6e6e64]">TI 5D BJB</span>
            </div>
        </div>
    </div>
</header>
