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
            'rev_dt' => $this->REV_DT,
            'att_dtm' => $this->ATT_DTM,
            'rev_content' => $this->REV_CONTENT,
            'rev_reason' => $this->REV_REASON,
            'reg_id' => $this->REG_ID,
            'reg_dtm' => $this->REG_DTM,

            'att' => AttFileResource::collection($this->whenLoaded('att_file')),
        ];
    }
}
