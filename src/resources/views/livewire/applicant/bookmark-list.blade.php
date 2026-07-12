<div>
    <div class="space-y-4">
        @forelse($jobs as $job)
            <div class="bg-white border border-gray-100 rounded-lg p-6 flex flex-col sm:flex-row justify-between gap-4">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $job->company?->name ?? '-' }} &bull; {{ $job->location ?? 'Remote' }}</p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($job->skills as $skill)
                                <span class="text-xs px-2 py-0.5 rounded bg-gray-50 text-gray-500 border border-gray-100">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('jobs.show', $job) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                        Lihat Detail
                    </a>
                    <button wire:click="removeBookmark({{ $job->id }})"
                            wire:confirm="Hapus bookmark ini?"
                            class="px-4 py-2 bg-red-50 text-red-500 rounded-lg text-sm font-bold hover:bg-red-100 transition">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                <i class="far fa-bookmark text-4xl mb-3 text-gray-300"></i>
                <p class="font-medium">Belum ada lowongan tersimpan.</p>
                <a href="{{ route('jobs.index') }}" wire:navigate
                   class="mt-3 inline-block text-blue-600 hover:underline text-sm">Cari Lowongan</a>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
