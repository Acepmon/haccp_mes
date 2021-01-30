<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetRawMaterialForwardResource extends JsonResource
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
            'item_nm' => $this->ITEM_NM,
            'ord_qty' => $this->ORD_QTY,
            'idx' => $this->JOB_NO,
        ];
    }
}
