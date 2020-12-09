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
            'user_id' => $this->USER_ID,
            'user_nm' => $this->USER_NM,
            'user_pw' => $this->USER_PW,
            'email' => $this->EMAIL,
            'role_cd' => explode(',', $this->ROLE_CD),
            'appr_cd' => explode(',', $this->APPR_CD),

            'job_cd' => $this->JOB_CD,
            'job_nm' => $this->whenLoaded('job', function () {
                return $this->job->COMM2_NM;
            }),
            'user_sts_yn' => $this->USER_STS_YN,
            'reg_dtm' => Carbon::parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
