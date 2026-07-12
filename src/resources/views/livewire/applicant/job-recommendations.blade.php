<div>
    @if($recommendations->isNotEmpty())
        <div class="space-y-3">
            @foreach($recommendations as $job)
                <a href="{{ route('jobs.show', $job->slug) }}"
                   class="block p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $job->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $job->company?->name }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($job->skills->take(3) as $skill)
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $skill->name }}</span>
                                @endforeach
                                @if($job->skills->count() > 3)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-xs rounded-full">+{{ $job->skills->count() - 3 }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 text-center shrink-0">
                            <div class="w-12 h-12 rounded-full border-2 flex items-center justify-center
                                {{ $job->match_score >= 70 ? 'border-green-500 text-green-600' : ($job->match_score >= 40 ? 'border-yellow-500 text-yellow-600' : 'border-orange-400 text-orange-500') }}">
                                <span class="text-xs font-bold">{{ $job->match_score }}%</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1">cocok</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('jobs.index') }}" class="text-blue-600 font-semibold text-sm hover:underline">
                Lihat Semua Lowongan
            </a>
        </div>
    @else
        <div class="text-center py-8 text-gray-400">
            <i class="fas fa-search text-3xl mb-2"></i>
            <p class="text-sm">Tidak ada rekomendasi saat ini.</p>
            <p class="text-xs mt-1">Lengkapi skill di profil kamu untuk mendapatkan rekomendasi yang lebih baik.</p>
        </div>
    @endif
</div>
