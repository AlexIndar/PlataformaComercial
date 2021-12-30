<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateCategories implements FromArray
{
    public function array(): array
    {
        return [
            ['Categoria']
        ];
    }
}
