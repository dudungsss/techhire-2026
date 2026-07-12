<div>
    <form wire:submit="save" class="flex flex-col gap-6">
        {{-- Basic Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" wire:model="name"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" wire:model="phone"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="+62 xxx">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Avatar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
            @if(auth()->user()->avatar_url)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar" class="h-20 w-20 object-cover rounded-full border">
                </div>
            @endif
            <input type="file" wire:model="avatar" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('avatar')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <div wire:loading wire:target="avatar" class="text-xs text-blue-600 mt-1">
                <i class="fas fa-spinner fa-spin"></i> Mengunggah...
            </div>
        </div>

        {{-- Summary --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ringkasan Profesional</label>
            <textarea wire:model="summary" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500 resize-none"
                      placeholder="Deskripsi singkat tentang diri Anda..."></textarea>
            @error('summary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Skills --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian</label>

            {{-- Selected Skills --}}
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($skills as $skill)
                    @if(in_array((string) $skill->id, $skill_ids))
                        <span class="px-3 py-1 rounded bg-blue-50 border border-blue-100 text-blue-700 text-xs flex items-center gap-1">
                            {{ $skill->name }}
                            <button type="button" wire:click="removeSkill({{ $skill->id }})" class="hover:text-red-500 transition-colors">&times;</button>
                        </span>
                    @endif
                @endforeach
            </div>

            {{-- Skill Picker --}}
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700">Pilih skill Anda</span>
                    <button type="button" wire:click="$toggle('showSkillPicker')"
                            class="text-xs text-blue-600 hover:underline">
                        {{ $showSkillPicker ? 'Tutup' : 'Pilih Skill' }}
                    </button>
                </div>
                @if($showSkillPicker)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-60 overflow-y-auto">
                        @foreach($skills as $skill)
                            @php $isSelected = in_array((string) $skill->id, $skill_ids); @endphp
                            <button type="button"
                                    wire:click="{{ $isSelected ? 'removeSkill(' . $skill->id . ')' : 'addSkill(' . $skill->id . ')' }}"
                                    class="text-left px-3 py-2 rounded text-sm border transition
                                        {{ $isSelected
                                            ? 'bg-blue-50 border-blue-200 text-blue-700'
                                            : 'bg-white border-gray-200 text-gray-600 hover:border-blue-300' }}">
                                {{ $skill->name }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
            @error('skill_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Links --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">GitHub</label>
                <input type="url" wire:model="github_url"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="https://github.com/username">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                <input type="url" wire:model="linkedin_url"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="https://linkedin.com/in/username">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Portfolio</label>
                <input type="url" wire:model="portfolio_url"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="https://portfolio.dev">
            </div>
        </div>

        {{-- CV Upload --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">CV (PDF/DOCX)</label>
            <input type="file" wire:model="cv" accept=".pdf,.doc,.docx"
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('cv') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            <div wire:loading wire:target="cv" class="text-xs text-blue-600 mt-1">
                <i class="fas fa-spinner fa-spin"></i> Mengunggah...
            </div>
        </div>

        {{-- Save --}}
        <button type="submit"
                 class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100 self-start">
            Simpan Profil
        </button>

        @if(session('success'))
            <div class="p-3 bg-green-100 border border-green-200 rounded-lg text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>
