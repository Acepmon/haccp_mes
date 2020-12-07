<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommCdResource extends JsonResource
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
            'comm1_cd' => $this->COMM1_CD,
            'comm2_cd' => $this->COMM2_CD,
            'comm2_nm' => $this->COMM2_NM,
        ];
    }
}
