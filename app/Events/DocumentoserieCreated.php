<?php

namespace App\Events;

use App\Models\Documentoserie;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DocumentoserieCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Documentoserie $documentoserie)
    {
        
        // $idempresa = Config::get('constants.empresas.osi');          
        // $idAuth = Config::get('constants.usuarios.andres');  
        // $documentoserie->idempresa = $idempresa;
        // $documentoserie->id_created_at = $idAuth;
        // $documentoserie->id_updated_at = $idAuth;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
