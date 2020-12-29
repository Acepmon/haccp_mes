<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcSrcResource extends JsonResource
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
            'proc_src:item_id' => $this->ITEM_ID,
            'proc_src:seq_no' => $this->SEQ_NO,
            'proc_src:src_nm' => $this->SRC_NM,
            'proc_src:reg_id' => $this->REG_ID,
            'proc_src:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
