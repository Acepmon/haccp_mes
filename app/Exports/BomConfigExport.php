<?php

namespace App\Exports;

use App\BomConfig;
use Maatwebsite\Excel\Concerns\FromCollection;

class BomConfigExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BomConfig::all();
    }
}
