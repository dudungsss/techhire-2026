<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold">Dashboard Rekruter</h1>
                <p class="text-gray-500">Selamat datang kembali, {{ auth()->user()->company?->name ?? auth()->user()->name }}</p>
            </div>
            <a href="{{ route('recruiter.jobs.create') }}"
               class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Buat Lowongan
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-6 rounded-2xl text-white shadow-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm">Total Lowongan</p>
                        <h3 class="text-3xl font-bold">{{ auth()->user()->company?->jobs()->count() ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-briefcase text-3xl opacity-20"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pelamar</p>
                        @php
                            $totalApplicants = auth()->user()->company?->jobs()->withCount('applications')->get()->sum('applications_count') ?? 0;
                        @endphp
                        <h3 class="text-3xl font-bold">{{ $totalApplicants }}</h3>
                    </div>
                    <i class="fas fa-users text-gray-300 text-3xl"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Perusahaan</p>
                        <h3 class="text-lg font-bold truncate">{{ auth()->user()->company?->name ?? 'Belum diisi' }}</h3>
                    </div>
                    <i class="fas fa-building text-gray-300 text-3xl"></i>
                </div>
            </div>
        </div>

        <livewire:recruiter.job-list />
    </div>
</x-layouts.app>
