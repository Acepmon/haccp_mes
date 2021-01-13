<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotInfoResource extends JsonResource
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
            'lot_info:dt_no' => $this->DT_NO,
            'lot_info:item_id' => $this->ITEM_ID,
            'lot_info:item_nm' => $this->ITEM_NM,
            'lot_info:spec' => $this->SPEC,
            'lot_info:unit' => $this->UNIT,
            'lot_info:origin' => $this->ORIGIN,
            'lot_info:lot_no' => $this->LOT_NO,
            'lot_info:qty' => $this->QTY,
            'lot_info:acc_cd' => $this->ACC_CD,
            'lot_info:in_cost' => $this->IN_COST,
            'lot_info:out_cost' => $this->OUT_COST,
            'lot_info:comp_id' => $this->COMP_ID,
            'lot_info:comp_nm' => $this->COMP_NM,
            'lot_info:wh_cd' => $this->WH_CD,
            'lot_info:wh_nm' => $this->WH_NM,
            'lot_info:in_wh_cd' => $this->IN_WH_CD,
            'lot_info:in_wh_nm' => $this->IN_WH_NM,
            'lot_info:proc_cd' => $this->PROC_CD,
            'lot_info:proc_nm' => $this->PROC_NM,
            'lot_info:item_dvn' => $this->ITEM_DVN,
            'lot_info:barcode' => $this->BARCODE,
            'lot_info:work_id' => $this->WORK_ID,
            'lot_info:work_nm' => $this->WORK_NM,
            'lot_info:remark' => $this->REMARK,
            'lot_info:safe_qty' => $this->SAFE_QTY,
            'lot_info:acc_no' => $this->ACC_NO,
        ];
    }
}
