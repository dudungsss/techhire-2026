<div>
    <form wire:submit="apply" class="flex flex-col gap-5">
        {{-- Cover Letter --}}
        <div>
            <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                Surat Lamaran (Opsional)
            </label>
            <textarea id="cover_letter" wire:model="cover_letter" rows="5"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                             placeholder="Jelaskan mengapa Anda cocok untuk posisi ini..."></textarea>
        </div>

        {{-- Resume Upload --}}
        <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CV / Resume</label>
            <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-blue-400 transition-colors cursor-pointer bg-gray-50"
                 x-data
                 x-on:click="$refs.fileInput.click()">
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                <p class="text-sm text-gray-500">Seret & lepas atau klik untuk unggah</p>
                <input type="file" wire:model="cv" x-ref="fileInput" class="hidden" accept=".pdf,.doc,.docx">
            </div>
            @error('cv') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled">
            <span wire:loading.remove>Kirim Lamaran</span>
            <span wire:loading class="flex items-center justify-center gap-2">
                <i class="fas fa-spinner fa-spin"></i> Mengirim...
            </span>
        </button>

        @if(session('success'))
            <div class="p-3 bg-green-100 border border-green-200 rounded-lg text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>
