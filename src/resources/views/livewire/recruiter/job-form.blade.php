<div>
    @if (session('success'))
        <div class="rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700 mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 mb-6">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="save" class="flex flex-col gap-6 max-w-3xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Lowongan</label>
                <input type="text" wire:model="title"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="e.g. Senior Laravel Developer">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select wire:model="category_id"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500">
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pekerjaan</label>
                <select wire:model="employment_type"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500">
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                    <option value="freelance">Freelance</option>
                </select>
                @error('employment_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Level Pengalaman</label>
                <select wire:model="experience_level"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500">
                    <option value="fresh_graduate">Fresh Graduate</option>
                    <option value="junior">Junior</option>
                    <option value="mid">Mid</option>
                    <option value="senior">Senior</option>
                </select>
                @error('experience_level') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <input type="text" wire:model="location"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Jakarta / Remote">
                @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Batas Deadline</label>
                <input type="date" wire:model="deadline_at"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                @error('deadline_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gaji Minimal</label>
                <input type="number" wire:model="salary_min"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Rp">
                @error('salary_min') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gaji Maksimal</label>
                <input type="number" wire:model="salary_max"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Rp">
                @error('salary_max') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Skill yang Dibutuhkan</label>
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
            <div class="flex flex-wrap gap-2">
                @foreach($skills as $skill)
                    @if(!in_array((string) $skill->id, $skill_ids))
                        <button type="button" wire:click="addSkill({{ $skill->id }})"
                                class="px-3 py-1 rounded text-xs border border-gray-200 bg-white text-gray-600 hover:border-blue-300 hover:text-blue-600 transition">
                            + {{ $skill->name }}
                        </button>
                    @endif
                @endforeach
            </div>
            @error('skill_ids') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pekerjaan</label>
            <textarea wire:model="description" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 resize-none"
                      placeholder="Deskripsi umum pekerjaan..."></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kualifikasi / Requirements</label>
            <textarea wire:model="requirements" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 resize-none"
                      placeholder="Syarat dan kualifikasi..."></textarea>
            @error('requirements') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggung Jawab</label>
            <textarea wire:model="responsibilities" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 resize-none"
                      placeholder="Job desk dan tanggung jawab..."></textarea>
            @error('responsibilities') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" wire:model="is_published" id="is_published"
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="is_published" class="text-sm font-medium text-gray-700">Publikasikan langsung</label>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                {{ $job ? 'Update Lowongan' : 'Simpan Lowongan' }}
            </button>
            <a href="{{ route('recruiter.jobs.index') }}" wire:navigate
               class="px-8 py-3 rounded-lg font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition text-center">
                Batal
            </a>
        </div>
    </form>
</div>
