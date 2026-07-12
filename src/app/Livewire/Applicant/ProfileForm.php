<?php

namespace App\Livewire\Applicant;

use App\Models\Skill;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ProfileForm extends Component
{
    use WithFileUploads;

    public string $name = '';

    public ?string $phone = null;

    public ?string $summary = null;

    public $cv;

    public $avatar;

    public ?string $github_url = null;

    public ?string $linkedin_url = null;

    public ?string $portfolio_url = null;

    public array $skill_ids = [];

    public bool $showSkillPicker = false;

    public function addSkill(int $skillId): void
    {
        if (!in_array((string) $skillId, $this->skill_ids, true)) {
            $this->skill_ids[] = (string) $skillId;
        }
    }

    public function removeSkill(int $skillId): void
    {
        $this->skill_ids = array_values(array_filter(
            $this->skill_ids,
            fn($id) => (int) $id !== $skillId
        ));
    }

    public function mount(): void
    {
        $user = Auth::user()->load('skills');

        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->summary = $user->summary;
        $this->github_url = $user->github_url;
        $this->linkedin_url = $user->linkedin_url;
        $this->portfolio_url = $user->portfolio_url;
        $this->skill_ids = $user->skills
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
    }

    public function save(): void
    {
        abort_unless(Auth::check() && Auth::user()->hasRole('pelamar'), 403);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'skill_ids' => ['array'],
            'skill_ids.*' => ['exists:skills,id'],
        ]);

        $user = Auth::user();

        $data = [
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
        ];

        if ($this->cv) {
            $data['cv_path'] = $this->cv->store('applications/cv', 'public');
        }

        if ($this->avatar) {
            $data['avatar_url'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($data);
        $user->skills()->sync($this->skill_ids);

        session()->flash('success', 'Profile berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.applicant.profile-form', [
            'skills' => Skill::query()
                ->orderBy('name')
                ->get(),
        ]);
    }
}
