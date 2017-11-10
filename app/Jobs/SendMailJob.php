<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;

use App\Jedi;
use App\Notifications\LightsaberUpdated;
use Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
   
    
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $jedis = Jedi::all();

        foreach ($jedis as $jedi) {
            $jedi->notify(new LightsaberUpdated($jedi));
        }
    
    }
}
