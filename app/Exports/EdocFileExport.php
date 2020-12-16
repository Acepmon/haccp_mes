<?php

namespace App\Exports;

use App\EdocFile;
use Maatwebsite\Excel\Concerns\FromCollection;

class EdocFileExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EdocFile::all();
    }
}
