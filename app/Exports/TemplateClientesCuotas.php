<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateClientesCuotas implements FromArray
{
    public function array(): array
    { 
        return [
            ['CompanyId', 'Cuota','P1', 'P2', 'P3']
        ];
    }
}
