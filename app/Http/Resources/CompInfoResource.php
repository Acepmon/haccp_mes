<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompInfoResource extends JsonResource
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
            'comp_id' => $this->COMP_ID,
            'comp_nm' => $this->COMP_NM,
            'ceo_nm' => $this->CEO_NM,
            'tel_no' => $this->TEL_NO,
            'fax_no' => $this->FAX_NO,
            'url' => $this->URL,
            'zip_cd' => $this->ZIP_CD,
            'addr1' => $this->ADDR1,
            'addr2' => $this->ADDR2,
            'haccp_id' => $this->HACCP_ID,
            'haccp_user' => $this->whenLoaded('haccp_user', function () {
                return new UserResource($this->haccp_user);
            }),
            'haccp_item' => $this->HACCP_ITEM,
            'reg_id' => $this->REG_ID,
            'reg_dtm' => $this->REG_DTM,
        ];
    }
}
