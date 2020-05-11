<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmMessageProjetPosted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Elements du projet
     * @var array
     */
    public $projet;
    public $author;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projet, $author)
    {
        $this->projet = $projet;
        $this->author = $author;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $author = $this->author;
         return $this->from('mickael@iziplans.com')
            ->subject("Nous avons reçu votre projet")
            ->view('emails.confirm-message-to-author');
    }
}
