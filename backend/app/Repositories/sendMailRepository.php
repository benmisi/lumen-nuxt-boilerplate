<?php
namespace App\Repositories;

use App\Mail\activateMail;
use App\Mail\passwordresetMail;
use Illuminate\Support\Facades\Mail;
class sendMailRepository{
  
    public function sendActivationMail($user,$name,$token){
      Mail::to($user)
          ->queue(new activateMail($name,$token));
    }

    public function sendPasswordResetMail($user,$token){
        Mail::to($user)
        ->queue(new passwordresetMail($token));
    }
}