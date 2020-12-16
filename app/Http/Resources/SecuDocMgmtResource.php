<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SecuDocMgmtResource extends JsonResource
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
            'secu_doc_mgmt:doc_id' => $this->DOC_ID,
            'secu_doc_mgmt:doc_nm' => $this->DOC_NM,
            'secu_doc_mgmt:doc_desc' => $this->DOC_DESC,
            'secu_doc_mgmt:doc_dt' => $this->DOC_DT,
            'secu_doc_mgmt:att_dtm' => $this->ATT_DTM,
            'secu_doc_mgmt:from_dt' => now()->parse($this->FROM_DT)->format('Y-m-d'),
            'secu_doc_mgmt:to_dt' => now()->parse($this->TO_DT)->format('Y-m-d'),
            'secu_doc_mgmt:reg_id' => $this->REG_ID,
            'secu_doc_mgmt:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
            'secu_doc_mgmt:att_file' => AttFileResource::collection($this->whenLoaded('att_file')),
        ];
    }
}
