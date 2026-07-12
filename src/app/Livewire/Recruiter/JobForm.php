<?php

namespace App\Livewire\Recruiter;

use App\Models\Category;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class JobForm extends Component
{
    public ?Job $job = null;

    public ?int $category_id = null;

    public string $title = '';

    public ?string $description = null;

    public ?string $requirements = null;

    public ?string $responsibilities = null;

    public ?string $salary_min = null;

    public ?string $salary_max = null;

    public ?string $location = null;

    public string $employment_type = 'full_time';

    public string $experience_level = 'junior';

    public ?string $deadline_at = null;

    public bool $is_published = false;

    public array $skill_ids = [];

    public function mount(?Job $job = null): void
    {
        abort_unless(Auth::check() && Auth::user()->hasRole('recruiter'), 403);

        if ($job && $job->exists) {
            abort_unless($job->company->user_id === Auth::id(), 403);

            $this->job = $job->load('skills');

            $this->category_id = $this->job->category_id;
            $this->title = $this->job->title;
            $this->description = $this->job->description;
            $this->requirements = $this->job->requirements;
            $this->responsibilities = $this->job->responsibilities;
            $this->salary_min = $this->job->salary_min;
            $this->salary_max = $this->job->salary_max;
            $this->location = $this->job->location;
            $this->employment_type = $this->job->employment_type;
            $this->experience_level = $this->job->experience_level;
            $this->deadline_at = $this->job->deadline_at?->format('Y-m-d');
            $this->is_published = $this->job->is_published;
            $this->skill_ids = $this->job->skills()
                ->pluck('skills.id')
                ->map(fn ($id) => (string) $id)
                ->toArray();
        }
    }

    public function save(): void
    {
        abort_unless(Auth::check() && Auth::user()->hasRole('recruiter'), 403); 

        $company = Auth::user()->company;

        if (! $company) {
            session()->flash('error', 'Isi company profile dulu sebelum membuat lowongan.');
            return;
        }

        $validated = $this->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,internship,freelance'],
            'experience_level' => ['required', 'in:fresh_graduate,junior,mid,senior'],
            'deadline_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
            'skill_ids' => ['array'],
            'skill_ids.*' => ['exists:skills,id'],
        ]);

        if (
            filled($validated['salary_min'] ?? null)
            && filled($validated['salary_max'] ?? null)
            && (float) $validated['salary_min'] > (float) $validated['salary_max']
        ) {
            $this->addError('salary_max', 'Salary max harus lebih besar dari salary min.');
            return;
        }

        $slug = $this->generateUniqueSlug($validated['title']);

        $job = Job::updateOrCreate(
            ['id' => $this->job?->id],
            [
                'company_id' => $company->id,
                'category_id' => $validated['category_id'] ?? null,
                'title' => $validated['title'],
                'slug' => $slug,
                'description' => $validated['description'] ?? null,
                'requirements' => $validated['requirements'] ?? null,
                'responsibilities' => $validated['responsibilities'] ?? null,
                'salary_min' => $validated['salary_min'] ?? null,
                'salary_max' => $validated['salary_max'] ?? null,
                'location' => $validated['location'] ?? null,
                'employment_type' => $validated['employment_type'],
                'experience_level' => $validated['experience_level'],
                'deadline_at' => $validated['deadline_at'] ?? null,
                'is_published' => (bool) ($validated['is_published'] ?? false),
            ]
        );

        $job->skills()->sync($this->skill_ids);

        session()->flash('success', 'Lowongan berhasil disimpan.');

        $this->redirectRoute('recruiter.jobs.index', navigate: true);
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Job::query()
                ->where('slug', $slug)
                ->when($this->job, function ($query) {
                    $query->where('id', '!=', $this->job->id);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.recruiter.job-form', [
            'categories' => Category::query()
                ->orderBy('name')
                ->get(),

            'skills' => Skill::query()
                ->orderBy('name')
                ->get(),
        ]);
    }
}