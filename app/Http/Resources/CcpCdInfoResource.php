<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CcpCdInfoResource extends JsonResource
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
            'ccp_cd_info:ccp_cd' => $this->CCP_CD,
            'ccp_cd_info:ccp_nm' => $this->CCP_NM,
            'ccp_cd_info:temp_fr' => $this->TEMP_FR,
            'ccp_cd_info:temp_to' => $this->TEMP_TO,
            'ccp_cd_info:boil_fr' => $this->BOIL_FR,
            'ccp_cd_info:boil_to' => $this->BOIL_TO,
            'ccp_cd_info:chk_temp' => $this->CHK_TEMP,
            'ccp_cd_info:remark' => $this->REMARK,
            'ccp_cd_info:reg_id' => $this->REG_ID,
            'ccp_cd_info:reg_dtm' => $this->REG_DTM,
        ];
    }
}
