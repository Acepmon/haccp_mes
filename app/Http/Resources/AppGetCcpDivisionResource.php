<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetCcpDivisionResource extends JsonResource
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
            'ccp_cd' => $this->CCP_CD,
            'ccp_nm' => $this->CCP_NM,
        ];
    }
}
