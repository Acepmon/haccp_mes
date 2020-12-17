<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EdocFileResource extends JsonResource
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
            'edoc_file:doc_id' => $this->DOC_ID,
            'edoc_file:type_cd' => $this->TYPE_CD,
            'edoc_file:type_nm' => $this->whenLoaded('type', function () {
                return $this->type->COMM2_NM;
            }),
            'edoc_file:doc_nm' => $this->DOC_NM,
            'edoc_file:doc_desc' => $this->DOC_DESC,
            'edoc_file:doc_content' => $this->DOC_CONTENT,
            'edoc_file:doc_appdata' => $this->DOC_APPDATA,
            'edoc_file:period_cd' => $this->PERIOD_CD,
            'edoc_file:period_nm' => $this->whenLoaded('period', function () {
                return $this->period->COMM2_NM;
            }),
            'edoc_file:period_data' => array_filter(explode(',', $this->PERIOD_DATA)),
            'edoc_file:use_yn' => $this->USE_YN,
            'edoc_file:work_id' => $this->WORK_ID,
            'edoc_file:app_id' => $this->APP_ID,
            'edoc_file:upd_dtm' => now()->parse($this->UPD_DTM)->format('Y-m-d'),
        ];
    }
}
