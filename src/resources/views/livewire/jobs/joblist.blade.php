<div>
    <section class="bg-white py-16 border-b">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                Temukan Karir IT yang <span class="text-blue-600 underline decoration-blue-200">Sesuai Skill Anda</span>
            </h1>
            <p class="text-lg text-gray-500 mb-10 max-w-2xl mx-auto">
                TechHire mencocokkan profil teknis Anda dengan kebutuhan perusahaan secara presisi menggunakan Skill Match Score.
            </p>

            <div class="max-w-4xl mx-auto bg-white p-2 rounded-2xl shadow-xl border flex flex-col md:flex-row gap-2">
                <div class="flex-1 flex items-center px-4 border-b md:border-b-0 md:border-r">
                    <i class="fas fa-search text-gray-400 mr-3"></i>
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Posisi (contoh: Backend Developer)" class="w-full py-3 outline-none">
                </div>
                <div class="flex-1 flex items-center px-4">
                    <i class="fas fa-map-marker-alt text-gray-400 mr-3"></i>
                    <input type="text" wire:model.live.debounce.500ms="location" placeholder="Lokasi (contoh: Jakarta / Remote)" class="w-full py-3 outline-none">
                </div>
                <button class="bg-blue-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                    Cari Kerja
                </button>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 py-12 flex flex-col lg:flex-row gap-8">
        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm sticky top-24">
                <h3 class="font-bold text-lg mb-4">Filter Pencarian</h3>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Kategori</label>
                    <select wire:model.live="category" class="w-full rounded-lg border-gray-200 text-sm">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Level Pengalaman</label>
                    <div class="space-y-2">
                        @foreach (['fresh_graduate' => 'Fresh Graduate', 'junior' => 'Junior', 'mid' => 'Mid', 'senior' => 'Senior'] as $val => $label)
                            <label class="flex items-center text-gray-600 text-sm cursor-pointer">
                                <input type="checkbox" wire:model.live="experienceLevel" value="{{ $val }}" class="mr-2 rounded">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Tipe Pekerjaan</label>
                    <div class="space-y-2">
                        @foreach (['full_time' => 'Full Time', 'part_time' => 'Part Time', 'contract' => 'Contract', 'internship' => 'Internship', 'freelance' => 'Freelance'] as $val => $label)
                            <label class="flex items-center text-gray-600 text-sm cursor-pointer">
                                <input type="checkbox" wire:model.live="employmentType" value="{{ $val }}" class="mr-2 rounded">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <button wire:click="resetFilters" class="w-full bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
                    Reset Filter
                </button>
            </div>
        </aside>

        <div class="w-full lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Lowongan Terbaru Untuk Anda</h2>
                <span class="text-sm text-gray-400">{{ $jobs->total() }} lowongan</span>
            </div>

            <div class="space-y-4">
                @forelse ($jobs as $job)
                    @php
                        $salary = null;
                        if ($job->salary_min || $job->salary_max) {
                            $salary = 'Rp ' . number_format($job->salary_min ?? 0, 0, ',', '.') . ' - Rp ' . number_format($job->salary_max ?? 0, 0, ',', '.');
                        }
                        $location = $job->location ?? '-';
                    @endphp
                    <div class="relative">
                        <x-job-card
                            :title="$job->title"
                            :company="$job->company?->name ?? '-'"
                            :location="$location"
                            :salary="$salary"
                            :matchScore="$showMatchScore ? $job->match_score : null"
                            :skills="$job->skills->pluck('name')->toArray()"
                            :detailUrl="route('jobs.show', $job)"
                        />
                        @auth
                            @if(auth()->user()->hasRole('pelamar'))
                                <button wire:click="toggleBookmark({{ $job->id }})"
                                        class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-lg transition
                                            {{ in_array($job->id, $bookmarkedIds) ? 'text-yellow-500 hover:text-yellow-600' : 'text-gray-300 hover:text-yellow-400' }}">
                                    <i class="{{ in_array($job->id, $bookmarkedIds) ? 'fas' : 'far' }} fa-bookmark"></i>
                                </button>
                            @endif
                        @endauth
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-2xl border border-gray-100 text-center">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 font-medium">Belum ada lowongan yang tersedia.</p>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
