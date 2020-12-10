<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
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
            'worker_id' => $this->WORKER_ID,
            'worker_nm' => $this->WORKER_NM,
            'tel_no' => $this->TEL_N0,
            'work_cd' => $this->WORK_CD,
            'health_chk_dt' => $this->HEALTH_CHK_DT,
            'role_cd' => $this->ROLE_CD,
            'remark' => $this->REMARK,
            'reg_id' => $this->REG_ID,
            'reg_dtm' => $this->REG_DTM,
        ];
    }
}