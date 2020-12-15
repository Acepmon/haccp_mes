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
            'worker:worker_id' => $this->WORKER_ID,
            'worker:worker_nm' => $this->WORKER_NM,
            'worker:tel_no' => $this->TEL_NO,
            'worker:work_cd' => $this->WORK_CD,
            'worker:work_nm' => $this->whenLoaded('work', function () {
                return $this->work->COMM2_NM;
            }),
            'worker:health_chk_dt' => now()->parse($this->HEALTH_CHK_DT)->format('Y-m-d'),
            'worker:role_cd' => $this->ROLE_CD,
            'worker:role_nm' => $this->whenLoaded('role', function () {
                return $this->role->COMM2_NM;
            }),
            'worker:remark' => $this->REMARK,
            'worker:reg_id' => $this->REG_ID,
            'worker:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
