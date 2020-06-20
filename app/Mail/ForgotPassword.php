<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $imgHeader;
    public $tokene;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    { 
        $this->usuario = $user;
        $this->tokene = $token;
        \Log::info(print_r($this->tokene, true));
        $this->imgHeader = "https://www.ifact.pe/wp-content/uploads/2019/06/Logotipo.png";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgot')
            ->subject('[Profactura.pe] Restablecer contraseña, confirmar.');
    }
}
