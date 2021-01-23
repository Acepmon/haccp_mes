<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppGetCcpRequestInfoResource extends JsonResource
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
            'time' => now()->parse($this->REG_DTM)->format('H:i'),
            'data' => $this->DATA,
            'idx' => $this->idx,
            'process_idx' => $this->processIdx,
        ];
    }
}
