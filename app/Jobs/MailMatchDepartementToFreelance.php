<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailMatchDepartementToFreelance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $projet;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = $user;
        $this->projet = $projet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $user = $this->user;
      $projet = $this->projet;
      Mail::to($user->email)->queue(new NewprojetDepartement($projet, $user));
    }
}
