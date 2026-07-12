<div>
    {{-- Filters --}}
    <div class="flex flex-wrap gap-4 mb-6">
        <select wire:model.live="selectedJobId"
                class="px-4 py-2 rounded-lg border border-gray-200 bg-white text-gray-700">
            <option value="">Semua Lowongan</option>
            @foreach($jobs as $job)
                <option value="{{ $job->id }}">{{ $job->title }} ({{ $job->applications_count }})</option>
            @endforeach
        </select>
    </div>

    @if ($selectedApplicationId && $this->selectedApplication)
        {{-- Detail Panel --}}
        @php $detail = $this->selectedApplication; @endphp
        <div class="bg-white border border-gray-100 rounded-xl p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $detail->user->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $detail->user->email }}</p>
                </div>
                <button wire:click="closeDetail" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Lowongan</p>
                    <p class="font-medium text-gray-900">{{ $detail->job->title }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Skill Match</p>
                    <p class="font-medium text-blue-600">{{ $detail->match_score }}%</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Expected Salary</p>
                    <p class="font-medium text-gray-900">
                        @if($detail->expected_salary)
                            Rp {{ number_format($detail->expected_salary, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Portfolio</p>
                    @if($detail->portfolio_url)
                        <a href="{{ $detail->portfolio_url }}" target="_blank" class="text-blue-600 hover:underline text-sm">{{ $detail->portfolio_url }}</a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </div>
            </div>

            @if($detail->cover_letter)
                <div class="mb-4">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Cover Letter</p>
                    <p class="text-gray-700 text-sm bg-gray-50 p-3 rounded-lg">{{ $detail->cover_letter }}</p>
                </div>
            @endif

            @if($detail->experience_summary)
                <div class="mb-4">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Pengalaman</p>
                    <p class="text-gray-700 text-sm bg-gray-50 p-3 rounded-lg">{{ $detail->experience_summary }}</p>
                </div>
            @endif

            <div class="flex gap-3 mt-4 pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-400 uppercase font-bold self-center mr-2">Ubah Status:</span>
                @foreach (['pending' => 'Pending', 'reviewed' => 'Reviewed', 'shortlisted' => 'Shortlisted', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $val => $label)
                    <button wire:click="updateStatus({{ $detail->id }}, '{{ $val }}')"
                            class="px-3 py-1.5 rounded text-xs font-bold transition
                                {{ $detail->status === $val
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <button wire:click="toggleInviteForm"
                        class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                    <i class="fas fa-paper-plane mr-2"></i>Undang Interview
                </button>

                @if($showInviteForm)
                    <div class="mt-4 bg-gray-50 rounded-lg p-4 space-y-3">
                        <h4 class="font-bold text-sm text-gray-900">Kirim Undangan Interview</h4>

                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1">Pesan *</label>
                            <textarea wire:model="invitationMessage" rows="3"
                                      class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Tulis pesan untuk kandidat..."></textarea>
                            @error('invitationMessage') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1">Kontak Rekruter *</label>
                            <input wire:model="contactInfo" type="text"
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="WA/Email/Telepon">
                            @error('contactInfo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1">Link Meeting (opsional)</label>
                            <input wire:model="meetingLink" type="url"
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="https://meet.google.com/...">
                            @error('meetingLink') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1">Lokasi (opsional)</label>
                            <input wire:model="location" type="text"
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Alamat pertemuan">
                            @error('location') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button wire:click="sendInvitation"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition">
                                Kirim Undangan
                            </button>
                            <button wire:click="toggleInviteForm"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-300 transition">
                                Batal
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white border border-gray-100 rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <th class="p-4 font-medium">Kandidat</th>
                    <th class="p-4 font-medium">Lowongan</th>
                    <th class="p-4 font-medium">Skill Match</th>
                    <th class="p-4 font-medium">Status</th>
                    <th class="p-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($applications as $app)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors
                        {{ $selectedApplicationId === $app->id ? 'bg-blue-50' : '' }}">
                        <td class="p-4 font-medium text-gray-900">{{ $app->user->name }}</td>
                        <td class="p-4 text-gray-500">{{ $app->job->title }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="bg-gray-200 w-20 h-1.5 rounded-full overflow-hidden">
                                    <div class="h-1.5 rounded-full
                                        {{ $app->match_score >= 70 ? 'bg-green-500' : ($app->match_score >= 40 ? 'bg-yellow-500' : 'bg-orange-400') }}"
                                        style="width: {{ $app->match_score }}%;"></div>
                                </div>
                                <span class="text-xs font-bold
                                    {{ $app->match_score >= 70 ? 'text-green-600' : ($app->match_score >= 40 ? 'text-yellow-600' : 'text-orange-500') }}">
                                    {{ $app->match_score }}%
                                </span>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-xs font-bold
                                {{ $app->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $app->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $app->status === 'reviewed' || $app->status === 'shortlisted' ? 'bg-blue-50 text-blue-700' : '' }}
                                {{ $app->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <button wire:click="selectApplication({{ $app->id }})"
                                    class="text-blue-600 hover:underline font-medium text-sm">
                                Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>

    @if($applications->isEmpty())
        <div class="text-center py-12 text-gray-500 bg-white border border-gray-100 rounded-lg mt-4">
            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
            <p>Belum ada pelamar.</p>
        </div>
    @endif
</div>
