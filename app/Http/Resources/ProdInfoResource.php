<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdInfoResource extends JsonResource
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
            'prod_info:acc_no' => $this->ACC_NO,
            'prod_info:item_id' => $this->ITEM_ID,
            'prod_info:item_nm' => $this->ITEM_NM,
            'prod_info:out_wh_nm' => $this->OUT_WH_NM,
            'prod_info:in_wh_nm' => $this->IN_WH_NM,
            'prod_info:spec' => $this->SPEC,
            'prod_info:qty' => $this->QTY,
            'prod_info:lot_no' => $this->LOT_NO,
            'prod_info:remark' => $this->REMARK,
        ];
    }
}
