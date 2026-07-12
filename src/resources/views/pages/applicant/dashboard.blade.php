<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halo, {{ auth()->user()->name ?? 'User' }}! Siap untuk tantangan baru?</h1>
                <p class="text-gray-500">Lengkapi profil Anda untuk mendapatkan kecocokan yang lebih baik.</p>
            </div>
                @php $completeness = auth()->user()->profileCompletenessPercentage(); @endphp
                <div class="bg-white p-4 rounded-lg border border-gray-100">
                    <div class="flex justify-between items-center gap-4 mb-2">
                        <span class="text-sm text-gray-500">Profil</span>
                        <span class="text-sm font-bold text-blue-600">{{ $completeness }}%</span>
                    </div>
                    <div class="bg-gray-200 h-2 w-40 rounded-full">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $completeness }}%;"></div>
                    </div>
                </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Lamaran Dikirim</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ auth()->user()->jobApplications()->count() }}</p>
                </div>
                <i class="fas fa-paper-plane text-blue-500 text-3xl opacity-60"></i>
            </div>
            <a href="{{ route('applicant.bookmarks') }}" wire:navigate class="bg-white p-6 rounded-lg border border-gray-100 flex items-center justify-between hover:border-yellow-200 transition">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Disimpan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ auth()->user()->bookmarkedJobs()->count() }}</p>
                </div>
                <i class="fas fa-bookmark text-yellow-500 text-3xl opacity-60"></i>
            </a>
            @php
                $pendingInvitations = \App\Models\InterviewInvitation::whereHas('jobApplication', fn($q) => $q->where('user_id', auth()->id()))->where('status', 'pending')->count();
                $totalInvitations = \App\Models\InterviewInvitation::whereHas('jobApplication', fn($q) => $q->where('user_id', auth()->id()))->count();
            @endphp
            <a href="#undangan" class="bg-white p-6 rounded-lg border border-gray-100 flex items-center justify-between hover:border-green-200 transition">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Interview</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalInvitations }}</p>
                </div>
                <div class="text-right">
                    <i class="fas fa-calendar-check text-green-500 text-3xl opacity-60 mb-1 block"></i>
                    @if($pendingInvitations > 0)
                        <span class="text-xs font-bold text-green-600">{{ $pendingInvitations }} baru</span>
                    @endif
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Lamaran Terbaru</h2>
                @php
                    $recentApplications = auth()->user()->jobApplications()->with('job.company')->latest()->take(5)->get();
                @endphp
                @forelse($recentApplications as $app)
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $app->job?->title ?? 'Lowongan telah dihapus' }}</h3>
                            <p class="text-sm text-gray-500">{{ $app->job?->company?->name ?? '-' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded text-xs font-bold
                            {{ $app->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $app->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $app->status === 'reviewed' || $app->status === 'shortlisted' ? 'bg-blue-50 text-blue-700' : '' }}
                            {{ $app->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Belum ada lamaran.</p>
                @endforelse
                @if($recentApplications->count() > 0)
                    <a href="{{ route('applicant.applications.index') }}" class="block text-center mt-4 text-blue-600 font-semibold hover:underline">
                        Lihat Semua Lamaran
                    </a>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('applicant.profile') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-user-edit text-blue-600"></i>
                        <span class="text-gray-700 font-medium">Edit Profil</span>
                    </a>
                    <a href="{{ route('jobs.index') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-search text-blue-600"></i>
                        <span class="text-gray-700 font-medium">Cari Lowongan</span>
                    </a>
                    <a href="{{ route('applicant.applications.index') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-file-alt text-blue-600"></i>
                        <span class="text-gray-700 font-medium">Cek Status Lamaran</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Rekomendasi Lowongan --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 mt-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                <i class="fas fa-star text-yellow-500 mr-2"></i>Rekomendasi Lowongan
            </h2>
            @livewire('applicant.job-recommendations')
        </div>

        {{-- Undangan Interview --}}
        <div id="undangan" class="bg-white rounded-xl border border-gray-100 p-6 mt-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                <i class="fas fa-calendar-check text-green-500 mr-2"></i>Undangan Interview
            </h2>
            @livewire('applicant.interview-invitations')
        </div>
    </div>
</x-layouts.app>
