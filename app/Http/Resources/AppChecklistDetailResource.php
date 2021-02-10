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
            'appdata' => [
                'view' => json_decode($this->APP_VIEW),
                'input' => json_decode($this->APP_INPUT),
                'list' => json_decode($this->APP_LIST),
            ],
            'subject' => $this->DOC_NM,
            'reporter_qrcode_idx' => $this->WORK_ID,
        ];
    }
}
