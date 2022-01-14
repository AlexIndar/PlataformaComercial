<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplatePedido implements FromArray
{
    public function array(): array
    {
        return [
            ['Codigos', 'Cantidad']
        ];
    }
}
