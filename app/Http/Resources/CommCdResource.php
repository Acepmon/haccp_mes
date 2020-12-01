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
            'comm1_cd' => $this->comm1_cd,
            'comm2_cd' => $this->comm2_cd,
            'comm2_nm' => $this->comm2_nm,
        ];
    }
}
