<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateArticulos implements FromArray
{
    public function array(): array
    {
        return [
            ['Codigo']
        ];
    }
}
