<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $imgHeader;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->usuario = $user;
        $this->imgHeader = "http://sistemas.centromedicoosi.com/img/osi/email/mailheadunion.png";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view('emails.welcome')->subject('[Profactura.pe] Por favor confirma tu correo electrónico');
    }
}
