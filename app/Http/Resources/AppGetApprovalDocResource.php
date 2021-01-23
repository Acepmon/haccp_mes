<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetApprovalDocResource extends JsonResource
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
            'doc_idx' => $this->DOC_ID,
            'doc_html' => $this->DOC_HTML,
            'app_data' => json_decode($this->APP_DATA),
            'work_id' => $this->WORK_ID,
            'work_dtm' => $this->WORK_DTM,
            'haccp_seq' => $this->HACCP_SEQ,
        ];
    }
}
