<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobOrdBomResource extends JsonResource
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
            'job_ord_bom:job_no' => $this->JOB_NO,
            'job_ord_bom:item_id' => $this->ITEM_ID,
            'job_ord_bom:item2_id' => $this->ITEM2_ID,
            'job_ord_bom:item2_nm' => $this->ITEM2_NM,
            'job_ord_bom:prod_qty' => $this->PROD_QTY,
            'job_ord_bom:use_qty' => $this->USE_QTY,
        ];
    }
}
