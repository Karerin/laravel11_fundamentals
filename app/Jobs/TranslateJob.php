<?php

namespace App\Jobs;

use App\Models\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TranslateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Job $joblisting)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // logger('hello from TranslateJob');
        // AI::translate($this->joblistings->description,'spanish');
        logger('Translating' . $this->joblisting->title . ' to Spanish.');
    }
}
