<div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300">
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <div class="flex gap-4">
            <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                <i class="fas fa-building fa-2x"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $title }}</h3>
                <p class="text-gray-600 font-medium">{{ $company }}</p>
                <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-500">
                    <span class="flex items-center gap-1"><i class="fas fa-map-marker-alt"></i> {{ $location }}</span>
                    @if ($salary)
                        <span class="flex items-center gap-1"><i class="fas fa-money-bill-wave"></i> {{ $salary }}</span>
                    @endif
                </div>
            </div>
        </div>

        @if ($matchScore !== null)
            <div class="flex flex-col items-center md:items-end justify-center border-t md:border-t-0 md:border-l pt-4 md:pt-0 md:pl-6">
                <div class="relative w-16 h-16">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path class="text-gray-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="{{ $matchScore >= 70 ? 'text-green-500' : ($matchScore >= 40 ? 'text-yellow-500' : 'text-orange-400') }}" stroke-width="3" stroke-dasharray="{{ $matchScore }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center text-xs font-bold">
                        {{ $matchScore }}%
                    </div>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mt-1">Skill Match</p>
            </div>
        @endif
    </div>

    <div class="mt-6 flex flex-wrap justify-between items-center gap-4">
        <div class="flex flex-wrap gap-2">
            @foreach($skills as $skill)
                <span class="bg-gray-50 text-gray-600 px-2 py-1 rounded text-[11px] font-semibold border border-gray-100">
                    {{ $skill }}
                </span>
            @endforeach
        </div>
        <a href="{{ $detailUrl }}" class="bg-gray-50 text-blue-600 font-bold px-6 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition border border-blue-100">
            Lihat Detail
        </a>
    </div>
</div>
