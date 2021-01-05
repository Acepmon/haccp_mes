<?php

namespace App\Exports;

use App\JobOrd;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobOrdExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JobOrd::all();
    }
}
