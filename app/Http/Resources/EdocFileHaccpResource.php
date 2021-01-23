<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EdocFileHaccpResource extends JsonResource
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
            'edoc_file_haccp:haccp_seq' => $this->HACCP_SEQ,
            'edoc_file_haccp:doc_id' => $this->DOC_ID,
            'edoc_file_haccp:doc_nm' => $this->DOC_NM,
            'edoc_file_haccp:apr_cd' => $this->APR_CD,
            'edoc_file_haccp:apr_nm' => $this->whenLoaded('apr', function () {
                return $this->apr->COMM2_NM;
            }),
            'edoc_file_haccp:doc_html' => $this->DOC_HTML,
            'edoc_file_haccp:app_data' => $this->APPR_DATA,
            'edoc_file_haccp:remark' => $this->REMARK,
            'edoc_file_haccp:use_yn' => $this->USE_YN,
            'edoc_file_haccp:work_id' => $this->WORK_ID,
            'edoc_file_haccp:work_dtm' => $this->WORK_DTM,
            'edoc_file_haccp:work_dtm_parsed' => now()->parse($this->WORK_DTM)->format('Y-m-d H:i:s'),
            'edoc_file_haccp:app_id' => $this->APP_ID,
            'edoc_file_haccp:app_dtm' => $this->APP_DTM,

            $this->mergeWhen($this->whenLoaded('edoc_file'), new EdocFileResource($this->edoc_file)),
        ];
    }
}
