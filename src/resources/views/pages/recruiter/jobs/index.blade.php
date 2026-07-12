<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-2xl font-bold">Kelola Lowongan</h1>
                <p class="text-gray-500">Semua lowongan aktif dan draft.</p>
            </div>
            <a href="{{ route('recruiter.jobs.create') }}"
               class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold flex items-center gap-2 hover:bg-blue-700 transition no-underline">
                <i class="fas fa-plus"></i> Buat Lowongan
            </a>
        </div>
        @livewire('recruiter.job-list')
    </div>
</x-layouts.app>
