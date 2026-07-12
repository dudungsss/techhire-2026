<div>
    @if($invitations->isNotEmpty())
        <div class="space-y-3">
            @foreach($invitations as $invitation)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100
                    {{ $invitation->status === 'accepted' ? 'border-green-200 bg-green-50/50' : '' }}
                    {{ $invitation->status === 'declined' ? 'border-red-200 bg-red-50/50' : '' }}">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $invitation->jobApplication->job->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $invitation->jobApplication->job->company->name }}</p>
                        </div>
                        <span class="px-2 py-1 rounded text-xs font-bold
                            {{ $invitation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $invitation->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $invitation->status === 'declined' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($invitation->status) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-700 mb-3">{{ $invitation->message }}</p>

                    <div class="text-xs text-gray-500 space-y-1 mb-3">
                        <p><span class="font-medium">Kontak:</span> {{ $invitation->contact_info }}</p>
                        @if($invitation->meeting_link)
                            <p><span class="font-medium">Link:</span>
                                <a href="{{ $invitation->meeting_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $invitation->meeting_link }}</a>
                            </p>
                        @endif
                        @if($invitation->location)
                            <p><span class="font-medium">Lokasi:</span> {{ $invitation->location }}</p>
                        @endif
                    </div>

                    @if($invitation->status === 'pending')
                        <div class="flex gap-2 mt-3">
                            <button wire:click="accept({{ $invitation->id }})"
                                    class="px-4 py-1.5 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition">
                                Terima
                            </button>
                            <button wire:click="decline({{ $invitation->id }})"
                                    class="px-4 py-1.5 bg-red-500 text-white rounded-lg text-xs font-bold hover:bg-red-600 transition">
                                Tolak
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-400 text-center py-4 text-sm">Belum ada undangan interview.</p>
    @endif
</div>
