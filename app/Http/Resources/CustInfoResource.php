<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustInfoResource extends JsonResource
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
            'cust_info:comp_id' => $this->COMP_ID,
            'cust_info:comp_nm' => $this->COMP_NM,
            'cust_info:ceo_nm' => $this->CEO_NM,
            'cust_info:mob_no' => $this->MOB_NO,
            'cust_info:cust_nm' => $this->CUST_NM,
            'cust_info:cust_no' => $this->CUST_NO,
            'cust_info:tel_no' => $this->TEL_NO,
            'cust_info:fax_no' => $this->FAX_NO,
            'cust_info:srh_no' => $this->SRH_INFO,
            'cust_info:email' => $this->EMAIL,
            'cust_info:grp_nm' => $this->GRP_NM,
            'cust_info:addr' => $this->ADDR,
            'cust_info:remark' => $this->REMARK,
            'cust_info:use_yn' => $this->USE_YN,
            //'cust_info:reg_id' => $this->REG_ID,
            //'cust_info:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
