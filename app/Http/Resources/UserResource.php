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
        $roles = CommCd::where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $this->ROLE_CD))->get();
        $approvals = CommCd::where('COMM1_CD', 'A20')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $this->APPR_CD))->get();

        return [
            'user:user_id' => $this->USER_ID,
            'user:user_nm' => $this->USER_NM,
            // 'user:user_pw' => $this->USER_PW,
            'user:user_pw' => '',
            'user:email' => $this->EMAIL,
            'user:role_cd' => explode(',', $this->ROLE_CD),
            'user:role_nm' => $this->whenLoaded('role', function () use ($roles) {
                return implode(',', $roles->pluck('COMM2_NM')->toArray());
            }),
            'user:appr_cd' => explode(',', $this->APPR_CD),
            'user:appr_nm' => $this->whenLoaded('appr', function () use ($approvals) {
                return implode(',', $approvals->pluck('COMM2_NM')->toArray());
            }),
            'user:job_cd' => $this->JOB_CD,
            'user:job_nm' => $this->whenLoaded('job', function () {
                return $this->job->COMM2_NM;
            }),
            'user:user_sts_yn' => $this->USER_STS_YN,
            'user:reg_dtm' => Carbon::parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
