<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class activateMail extends Mailable{

    use Queueable,SerializesModels;

    public $name;
    public $token;
    public function __construct($name,$token)
    {
        $this->name = $name;
        $this->token = $token;        
    }

    public function build()
    {
        
        return $this->view('mail.activation');
    }
}
