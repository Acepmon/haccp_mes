<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HaccpMstFileResource extends JsonResource
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
            'haccp_mst_file:rev_seq' => $this->REV_SEQ,
            'haccp_mst_file:rev_no' => $this->REV_NO,
            'haccp_mst_file:rev_dt' => now()->parse($this->REV_DT)->format('Y-m-d'),
            'haccp_mst_file:att_dtm' => $this->ATT_DTM,
            'haccp_mst_file:rev_content' => $this->REV_CONTENT,
            'haccp_mst_file:rev_reason' => $this->REV_REASON,
            'haccp_mst_file:reg_id' => $this->REG_ID,
            'haccp_mst_file:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),

            'haccp_mst_file:att_file' => AttFileResource::collection($this->whenLoaded('att_file')),
        ];
    }
}
