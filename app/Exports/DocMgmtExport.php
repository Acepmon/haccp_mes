<?php

namespace App\Exports;

use App\DocMgmt;
use Maatwebsite\Excel\Concerns\FromCollection;

class DocMgmtExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DocMgmt::all();
    }
}
