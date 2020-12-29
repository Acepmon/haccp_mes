<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcDtlResource extends JsonResource
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
            'proc_dtl:item_id' => $this->ITEM_ID,
            'proc_dtl:seq_no' => $this->SEQ_NO,
            'proc_dtl:seq_nm' => $this->SEQ_NM,
            'proc_dtl:proc_cd' => $this->PROC_CD,
            'proc_dtl:proc_cd_nm' => $this->whenLoaded('proc', function () {
                return $this->proc->COMM2_NM;
            }),
            'proc_dtl:proc_nm' => $this->PROC_NM,
            'proc_dtl:proc_time' => $this->PROC_TIME,
            'proc_dtl:proc_dtl' => $this->PROC_DTL,
            'proc_dtl:reg_id' => $this->REG_ID,
            'proc_dtl:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
