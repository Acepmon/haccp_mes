<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobOrdDtlWorkResource extends JsonResource
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
            'job_ord_dtl_work:job_no' => $this->JOB_NO,
            'job_ord_dtl_work:item_id' => $this->ITEM_ID,
            'job_ord_dtl_work:seq_no' => $this->SEQ_NO,
            'job_ord_dtl_work:emp_id' => $this->EMP_ID,
            'job_ord_dtl_work:remark' => $this->REMARK,
            'job_ord_dtl_work:reg_id' => $this->REG_ID,
            'job_ord_dtl_work:reg_dtm' => $this->REG_DTM,
        ];
    }
}
