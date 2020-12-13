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
            'comp_info:comp_id' => $this->COMP_ID,
            'comp_info:comp_nm' => $this->COMP_NM,
            'comp_info:ceo_nm' => $this->CEO_NM,
            'comp_info:tel_no' => $this->TEL_NO,
            'comp_info:fax_no' => $this->FAX_NO,
            'comp_info:url' => $this->URL,
            'comp_info:zip_cd' => $this->ZIP_CD,
            'comp_info:addr1' => $this->ADDR1,
            'comp_info:addr2' => $this->ADDR2,
            'comp_info:haccp_id' => $this->HACCP_ID,
            'comp_info:haccp_user' => $this->whenLoaded('haccp_user', new UserResource($this->haccp_user)),
            'comp_info:haccp_item' => $this->HACCP_ITEM,
            'comp_info:reg_id' => $this->REG_ID,
            'comp_info:reg_dtm' => $this->REG_DTM,
        ];
    }
}
