<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors mb-6">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar lowongan
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl p-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $job->title }}</h1>

                <div class="flex flex-wrap items-center gap-4 text-gray-500 mb-6">
                    <span class="flex items-center gap-2"><i class="fas fa-building"></i> {{ $job->company?->name ?? '-' }}</span>
                    <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt"></i> {{ $job->location ?? 'Remote' }}</span>
                    @if($job->employment_type)
                        <span class="flex items-center gap-2"><i class="fas fa-clock"></i> {{ Str::headline($job->employment_type) }}</span>
                    @endif
                    @if($job->experience_level)
                        <span class="flex items-center gap-2"><i class="fas fa-level-up-alt"></i> {{ Str::headline($job->experience_level) }}</span>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($job->skills as $skill)
                        <span class="px-3 py-1 rounded bg-gray-50 border border-gray-100 text-gray-600 text-sm">{{ $skill->name }}</span>
                    @endforeach
                </div>

                <div class="prose max-w-none text-gray-700">
                    <h3 class="text-lg font-bold text-gray-900">Deskripsi Pekerjaan</h3>
                    <p>{{ $job->description }}</p>

                    @if($job->requirements)
                        <h3 class="text-lg font-bold text-gray-900 mt-6">Kualifikasi</h3>
                        {!! nl2br(e($job->requirements)) !!}
                    @endif

                    @if($job->responsibilities)
                        <h3 class="text-lg font-bold text-gray-900 mt-6">Tanggung Jawab</h3>
                        {!! nl2br(e($job->responsibilities)) !!}
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-xl p-6 sticky top-24">
                    @if($matchScore !== null)
                    <div class="text-center mb-6">
                        <div class="text-3xl font-bold text-blue-600">{{ $matchScore }}%</div>
                        <div class="text-xs font-bold uppercase tracking-wider text-gray-400 mt-1">Skill Match</div>
                        @if($matchedSkills->count() > 0)
                            <div class="mt-4 text-left">
                                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Tercocok</p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($matchedSkills as $skill)
                                        <span class="text-xs px-2 py-0.5 rounded bg-green-50 text-green-700 border border-green-100">{{ $skill->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($missingSkills->count() > 0)
                            <div class="mt-3 text-left">
                                <p class="text-xs font-bold text-orange-500 uppercase tracking-wider">Kurang</p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($missingSkills as $skill)
                                        <span class="text-xs px-2 py-0.5 rounded bg-orange-50 text-orange-600 border border-orange-100">{{ $skill->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    @auth
                        @if(auth()->user()->hasRole('pelamar'))
                            <livewire:jobs.apply-job-form :job="$job" :wire:key="$job->id" />
                        @else
                            <div class="bg-yellow-50 border border-yellow-100 text-yellow-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
                                <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                <span>Hanya pelamar yang dapat melamar lowongan.</span>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="block w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-center hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Masuk untuk Melamar
                        </a>
                    @endauth

                    <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <h4 class="font-bold text-gray-900 text-sm mb-2">Informasi Lowongan</h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Kategori</span>
                                <span class="font-medium text-gray-900">{{ $job->category?->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Gaji</span>
                                <span class="font-medium text-gray-900">
                                    @if($job->salary_min || $job->salary_max)
                                        Rp {{ number_format($job->salary_min ?? 0, 0, ',', '.') }} - Rp {{ number_format($job->salary_max ?? 0, 0, ',', '.') }}
                                    @else
                                        Dirahasiakan
                                    @endif
                                </span>
                            </div>
                            @if($job->deadline_at)
                            <div class="flex justify-between">
                                <span>Batas Akhir</span>
                                <span class="font-medium text-gray-900">{{ $job->deadline_at->format('d M Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
