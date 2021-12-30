<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateMarcas implements FromArray
{
    public function array(): array
    {
        return [
            ['Marca']
        ];
    }
}
