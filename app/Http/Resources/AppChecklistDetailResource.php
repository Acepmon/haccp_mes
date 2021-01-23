<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppChecklistDetailResource extends JsonResource
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
            'appdata' => json_decode($this->APP_DATA),
            'subject' => $this->DOC_NM,
            'reporter_qrcode_idx' => $this->WORK_ID,
            'work_dtm' => $this->WORK_DTM,
        ];
    }
}
