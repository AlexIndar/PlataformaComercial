<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorNetsuite extends Mailable
{
    use Queueable, SerializesModels;


    public $data;
    public function __construct($data)
    {   
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('mailing@sndr.indar.com.mx', 'INDAR')
        ->replyTo('mailing@sndr.indar.com.mx', 'INDAR')
        ->subject('Pedidos con error Netsuite')
        ->view('mails.errorNetsuite');
    }
}
