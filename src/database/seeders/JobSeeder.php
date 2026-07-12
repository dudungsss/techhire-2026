<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();

        if (! $company) {
            return;
        }

        $categories = Category::all()->keyBy('name');
        $skills = Skill::all()->keyBy('name');

        $jobs = [
            [
                'title' => 'Laravel Developer',
                'category' => 'Web Development',
                'description' => 'Kami mencari Laravel Developer berpengalaman untuk mengembangkan dan memelihara aplikasi web berbasis Laravel.',
                'requirements' => "- Minimal 2 tahun pengalaman dengan Laravel\n- Memahami MVC, Eloquent, Blade\n- Pengalaman dengan REST API\n- Menguasai Git & Docker",
                'responsibilities' => "- Mengembangkan fitur baru menggunakan Laravel & Livewire\n- Menulis kode yang bersih dan terstruktur\n- Melakukan code review\n- Berkolaborasi dengan tim frontend",
                'salary_min' => 8000000,
                'salary_max' => 15000000,
                'location' => 'Jakarta',
                'employment_type' => 'full_time',
                'experience_level' => 'mid',
                'skills' => ['PHP', 'Laravel', 'Livewire', 'MySQL', 'Git', 'Docker'],
            ],
            [
                'title' => 'React Native Developer',
                'category' => 'Mobile Development',
                'description' => 'Kesempatan untuk bergabung sebagai React Native Developer dan membangun aplikasi mobile yang scalable.',
                'requirements' => "- Pengalaman React Native minimal 1 tahun\n- Memahami JavaScript/TypeScript\n- Pengalaman dengan REST API integration\n- Familiar dengan Git",
                'responsibilities' => "- Mengembangkan fitur mobile app\n- Optimasi performa aplikasi\n- Kolaborasi dengan tim backend\n- Testing dan debugging",
                'salary_min' => 7000000,
                'salary_max' => 12000000,
                'location' => 'Bandung',
                'employment_type' => 'full_time',
                'experience_level' => 'mid',
                'skills' => ['JavaScript', 'React', 'Git'],
            ],
            [
                'title' => 'UI/UX Designer Intern',
                'category' => 'UI/UX Design',
                'description' => 'Program magang untuk UI/UX Designer yang ingin belajar dan berkembang di industri teknologi.',
                'requirements' => "- Mahasiswa aktif atau fresh graduate\n- Menguasai Figma\n- Memahami design system\n- Memiliki portfolio",
                'responsibilities' => "- Membuat wireframe dan prototype\n- Melakukan user research\n- Berkolaborasi dengan developer\n- Menjaga konsistensi design system",
                'salary_min' => 1500000,
                'salary_max' => 3000000,
                'location' => 'Jakarta',
                'employment_type' => 'internship',
                'experience_level' => 'fresh_graduate',
                'skills' => ['Figma', 'JavaScript'],
            ],
            [
                'title' => 'DevOps Engineer',
                'category' => 'DevOps',
                'description' => 'Bergabunglah sebagai DevOps Engineer untuk membangun dan mengelola infrastruktur cloud.',
                'requirements' => "- Pengalaman dengan Docker & container orchestration\n- Familiar dengan CI/CD\n- Pengalaman cloud (AWS/GCP)\n- Memahami Linux administration",
                'responsibilities' => "- Mengelola infrastruktur cloud\n- Membangun pipeline CI/CD\n- Monitoring dan logging\n- Automation dan scripting",
                'salary_min' => 12000000,
                'salary_max' => 20000000,
                'location' => 'Remote',
                'employment_type' => 'full_time',
                'experience_level' => 'senior',
                'skills' => ['Docker', 'Git', 'MariaDB'],
            ],
            [
                'title' => 'Junior QA Tester',
                'category' => 'Quality Assurance',
                'description' => 'Kesempatan untuk memulai karir sebagai Quality Assurance di perusahaan teknologi.',
                'requirements' => "- Fresh graduate atau pengalaman maksimal 1 tahun\n- Teliti dan detail-oriented\n- Memahami basic testing concepts\n- Bisa menulis test case",
                'responsibilities' => "- Melakukan manual testing\n- Menulis test case dan test scenario\n- Melaporkan bug\n- Regression testing",
                'salary_min' => 4000000,
                'salary_max' => 7000000,
                'location' => 'Jakarta',
                'employment_type' => 'full_time',
                'experience_level' => 'junior',
                'skills' => ['JavaScript', 'Git'],
            ],
        ];

        foreach ($jobs as $jobData) {
            $category = $categories->get($jobData['category']);
            $jobSkills = $jobData['skills'];
            unset($jobData['category'], $jobData['skills']);

            $jobData['company_id'] = $company->id;
            $jobData['category_id'] = $category?->id;
            $jobData['slug'] = Str::slug($jobData['title']);
            $jobData['is_published'] = true;
            $jobData['deadline_at'] = now()->addDays(30);

            $job = Job::updateOrCreate(
                ['slug' => $jobData['slug']],
                $jobData
            );

            $skillIds = [];
            foreach ($jobSkills as $skillName) {
                $skill = $skills->get($skillName);
                if ($skill) {
                    $skillIds[] = $skill->id;
                }
            }

            if (! empty($skillIds)) {
                $job->skills()->syncWithoutDetaching($skillIds);
            }
        }
    }
}
