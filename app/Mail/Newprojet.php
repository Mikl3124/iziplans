<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Newprojet extends Mailable
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
    public function __construct($projet, $user)
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
      $user = $this->user;
         return $this->from('mickael@iziplans.com', 'Mickael d\'iziplans')
            ->subject("Bonjour {$user->firstname}, un nouveau projet pour vous sur iziplans")
            ->view('emails.new-projet');

            
    }
}
