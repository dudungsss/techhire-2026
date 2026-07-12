<div class="space-y-4">
    @if (session('success'))
        <div class="rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($jobs as $job)
        <div class="bg-white p-6 rounded-2xl border flex justify-between items-center hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg">
                    {{ ($jobs->currentPage() - 1) * $jobs->perPage() + $loop->iteration }}
                </div>
                <div>
                    <h4 class="font-bold text-lg">{{ $job->title }}</h4>
                    <p class="text-xs text-gray-400 uppercase tracking-widest">
                        {{ $job->is_published ? 'DIPUBLIKASIKAN' : 'DRAFT' }} &bull; {{ $job->applications_count }} LAMARAN
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                @if ($job->is_published)
                    <a href="{{ route('jobs.show', $job) }}"
                       class="p-2 text-gray-400 hover:text-blue-600 transition">
                        <i class="fas fa-eye"></i>
                    </a>
                @endif
                <a href="{{ route('recruiter.jobs.edit', $job) }}"
                   class="p-2 text-gray-400 hover:text-blue-600 transition">
                    <i class="fas fa-edit"></i>
                </a>
                <button wire:click="togglePublish({{ $job->id }})"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition
                            {{ $job->is_published ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                    {{ $job->is_published ? 'Unpublish' : 'Publish' }}
                </button>
                @if ($job->applications_count > 0)
                    <a href="{{ route('recruiter.applications') }}?selectedJobId={{ $job->id }}"
                       class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition">
                        Lihat Pelamar
                    </a>
                @endif
                <button wire:click="delete({{ $job->id }})"
                        wire:confirm="Yakin hapus lowongan ini?"
                        class="px-4 py-2 bg-red-50 text-red-500 rounded-lg text-xs font-bold hover:bg-red-100 transition">
                    Hapus
                </button>
            </div>
        </div>

        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    @empty
        <div class="bg-white p-12 rounded-2xl border text-center">
            <i class="fas fa-briefcase text-4xl text-gray-300 mb-4 block"></i>
            <h3 class="text-lg font-bold text-gray-500">Belum ada lowongan</h3>
            <a href="{{ route('recruiter.jobs.create') }}"
               class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">
                Buat Lowongan Pertama
            </a>
        </div>
    @endforelse
</div>
