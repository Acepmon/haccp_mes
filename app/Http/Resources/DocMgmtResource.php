<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocMgmtResource extends JsonResource
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
            'doc_mgmt:doc_id' => $this->DOC_ID,
            'doc_mgmt:type_cd' => $this->TYPE_CD,
            'doc_mgmt:type_nm' => $this->whenLoaded('type', function () {
                return $this->type->COMM2_NM;
            }),
            'doc_mgmt:doc_nm' => $this->DOC_NM,
            'doc_mgmt:doc_desc' => $this->DOC_DESC,
            'doc_mgmt:att_dtm' => $this->ATT_DTM,
            'doc_mgmt:reg_id' => $this->REG_ID,
            'doc_mgmt:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),

            'doc_mgmt:att_file' => AttFileResource::collection($this->whenLoaded('att_file')),
        ];
    }
}
