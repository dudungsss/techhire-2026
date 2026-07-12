<div>
    @if (session('success'))
        <div class="rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="flex flex-col gap-6 max-w-2xl">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
            <input type="text" wire:model="name"
                   class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Perusahaan</label>
            @if($company?->logo_path)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Logo" class="h-20 w-20 object-contain rounded-lg border">
                </div>
            @endif
            <input type="file" wire:model="logo" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('logo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <div wire:loading wire:target="logo" class="text-xs text-blue-600 mt-1">
                <i class="fas fa-spinner fa-spin"></i> Mengunggah...
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
            <textarea wire:model="address" rows="3"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500"></textarea>
            @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Perusahaan</label>
            <textarea wire:model="description" rows="4"
                      class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
            <input type="url" wire:model="website"
                   class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
            @error('website')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                <input type="email" wire:model="contact_email"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                @error('contact_email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon Kontak</label>
                <input type="text" wire:model="contact_phone"
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                @error('contact_phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition self-start">
            Simpan
        </button>
    </form>
</div>
