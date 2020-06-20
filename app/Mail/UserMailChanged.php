<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMailChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        return $this->usuario = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.confirm')
            ->subject('[Profactura.pe] Por favor confirma tu nuevo correo');
    }
}
