<?php

namespace App\Imports;

use App\ItemMst;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemMstImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ItemMst([
            //
        ]);
    }
}
