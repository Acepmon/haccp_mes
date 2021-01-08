<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobOrdDtlSubResource extends JsonResource
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
            'job_ord_dtl_sub:job_no' => $this->JOB_NO,
            'job_ord_dtl_sub:item_id' => $this->ITEM_ID,
            'job_ord_dtl_sub:seq_no' => $this->SEQ_NO,
            'job_ord_dtl_sub:sub_seq_no' => $this->SUB_SEQ_NO,
            'job_ord_dtl_sub:seq_nm' => $this->SEQ_NM,
            'job_ord_dtl_sub:proc_cd' => $this->PROC_CD,
            'job_ord_dtl_sub:proc_nm' => $this->PROC_NM,
            'job_ord_dtl_sub:proc_dtl' => $this->PROC_DTL,
            'job_ord_dtl_sub:remark' => $this->REMARK,
            'job_ord_dtl_sub:reg_id' => $this->REG_ID,
            'job_ord_dtl_sub:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
