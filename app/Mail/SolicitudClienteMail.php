<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $folio;
    public $tipoSol;
    public $cliente;
    public $razonSocial;
    public $rfc;
    public $zona;
    public $status;
    public function __construct($folio, $tipoSol, $cliente, $razonSocial, $rfc, $zona, $status){
        $this->folio = $folio;
        $this->tipoSol = $tipoSol;
        $this->cliente = $cliente;
        $this->razonSocial = $razonSocial;
        $this->rfc = $rfc;
        $this->zona = $zona;
        $this->status = $status;
    }

    public function build()
    {
        return $this->from('mailing@sndr.indar.com.mx', 'INDARNET')
        ->replyTo('mailing@sndr.indar.com.mx', 'INDARNET')
        ->subject($this->status)
        ->view('mails.solicitudFolioMail');
    }
}
