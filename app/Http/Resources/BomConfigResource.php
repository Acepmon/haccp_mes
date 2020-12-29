<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BomConfigResource extends JsonResource
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
            'bom_config:item1_id' => $this->ITEM1_ID,
            'bom_config:item1_nm' => $this->item1->ITEM1_NM,
            'bom_config:item1_nm' => $this->whenLoaded('item1', function () {
                return $this->item1->ITEM_NM;
            }),
            'bom_config:item2_id' => $this->ITEM2_ID,
            'bom_config:item2_nm' => $this->whenLoaded('item2', function () {
                return $this->item2->ITEM_NM;
            }),
            'bom_config:bom_ver' => $this->BOM_VER,
            'bom_config:process_cd' => $this->whenLoaded('item1', function () {
                return $this->item1->process->COMM2_CD;
            }),
            'bom_config:process_nm' => $this->whenLoaded('item1', function () {
                return $this->item1->process->COMM2_NM;
            }),
            'bom_config:prod_qty' => $this->PROD_QTY,
            'bom_config:use_qty' => $this->USE_QTY,
            'bom_config:reg_id' => $this->REG_ID,
            'bom_config:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
