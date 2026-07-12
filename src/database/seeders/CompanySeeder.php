<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $recruiter = User::where('email', 'recruiter@demo.com')->first();

        if ($recruiter) {
            Company::updateOrCreate(
                ['user_id' => $recruiter->id],
                [
                    'name' => 'TechHire Corp',
                    'address' => 'Jl. Teknologi No. 123, Jakarta',
                    'description' => 'TechHire Corp adalah perusahaan startup teknologi yang fokus pada pengembangan platform rekrutmen berbasis skill untuk industri IT.',
                    'website' => 'https://techhire.test',
                    'contact_email' => 'hr@techhire.test',
                    'contact_phone' => '021-12345678',
                ]
            );
        }
    }
}
