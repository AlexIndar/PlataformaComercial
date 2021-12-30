<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateGiros implements FromArray
{
    public function array(): array
    {
        return [
            ['Giro']
        ];
    }
}
