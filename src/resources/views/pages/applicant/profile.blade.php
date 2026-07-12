<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Profil Saya</h1>
        <p class="text-gray-500 mb-8">Kelola keahlian, pengalaman, dan preferensi Anda.</p>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl p-8">
                @livewire('applicant.profile-form')
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-6 h-fit sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tips Profil</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex gap-2"><i class="fas fa-check-circle text-green-500 mt-0.5"></i> Tambahkan minimal 5 keahlian</li>
                    <li class="flex gap-2"><i class="fas fa-check-circle text-green-500 mt-0.5"></i> Unggah foto profesional</li>
                    <li class="flex gap-2"><i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i> Lengkapi riwayat pekerjaan</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
