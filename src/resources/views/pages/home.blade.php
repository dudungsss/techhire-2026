<x-layouts.app>
    @php
        $categories = \App\Models\Category::withCount('jobs')->orderBy('name')->get();
        $totalJobs = \App\Models\Job::published()->count();
    @endphp

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Temukan Pekerjaan IT<br />Impianmu
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                    Platform rekrutmen IT berbasis skill. Cocokkan keahlianmu dengan ribuan lowongan dari perusahaan terverifikasi.
                </p>

                <form method="GET" action="{{ route('jobs.index') }}" class="max-w-xl mx-auto">
                    <div class="flex items-center bg-white rounded-xl p-1.5 shadow-2xl shadow-blue-900/30">
                        <input type="text" name="search" placeholder="Cari posisi, skill, atau perusahaan..."
                               class="flex-1 px-4 py-3 text-gray-900 placeholder-gray-400 bg-transparent border-0 focus:ring-0 text-base">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            <span class="hidden sm:inline">Cari</span>
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <a href="{{ route('jobs.index') }}"
                       class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-semibold backdrop-blur-sm transition">
                        <i class="fas fa-briefcase"></i>
                        Lihat Semua Lowongan
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 px-6 py-3 rounded-xl font-semibold transition shadow-lg">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    @if($categories->isNotEmpty())
    <section class="py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Kategori IT Populer</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Temukan lowongan berdasarkan bidang keahlian yang kamu kuasai.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($categories as $cat)
                    <a href="{{ route('jobs.index', ['category' => $cat->id]) }}" wire:navigate
                       class="group bg-white border border-gray-100 rounded-xl p-6 text-center hover:border-blue-200 hover:shadow-lg hover:shadow-blue-50 transition-all">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 transition">
                            <i class="fas fa-code text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition">{{ $cat->name }}</h3>
                        <p class="text-sm text-gray-400 mt-1">{{ $cat->jobs_count }} lowongan</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Value Propositions --}}
    <section class="py-16 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Kenapa TechHire?</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Kami hadir untuk merevolusi cara kamu mencari pekerjaan IT.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-microchip text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Fokus IT</h3>
                    <p class="text-gray-500 leading-relaxed">Seluruh ekosistem dikhususkan pada rumpun profesi teknologi informasi agar pencarian lebih spesifik dan terarah.</p>
                </div>
                <div class="bg-white rounded-xl p-8 border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Skill-Based Match</h3>
                    <p class="text-gray-500 leading-relaxed">Evaluasi kecocokan secara objektif melalui komparasi skill-mu dengan requirement lowongan secara otomatis.</p>
                </div>
                <div class="bg-white rounded-xl p-8 border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Recruiter Terverifikasi</h3>
                    <p class="text-gray-500 leading-relaxed">Setiap akun recruiter melewati verifikasi admin untuk meminimalisir risiko lowongan palsu.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-8 md:p-10 text-white">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-user-tie text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Untuk Pencari Kerja</h3>
                    <ul class="space-y-3 mb-8 text-blue-100">
                        <li class="flex items-start gap-3"><i class="fas fa-check-circle mt-1 text-blue-200"></i> Buat profil portofolio dan unggah CV</li>
                        <li class="flex items-start gap-3"><i class="fas fa-check-circle mt-1 text-blue-200"></i> Dapatkan skor kecocokan skill otomatis</li>
                        <li class="flex items-start gap-3"><i class="fas fa-check-circle mt-1 text-blue-200"></i> Lacak status lamaran secara real-time</li>
                    </ul>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 bg-white text-blue-700 px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
                        Daftar Sebagai Pelamar <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 md:p-10 text-white">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Untuk Recruiter</h3>
                    <ul class="space-y-3 mb-8 text-gray-300">
                        <li class="flex items-start gap-3"><i class="fas fa-check-circle mt-1 text-gray-400"></i> Publikasi lowongan dan kelola perusahaan</li>
                        <li class="flex items-start gap-3"><i class="fas fa-check-circle mt-1 text-gray-400"></i> Urutkan kandidat berdasarkan skor kecocokan</li>
                        <li class="flex items-start gap-3"><i class="fas fa-check-circle mt-1 text-gray-400"></i> Dapatkan kandidat berkualitas dan relevan</li>
                    </ul>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-900/30">
                        Daftar Sebagai Recruiter <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
