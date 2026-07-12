<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP', 'type' => 'Backend'],
            ['name' => 'Laravel', 'type' => 'Backend'],
            ['name' => 'Livewire', 'type' => 'Frontend'],
            ['name' => 'JavaScript', 'type' => 'Frontend'],
            ['name' => 'Vue.js', 'type' => 'Frontend'],
            ['name' => 'React', 'type' => 'Frontend'],
            ['name' => 'MySQL', 'type' => 'Database'],
            ['name' => 'MariaDB', 'type' => 'Database'],
            ['name' => 'Docker', 'type' => 'DevOps'],
            ['name' => 'Git', 'type' => 'Tools'],
            ['name' => 'Figma', 'type' => 'Design'],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                ['type' => $skill['type']]
            );
        }
    }
}
