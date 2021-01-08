<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobOrdDtlResource extends JsonResource
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
            'job_ord_dtl:job_no' => $this->JOB_NO,
            'job_ord_dtl:item_id' => $this->ITEM_ID,
            'job_ord_dtl:seq_no' => $this->SEQ_NO,
            'job_ord_dtl:seq_nm' => $this->SEQ_NM,
            'job_ord_dtl:proc_cd' => $this->PROC_CD,
            'job_ord_dtl:proc_nm' => $this->PROC_NM,
            'job_ord_dtl:proc_time' => $this->PROC_TIME,
            'job_ord_dtl:proc_dtl' => $this->PROC_DTL,
            'job_ord_dtl:srt_dtm' => $this->SRT_DTM,
            'job_ord_dtl:end_dtm' => $this->END_DTM,
            'job_ord_dtl:haccp_cd' => $this->HACCP_CD,
            'job_ord_dtl:haccp_yn' => $this->HACCP_YN,
            'job_ord_dtl:remark' => $this->REMARK,
            'job_ord_dtl:reg_id' => $this->REG_ID,
            'job_ord_dtl:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
