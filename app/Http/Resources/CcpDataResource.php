<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CcpDataResource extends JsonResource
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
            'device_id' => $this->DEVICE,
            'data' => floatval($this->DATA),
            'min' => $this->when(!empty($this->MIN), function () {
                return floatval($this->MIN);
            }),
            'max' => $this->when(!empty($this->MAX), function () {
                return floatval($this->MAX);
            }),
            'avg' => $this->when(!empty($this->AVG), function () {
                return floatval($this->AVG);
            }),
            'reg_dtm' => $this->REG_DTM,
            'reg_dtm_parsed' => now()->parse($this->REG_DTM)->format('Y-m-d H:i:s'),
        ];
    }
}
