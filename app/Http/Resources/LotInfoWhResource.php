<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotInfoWhResource extends JsonResource
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
            'lot_info_wh:wh_nm' => $this->wh_nm,
            'lot_info_wh:item_id' => $this->item_id,
            'lot_info_wh:item_nm' => $this->item_nm,
            'lot_info_wh:acc_cd' => $this->acc_cd,
            'lot_info_wh:sub_tot' => number_format($this->sub_tot),
        ];
    }
}
