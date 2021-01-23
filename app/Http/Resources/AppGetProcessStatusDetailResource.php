<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetProcessStatusDetailResource extends JsonResource
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
            'seq_no' => $this->SEQ_NO,
            'proc_nm' => $this->PROC_NM,
            'proc_dtl' => $this->PROC_DTL,
            'proc_time' => $this->PROC_TIME,
            'ccp_yn' => $this->CCP_YN,
            'emp_nm' => $this->EMP_NM,
        ];
    }
}
