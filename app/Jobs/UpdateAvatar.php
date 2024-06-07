<?php

namespace App\Jobs;

use App\Services\Avatar\GiphyDriver;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateAvatar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 5;
    public $tries = 5;
    public $backoff = [1, 2, 3, 4, 5];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle( GiphyDriver $avatarDriver ): void
    {
        Log::debug('Starting Refresh Avatar Job.');
        throw new Exception('Failed Test', 999);

        $avatarDriver->refreshAvatar();

        Log::debug('Refresh Avatar Job Completed.');

    }

    /**
     * The job failed to process.
     */
    public function failed(Throwable $th)
    {
        Log::error('Failed Refresh Avatar Job.');
        if ($th->getCode() == 999) {
            $this->release();
        } else {
          Log::error('This is a proper error.');
        }
    }    
}
