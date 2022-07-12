<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AutorizacionGastoFletera extends Mailable
{
    use Queueable, SerializesModels;


    public $detalles;
    public function __construct($detalles)
    {   
        $this->detalles = $detalles;
    }

    public function build()
    {
        return $this->from('mailing@sndr.indar.com.mx', 'INDAR')
        ->replyTo('mailing@sndr.indar.com.mx', 'INDAR')
        ->subject('Autorización Folio')
        ->cc('jose.perez@indar.com.mx','azuniga@indar.com.mx')
        ->view('mails.autorizarFolio');
    }
}
