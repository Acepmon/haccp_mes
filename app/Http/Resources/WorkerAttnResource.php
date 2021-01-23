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
        $duration = '';
        if (!empty($this->OFF_DTM)) {
            $diff = now()->parse($this->ON_DTM)->diffInSeconds(now()->parse($this->OFF_DTM));
            $duration = gmdate('H:i', $diff);
        }

        return [
            'worker_attn:emp_id' => $this->EMP_ID,
            'worker_attn:emp_nm' => $this->whenLoaded('worker', function () {
                return $this->worker->EMP_NM;
            }),
            'worker_attn:on_dtm' => $this->ON_DTM,
            'worker_attn:on_dtm_parsed' => now()->parse($this->ON_DTM)->format('Y-m-d H:i'),
            'worker_attn:duration' => $duration,
            'worker_attn:off_dtm' => $this->OFF_DTM,
            'worker_attn:off_dtm_parsed' => (!empty($this->OFF_DTM)) ? now()->parse($this->OFF_DTM)->format('Y-m-d H:i') : '',
            'worker_attn:remark' => $this->REMARK,
        ];
    }
}
