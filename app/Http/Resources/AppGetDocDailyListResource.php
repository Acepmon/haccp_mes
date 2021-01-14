<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetDocDailyListResource extends JsonResource
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
            'subject' => $this->DOC_NM,
            'doc_approval_idx' => $this->APP_ID,
            'approval_state' => ''
        ];
    }
}
