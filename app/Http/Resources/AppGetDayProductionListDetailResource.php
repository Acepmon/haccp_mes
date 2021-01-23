<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetDayProductionListDetailResource extends JsonResource
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
            'proc_nm' => $this->PROC_NM . '[' . $this->PROC_TIME . '분]',
            'emp_nm' => $this->EMP_NM,
            'idx' => $this->JOB_NO,
        ];
    }
}
