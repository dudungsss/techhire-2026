<div>
    <div class="space-y-4">
        @forelse($applications as $app)
            <div class="bg-white border border-gray-100 rounded-lg p-6 flex flex-col sm:flex-row justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $app->job->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $app->job->company->name }} &bull; {{ $app->job->location }}</p>
                    <span class="text-xs text-gray-400 mt-1 block">Melamar {{ $app->created_at->diffForHumans() }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded text-xs font-bold
                                 {{ $app->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                                 {{ $app->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                 {{ $app->status === 'reviewed' || $app->status === 'shortlisted' ? 'bg-blue-50 text-blue-700' : '' }}
                                 {{ $app->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($app->status) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>Belum ada lamaran.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
