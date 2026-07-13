<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold">{{ isset($job) ? 'Edit Lowongan' : 'Buat Lowongan Baru' }}</h1>
        <p class="text-gray-500 mb-8">{{ isset($job) ? 'Perbarui detail lowongan.' : 'Isi detail untuk mempublikasikan lowongan baru.' }}</p>
        <div class="bg-white border border-gray-100 rounded-xl p-8">
            @livewire('recruiter.job-form', isset($job) ? ['job' => $job] : [])
        </div>
    </div>
</x-layouts.app>
