<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetDocListDetailResource extends JsonResource
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
            'work_dtm' => now()->parse($this->WORK_DTM)->format('Y.m.d'),
            'subject' => $this->DOC_NM,
            'status' => $this->apr->COMM2_NM,
            'haccp_seq' => $this->HACCP_SEQ,
        ];
    }
}
