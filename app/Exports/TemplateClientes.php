<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateClientes implements FromArray
{
    public function array(): array
    {
        return [
            ['CompanyId']
        ];
    }
}
