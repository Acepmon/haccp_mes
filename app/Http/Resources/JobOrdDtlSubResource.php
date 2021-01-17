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
            'job_ord_dtl_sub:src_cd' => $this->SRC_CD,
            'job_ord_dtl_sub:src_cd_nm' => $this->whenLoaded('src', function () {
                return $this->src->COMM2_NM;
            }),
            'job_ord_dtl_sub:seq_no' => $this->SEQ_NO,
            'job_ord_dtl_sub:seq_nm' => $this->SEQ_NM,
            'job_ord_dtl_sub:proc_cd' => $this->PROC_CD,
            'job_ord_dtl_sub:proc_cd_nm' => $this->whenLoaded('proc', function () {
                return $this->proc->COMM2_NM;
            }),
            'job_ord_dtl_sub:proc_nm' => $this->PROC_NM,
            'job_ord_dtl_sub:proc_dtl' => $this->PROC_DTL,
            'job_ord_dtl_sub:chk1_dtm' => $this->CHK1_DTM,
            'job_ord_dtl_sub:chk_temp' => $this->CHK_TEMP,
            'job_ord_dtl_sub:chk2_time' => $this->CHK2_TIME,
            'job_ord_dtl_sub:chk2_temp' => $this->CHK2_TEMP,
            'job_ord_dtl_sub:ccp_cd' => $this->CCP_CD,
            'job_ord_dtl_sub:ccp_yn' => $this->CCP_YN,
            'job_ord_dtl_sub:remark' => $this->REMARK,
        ];
    }
}
