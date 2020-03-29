<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projet)
    {
        $this->projet = $projet;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->from('mickael@iziplans.com')
            ->view('emails.new-projet');
    }
}
