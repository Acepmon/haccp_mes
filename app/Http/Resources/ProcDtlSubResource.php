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
            'item_id' => $this->ITEM_ID,
            'seq_no' => $this->SEQ_NO,
            'sub_seq_no' => $this->SUB_SEQ_NO,
            'seq_nm' => $this->SEQ_NM,
            'proc_time' => $this->PROC_TIME,
            'proc_cd' => $this->PROC_CD,
            'proc_cd_nm' => $this->whenLoaded('proc', function () {
                return $this->proc->COMM2_NM;
            }),
            'src_cd' => $this->SRC_CD,
            'src_cd_nm' => $this->whenLoaded('src', function () {
                return $this->src->COMM2_NM;
            }),
            'proc_nm' => $this->PROC_NM,
            'proc_dtl' => $this->PROC_DTL,
            'ccp_yn' => $this->CCP_YN,
            'reg_id' => $this->REG_ID,
            'reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
