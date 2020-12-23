<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemMstResource extends JsonResource
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
            'item_mst:item_id' => $this->ITEM_ID,
            'item_mst:item_nm' => $this->ITEM_NM,
            'item_mst:spec' => $this->SPEC,
            'item_mst:unit' => $this->UNIT,
            'item_mst:qty1' => number_format($this->QTY1),
            'item_mst:qty2' => number_format($this->QTY2),
            'item_mst:conn_no' => number_format($this->CONN_NO),
            'item_mst:conn_qty' => number_format($this->CONN_QTY),
            'item_mst:in_atm' => number_format($this->IN_AMT),
            'item_mst:out_amt' => number_format($this->OUT_AMT),
            'item_mst:item_cd' => $this->ITEM_CD,
            'item_mst:item_nm' => $this->whenLoaded('item', function () {
                return $this->item->COMM2_NM;
            }),
            'item_mst:grp1_cd' => $this->GRP1_CD,
            'item_mst:grp1_cd' => $this->whenLoaded('grp1', function () {
                return $this->item->COMM2_NM;
            }),
            'item_mst:grp2_cd' => $this->GRP2_CD,
            'item_mst:grp2_cd' => $this->whenLoaded('grp2', function () {
                return $this->item->COMM2_NM;
            }),
            'item_mst:grp3_cd' => $this->GRP3_CD,
            'item_mst:grp3_cd' => $this->whenLoaded('grp3', function () {
                return $this->item->COMM2_NM;
            }),
            'item_mst:use_yn' => $this->USE_YN == 'Y' ? 'YES' : 'NO',
            'item_mst:process_cd' => $this->PROCESS_CD,
            'item_mst:process_cd' => $this->whenLoaded('process', function () {
                return $this->item->COMM2_NM;
            }),
            'item_mst:unit1_nm' => $this->UNIT1_NM,
            'item_mst:unit1_qty' => $this->UNIT1_QTY,
            'item_mst:unit2_nm' => $this->UNIT2_NM,
            'item_mst:unit2_qty' => $this->UNIT2_QTY,
            'item_mst:unit3_nm' => $this->UNIT3_NM,
            'item_mst:unit3_qty' => $this->UNIT3_QTY,
            'item_mst:reg_id' => $this->REG_ID,
            'item_mst:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
