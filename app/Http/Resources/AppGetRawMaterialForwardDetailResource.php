<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetRawMaterialForwardDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     'item_nm' => $this['item_nm'],
        //     'req' => $this['req'],
        // ];
        return parent::toArray($request);
    }
}
