<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkerAttnResource extends JsonResource
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
            'worker_attn:emp_id' => $this->EMP_ID,
            'worker_attn:emp_nm' => $this->whenLoaded('worker', function () {
                return $this->worker->EMP_NM;
            }),
            'worker_attn:on_dtm' => $this->ON_DTM,
            'worker_attn:on_dtm_parsed' => now()->parse($this->ON_DTM)->format('Y-m-d H:i:s'),
            'worker_attn:off_dtm' => $this->OFF_DTM,
            'worker_attn:off_dtm_parsed' => now()->parse($this->OFF_DTM)->format('Y-m-d H:i:s'),
            'worker_attn:remark' => $this->REMARK,
        ];
    }
}
