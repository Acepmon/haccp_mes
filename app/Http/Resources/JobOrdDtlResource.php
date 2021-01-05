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
            'job_ord_dtl:job_dt' => $this->JOB_DT,
            'job_ord_dtl:seq_no' => $this->SEQ_NO,
            'job_ord_dtl:item_id' => $this->ITEM_ID,
            'job_ord_dtl:proc_seq_no' => $this->PROC_SEQ_NO,
            'job_ord_dtl:srt_dtm' => $this->SRT_DTM,
            'job_ord_dtl:end_dtm' => $this->END_DTM,
            'job_ord_dtl:haccp_cd' => $this->HACCP_CD,
            'job_ord_dtl:haccp_yn' => $this->HACCP_YN,
            'job_ord_dtl:remark' => $this->REMARK,
            'job_ord_dtl:reg_id' => $this->REG_ID,
            'job_ord_dtl:reg_dtm' => $this->REG_DTM,
        ];
    }
}
