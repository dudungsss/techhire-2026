<div class="relative" wire:poll.30s>
    <button wire:click="toggleDropdown" class="relative p-2 text-gray-500 hover:text-blue-600 transition">
        <i class="fas fa-bell text-lg"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    @if($showDropdown)
        <div class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50" x-init="$el.querySelector('button')?.focus()" @click.away="console.log">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <h4 class="font-bold text-gray-900 text-sm">Notifikasi</h4>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:underline">
                        Tandai semua dibaca
                    </button>
                @endif
            </div>

            <div class="max-h-80 overflow-y-auto">
                @forelse($notifications as $notification)
                    @php $data = $notification->data; @endphp
                    <a href="{{ route('applicant.applications.index') }}"
                       wire:click="markAsRead('{{ $notification->id }}')"
                       class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 {{ $notification->read_at ? '' : 'bg-blue-50/50' }}">
                        <div class="flex gap-3">
                            <div class="mt-0.5">
                                <i class="fas fa-file-alt text-blue-500"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 font-medium leading-snug">
                                    Lamaran <span class="font-semibold">{{ $data['job_title'] }}</span>
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $data['company_name'] }} &bull; {{ ucfirst($data['new_status']) }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notification->read_at)
                                <span class="w-2 h-2 bg-blue-500 rounded-full shrink-0 mt-2"></span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-8 text-center text-gray-400 text-sm">
                        <i class="far fa-bell text-2xl mb-2"></i>
                        <p>Belum ada notifikasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
