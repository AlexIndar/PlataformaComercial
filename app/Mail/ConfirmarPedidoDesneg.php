<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmarPedidoDesneg extends Mailable
{
    use Queueable, SerializesModels;


    public $pedido;
    public $detallesPedido; 
    public $idCotizacion;
    public $cliente;
    public $comentarios;
    public $ordenCompra;
    public $sucursal;
    public $formaEnvio;
    public $fletera;
    public $asunto;
    public $autoriza;
    public $tipoDescuento;
    public $descuento;
    public $username;
    public $fecha;
    public function __construct($pedido, $detallesPedido, $idCotizacion, $cliente, $comentarios, $ordenCompra, $sucursal, $formaEnvio, $fletera, $asunto, $autoriza, $tipoDescuento, $descuento, $username, $fecha)
    {   
        $this->pedido = $pedido;
        $this->detallesPedido = $detallesPedido;
        $this->idCotizacion = $idCotizacion;
        $this->cliente = $cliente;
        $this->comentarios = $comentarios;
        $this->ordenCompra = $ordenCompra;
        $this->sucursal = $sucursal;
        $this->formaEnvio = $formaEnvio;
        $this->fletera = $fletera;
        $this->asunto = $asunto;
        $this->autoriza = $autoriza;
        $this->tipoDescuento = $tipoDescuento;
        $this->descuento = $descuento;
        $this->username = $username;
        $this->fecha = $fecha;
    }

    public function build()
    {
        return $this->from('mailing@sndr.indar.com.mx', 'INDAR')
        ->replyTo('mailing@sndr.indar.com.mx', 'INDAR')
        ->subject($this->asunto)
        ->view('mails.confirmaPedidoDesneg');
    }
}
