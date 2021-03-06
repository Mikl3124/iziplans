<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewProjetPostedForAdmin extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Elements du projet
   * @var array
   */
  public $projet;
  public $user;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user, $projet)
  {
    $this->projet = $projet;
    $this->user = $user;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $this->user;
    $this->projet;
    return $this->from('mickael@iziplans.com', 'Mickael d\'iziplans')
      ->subject("Nouveau projet sur iziplans")
      ->view('emails.new-projet-admin');
  }
}
