<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\NewprojetDepartement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
