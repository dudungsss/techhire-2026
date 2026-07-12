<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TechHire' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">

    <nav class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="bg-blue-600 p-1.5 rounded-lg text-white">
                            <i class="fas fa-code-branch fa-lg"></i>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-blue-600">TechHire</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8 font-medium">
    <!-- Menu Cari Lowongan -->
    <a href="{{ route('jobs.index') }}" 
       class="px-1 py-4 transition {{ request()->routeIs('jobs.index') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-blue-600' }}">
       Cari Lowongan
    </a>

    
                    @auth
                        @role('recruiter')
                            <a href="{{ route('recruiter.dashboard') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Dashboard</a>
                            <a href="{{ route('recruiter.company') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Perusahaan</a>
                            <a href="{{ route('recruiter.jobs.index') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Lowongan</a>
                            <a href="{{ route('recruiter.applications') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Pelamar</a>
                        @endrole
                        @role('pelamar')
                             <a href="{{ route('applicant.dashboard') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Dashboard</a>
                             <a href="{{ route('applicant.profile') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Profile</a>
                             <a href="{{ route('applicant.bookmarks') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Bookmark</a>
                             <a href="{{ route('applicant.applications.index') }}" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Lamaran</a>
                         @endrole
                        @role('admin|super_admin')
                            <a href="/admin" class="text-gray-500 hover:text-blue-600 px-1 py-4 transition">Admin</a>
                        @endrole
                    @endauth
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        @role('pelamar')
                            <livewire:applicant.notification-bell :key="'bell-' . auth()->id()" />
                        @endrole
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-5 py-2 rounded-full font-semibold hover:bg-red-600 transition text-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-200 text-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-white border-t py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500">&copy; 2026 TechHire - Platform Rekrutmen IT Berbasis Skill.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
