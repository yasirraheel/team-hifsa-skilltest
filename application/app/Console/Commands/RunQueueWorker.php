<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunQueueWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:run-worker {--max-jobs=10} {--sleep=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run queue worker in a loop suitable for shared hosting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $maxJobs = (int) $this->option('max-jobs');
        $sleep = (int) $this->option('sleep');

        $this->info("Starting queue worker. Will process up to {$maxJobs} jobs, then sleep for {$sleep} seconds.");
        $this->info("Press Ctrl+C to stop.");

        $processed = 0;

        while ($processed < $maxJobs) {
            $this->comment("Processing queue...");

            // Run one queue job
            $exitCode = Artisan::call('queue:work', [
                '--once' => true,
                '--tries' => 3,
                '--timeout' => 3600,
                '--max-jobs' => 1,
                '--stop-when-empty' => true,
            ]);

            if ($exitCode === 0) {
                $processed++;
                $this->info("Processed job #{$processed}");
            } else {
                $this->warn("No jobs available or error occurred (exit code: {$exitCode})");
                break;
            }

            // Sleep between jobs to prevent overwhelming the server
            if ($processed < $maxJobs) {
                $this->comment("Sleeping for {$sleep} seconds...");
                sleep($sleep);
            }
        }

        $this->info("Queue worker finished. Processed {$processed} jobs.");
        return 0;
    }
}
