<?php

namespace App\Jobs;

use App\Mail\Newprojet;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailMatchCompetenceToFreelance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $projet;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $projet)
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
        dd('hello coco');
        Mail::to($user->email)->queue(new Newprojet($projet, $user));
    }
}
