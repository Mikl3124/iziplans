<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\ConfirmMessageToAuthor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailConfirmMessageToAuthor implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $author;
  protected $projet;

  // The maximum attempts of this job

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($author, $projet)
  {
    $this->author = $author;
    $this->projet = $projet;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $author = $this->author;
    $projet = $this->projet;
    dd($author);
    Mail::to($author->email)->queue(new ConfirmMessageToAuthor($projet, $author));
  }
}
