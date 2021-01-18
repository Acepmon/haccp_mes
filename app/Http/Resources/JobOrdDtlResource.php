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
            'job_ord_dtl:proc_cd_nm' => $this->whenLoaded('proc', function () {
                return $this->proc->COMM2_NM;
            }),
            'job_ord_dtl:proc_nm' => $this->PROC_NM,
            'job_ord_dtl:proc_time' => $this->PROC_TIME,
            'job_ord_dtl:proc_dtl' => $this->PROC_DTL,
            'job_ord_dtl:srt_dtm' => $this->SRT_DTM,
            'job_ord_dtl:end_dtm' => $this->END_DTM,
            'job_ord_dtl:chk1_dtm' => $this->CHK1_DTM,
            'job_ord_dtl:chk_temp' => $this->CHK_TEMP,
            'job_ord_dtl:chk2_time' => $this->CHK2_TIME,
            'job_ord_dtl:chk2_temp' => $this->CHK2_TEMP,
            'job_ord_dtl:src_cd' => $this->SRC_CD,
            'job_ord_dtl:ccp_cd' => $this->CCP_CD,
            'job_ord_dtl:ccp_yn' => $this->CCP_YN,
            'job_ord_dtl:remark' => $this->REMARK,
        ];
    }
}
