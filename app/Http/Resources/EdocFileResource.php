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
        $periods = [
            ['label' => "월", 'value' => 0],
            ['label' => "화", 'value' => 1],
            ['label' => "수", 'value' => 2],
            ['label' => "목", 'value' => 3],
            ['label' => "금", 'value' => 4],
            ['label' => "토", 'value' => 5],
            ['label' => "일", 'value' => 6],
        ];

        if (!empty($this->PERIOD_DATA) || $this->PERIOD_DATA == '0') {
            $period_data = explode(',', $this->PERIOD_DATA);
            sort($period_data);

            $period_data_parsed = array_map(function ($period) use ($periods) {
                for ($i=0; $i < count($periods); $i++) {
                    if ($periods[$i]['value'] === intval($period)) {
                        return $periods[$i]['label'];
                    }
                }
                return '';
            }, $period_data);
        } else {
            $period_data_parsed = [];
        }

        return [
            'edoc_file:doc_id' => $this->DOC_ID,
            'edoc_file:type_cd' => $this->TYPE_CD,
            'edoc_file:type_nm' => $this->whenLoaded('type', function () {
                return $this->type->COMM2_NM;
            }),
            'edoc_file:doc_nm' => $this->DOC_NM,
            'edoc_file:doc_desc' => $this->DOC_DESC,
            // 'edoc_file:doc_html' => $this->DOC_HTML,
            // 'edoc_file:app_view' => $this->APP_VIEW,
            // 'edoc_file:app_input' => $this->APP_INPUT,
            // 'edoc_file:app_list' => $this->APP_LIST,
            'edoc_file:period_cd' => $this->PERIOD_CD,
            'edoc_file:period_nm' => $this->whenLoaded('period', function () {
                return $this->period->COMM2_NM;
            }),
            'edoc_file:period_data' => explode(',', $this->PERIOD_DATA),
            'edoc_file:period_data_parsed' => $period_data_parsed,
            'edoc_file:period_data_parsed_nm' => implode(',', $period_data_parsed),
            'edoc_file:use_yn' => $this->USE_YN,
            'edoc_file:work_id' => $this->WORK_ID,
            'edoc_file:app_id' => $this->APP_ID,
            'edoc_file:upd_dtm' => now()->parse($this->UPD_DTM)->format('Y-m-d'),
        ];
    }
}
