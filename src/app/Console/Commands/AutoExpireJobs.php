<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class AutoExpireJobs extends Command
{
    protected $signature = 'jobs:auto-expire';

    protected $description = 'Unpublish jobs that have passed their deadline';

    public function handle()
    {
        $count = Job::query()
            ->where('is_published', true)
            ->where('deadline_at', '<', now())
            ->update(['is_published' => false]);

        $this->info("{$count} expired jobs have been unpublished.");

        return Command::SUCCESS;
    }
}
