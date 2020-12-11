<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'att_dtm' => $this->ATT_DTM,
            'att_seq' => $this->ATT_SEQ,
            'att_nm' => $this->ATT_NM,
            'att_path' => $this->ATT_PATH,
            'file_sz' => $this->FILE_SZ,
            'rmk' => $this->RMK,
        ];
    }
}
