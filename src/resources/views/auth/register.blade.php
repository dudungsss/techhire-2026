<x-layouts.app>
    <div class="min-h-[calc(100vh-8rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-xl text-white mb-4">
                    <i class="fas fa-code-branch fa-2x"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900">Daftar Akun</h2>
                <p class="mt-2 text-sm text-gray-600">Bergabung dengan TechHire sebagai pencari kerja atau perekrut</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form class="mt-8 space-y-5" method="POST" action="{{ route('register.store') }}">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="John Doe">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Kerja</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="nama@company.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Daftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center gap-2 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-blue-400 transition bg-white has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                            <input type="radio" name="account_type" value="pelamar" {{ old('account_type', 'pelamar') === 'pelamar' ? 'checked' : '' }} class="sr-only">
                            <i class="fas fa-user-tie text-gray-400"></i>
                            <span class="font-semibold text-gray-700 text-sm">Pelamar</span>
                        </label>
                        <label class="flex items-center justify-center gap-2 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-blue-400 transition bg-white has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                            <input type="radio" name="account_type" value="recruiter" {{ old('account_type') === 'recruiter' ? 'checked' : '' }} class="sr-only">
                            <i class="fas fa-building text-gray-400"></i>
                            <span class="font-semibold text-gray-700 text-sm">Recruiter</span>
                        </label>
                    </div>
                    @error('account_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                           class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Ulangi password">
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                    DAFTAR
                </button>
            </form>

            <div class="text-center mt-6 text-sm">
                <span class="text-gray-500">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk</a>
            </div>
        </div>
    </div>
</x-layouts.app>
