<?php

namespace App\Http\Resources;

use App\CommCd;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user:user_id' => $this->USER_ID,
            'user:user_nm' => $this->USER_NM,
            'user:user_pw' => $this->USER_PW,
            'user:email' => $this->EMAIL,
            'user:role_cd' => explode(',', $this->ROLE_CD),
            'user:appr_cd' => explode(',', $this->APPR_CD),

            'user:job_cd' => $this->JOB_CD,
            'user:job_nm' => $this->whenLoaded('job', function () {
                return $this->job->COMM2_NM;
            }),
            'user:user_sts_yn' => $this->USER_STS_YN,
            'user:reg_dtm' => Carbon::parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
