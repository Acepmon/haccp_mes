<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobOrdResource extends JsonResource
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
            'job_ord:job_ord' => $this->JOB_DT . '-' . $this->SEQ_NO,
            'job_ord:job_dt' => $this->JOB_DT,
            'job_ord:job_dt_parsed' => now()->parse($this->JOB_DT)->format('Y-m-d'),
            'job_ord:seq_no' => $this->SEQ_NO,
            'job_ord:item_id' => $this->ITEM_ID,
            'job_ord:item_nm' => $this->whenLoaded('item', function () {
                return $this->item->ITEM_NM;
            }),
            'job_ord:ord_qty' => number_format($this->ORD_QTY),
            'job_ord:prod_qty' => $this->PROD_QTY,
            'job_ord:ord_nm' => $this->ORD_NM,
            'job_ord:bom_ver' => $this->BOM_VER,
            'job_ord:fact_cd' => $this->FACT_CD,
            'job_ord:remark' => $this->REMARK,
            'job_ord:reg_id' => $this->REG_ID,
            'job_ord:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
