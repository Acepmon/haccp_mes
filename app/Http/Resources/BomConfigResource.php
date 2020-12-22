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
            'bom_config:item1_cd' => $this->ITEM1_ID,
            'bom_config:item2_cd' => $this->ITEM2_ID,
            'bom_config:bom_ver' => $this->BOM_VER,
            'bom_config:prod_qty' => $this->PROD_QTY,
            'bom_config:use_qty' => $this->USE_QTY,
            'bom_config:reg_id' => $this->REG_ID,
            'bom_config:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
