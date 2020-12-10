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
            'tel_no' => $this->TEL_NO,
            'work_cd' => $this->WORK_CD,
            'health_chk_dt' => now()->parse($this->HEALTH_CHK_DT)->format('Y-m-d'),
            'role_cd' => $this->ROLE_CD,
            'remark' => $this->REMARK,
            'reg_id' => $this->REG_ID,
            'reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
