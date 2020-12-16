<?php

namespace App\Exports;

use App\SecuDocMgmt;
use Maatwebsite\Excel\Concerns\FromCollection;

class SecuDocMgmtExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SecuDocMgmt::all();
    }
}
