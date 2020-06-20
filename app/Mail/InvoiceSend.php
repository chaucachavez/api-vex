<?php

namespace App\Mail;

use App\Models\venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSend extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;
    public $filePDF;
    public $fileXML;
    public $fileCDR;
    public $imgHeader;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($venta, $filePDF, $fileXML, $fileCDR = NULL)
    {
        $this->venta = $venta;
        $this->filePDF = $filePDF;
        $this->fileXML = $fileXML; 
        $this->fileCDR = $fileCDR; 
        //$this->imgHeader = "http://sistemas.centromedicoosi.com/img/osi/email/mailheadosi.png";
        $this->imgHeader = "http://sistemas.centromedicoosi.com/img/osi/email/mailheadunion.png";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        // https://stackoverflow.com/questions/36584879/optional-parameters-to-laravel-mail
        // return "No permite utilizar" el encadenamiento de métodos;
        $this->view('invoice.email')
                ->subject('[Profactura.pe] Envío de comprobante electrónico: ' .  $this->venta->serie . '-' . $this->venta->numero)
                ->attach($this->filePDF)
                ->attach($this->fileXML);

        if (!empty($this->fileCDR)) { 
            $this->attach($this->fileCDR);             
        } 

        // return $this->view('invoice.texto')
        //     ->subject('Mensaje de prueba');
    }
}
