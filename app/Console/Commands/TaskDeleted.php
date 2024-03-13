<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Models\Task;

class TaskDeleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanent Deleted after 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Task::whereNotNull('deleted_at')
            ->where('deleted_at', '<=', Carbon::now()->days(30))
            ->forceDelete();
    }
}
