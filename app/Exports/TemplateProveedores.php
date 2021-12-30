<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateProveedores implements FromArray
{
    public function array(): array
    {
        return [
            ['Proveedor']
        ];
    }
}
