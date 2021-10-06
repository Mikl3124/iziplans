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
      dd($user);
      $this->user = $user;
      dd($user, $this->user);
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
          ->subject('Bienvenue sur iziplans')
          ->view('emails.new-subscription');

    }
}
