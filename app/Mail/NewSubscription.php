<?php

namespace App\Mail;

use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Laravel\Socialite\Facades\Socialite;

class NewSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
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
      return $this->from('mickael@iziplans.com', 'Mickael d\'iziplans')
          ->subject('Bienvenue sur iziplans')
          ->view('emails.new-subscription');

    }
}
