<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmarPedido extends Mailable
{
    use Queueable, SerializesModels;


    public $pedido;
    public $detallesPedido;
    public $idCotizacion;
    public function __construct($pedido, $detallesPedido, $idCotizacion)
    {   
        $this->pedido = $pedido;
        $this->detallesPedido = $detallesPedido;
        $this->idCotizacion = $idCotizacion;
    }

    public function build()
    {
        return $this->from('mailing@sndr.indar.com.mx', 'INDAR')
        ->replyTo('mailing@sndr.indar.com.mx', 'INDAR')
        ->subject('Nueva Cotización INDAR')
        ->view('mails.confirmaPedido');
    }
}
