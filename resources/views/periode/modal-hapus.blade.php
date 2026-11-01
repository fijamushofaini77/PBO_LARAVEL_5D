{{-- Modal Hapus Periode (Modul SIMTIKUM Pertemuan 5) --}}
<div id="modal-hapus-{{ $periode->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/60 backdrop-blur-xs hidden" role="dialog" aria-modal="true" aria-labelledby="modal-hapus-label-{{ $periode->id }}">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-rose-100 overflow-hidden animate-scale-in text-left">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50">
            <h5 class="text-sm font-semibold text-zinc-900 flex items-center gap-2" id="modal-hapus-label-{{ $periode->id }}">
                <span class="w-6 h-6 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xs">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </span>
                Hapus Periode
            </h5>
            <button type="button" onclick="document.getElementById('modal-hapus-{{ $periode->id }}').classList.add('hidden')" class="text-zinc-400 hover:text-zinc-700 p-1 rounded-md" aria-label="Tutup">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <p class="text-xs text-zinc-600 leading-relaxed">
                Yakin ingin menghapus periode <strong class="text-zinc-900 font-semibold">{{ $periode->periode }}</strong>?
                Data yang sudah dihapus tidak dapat dikembalikan.
            </p>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-3.5 bg-zinc-50 border-t border-zinc-100 flex items-center justify-end gap-2">
            <button type="button" onclick="document.getElementById('modal-hapus-{{ $periode->id }}').classList.add('hidden')" class="px-3.5 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-200/70 bg-white border border-zinc-200 rounded-lg transition-colors">
                Batal
            </button>
            <form action="{{ route('periode.destroy', $periode) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-1.5 text-xs font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition-colors inline-flex items-center gap-1.5 shadow-sm shadow-rose-600/30">
                    <i class="bi bi-trash" aria-hidden="true"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

