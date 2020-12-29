<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcDtlSubResource extends JsonResource
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
            'proc_dtl_sub:item_id' => $this->ITEM_ID,
            'proc_dtl_sub:seq_no' => $this->SEQ_NO,
            'proc_dtl_sub:sub_seq_no' => $this->SUB_SEQ_NO,
            'proc_dtl_sub:seq_nm' => $this->SEQ_NM,
            'proc_dtl_sub:proc_cd' => $this->PROC_CD,
            'proc_dtl_sub:proc_cd_nm' => $this->whenLoaded('proc', function () {
                return $this->proc->COMM2_NM;
            }),
            'proc_dtl_sub:proc_nm' => $this->PROC_NM,
            'proc_dtl_sub:proc_dtl' => $this->PROC_DTL,
            'proc_dtl_sub:reg_id' => $this->REG_ID,
            'proc_dtl_sub:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
