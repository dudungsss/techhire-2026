<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $pelamar = User::where('email', 'pelamar@demo.com')->first();
        $jobs = Job::all();

        if (! $pelamar || $jobs->isEmpty()) {
            return;
        }

        // Give the pelamar some skills first
        $skillIds = \App\Models\Skill::whereIn('name', ['PHP', 'Laravel', 'Livewire', 'JavaScript', 'Git'])
            ->pluck('id')
            ->toArray();

        $pelamar->skills()->syncWithoutDetaching($skillIds);

        // Create applications for each job
        foreach ($jobs as $index => $job) {
            $pelamarSkillIds = $pelamar->skills()->pluck('skills.id')->toArray();
            $jobSkillIds = $job->skills()->pluck('skills.id')->toArray();

            $matchScore = 0;
            if (! empty($jobSkillIds)) {
                $matching = array_intersect($jobSkillIds, $pelamarSkillIds);
                $matchScore = (int) round((count($matching) / count($jobSkillIds)) * 100);
            }

            $statuses = ['pending', 'reviewed', 'shortlisted', 'accepted', 'rejected'];

            JobApplication::updateOrCreate(
                [
                    'job_id' => $job->id,
                    'user_id' => $pelamar->id,
                ],
                [
                    'cover_letter' => 'Saya tertarik dengan lowongan ' . $job->title . ' dan percaya skill yang saya miliki sesuai dengan kebutuhan perusahaan.',
                    'experience_summary' => 'Saya memiliki pengalaman mengembangkan aplikasi menggunakan Laravel, Livewire, dan berbagai teknologi pendukung.',
                    'portfolio_url' => 'https://github.com/pelamar-demo',
                    'expected_salary' => $job->salary_min ? $job->salary_min + 1000000 : 5000000,
                    'match_score' => $matchScore,
                    'status' => $statuses[$index % count($statuses)],
                ]
            );
        }
    }
}
