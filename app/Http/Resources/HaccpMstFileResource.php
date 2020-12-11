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
            'rev_seq' => $this->REV_SEQ,
            'rev_no' => $this->REV_NO,
            'rev_dt' => now()->parse($this->REV_DT)->format('Y-m-d'),
            'att_dtm' => $this->ATT_DTM,
            'rev_content' => $this->REV_CONTENT,
            'rev_reason' => $this->REV_REASON,
            'reg_id' => $this->REG_ID,
            'reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),

            'att_file' => AttFileResource::collection($this->whenLoaded('att_file')),
        ];
    }
}
