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
            'user_id' => $this->user_id,
            'user_nm' => $this->user_nm,
            'email' => $this->email,
            'role_cd' => $this->role_cd,
            'role_nm' => $this->whenLoaded('role', function () {
                return $this->role->comm2_nm;
            }),
            'appr_cd' => $this->appr_cd,
            'appr_nm' => $this->whenLoaded('appr', function () {
                return $this->appr->comm2_nm;
            }),
            'job_cd' => $this->job_cd,
            'job_nm' => $this->whenLoaded('job', function () {
                return $this->job->comm2_nm;
            }),
            'user_sts_yn' => $this->user_sts_yn,
            'reg_id' => $this->reg_id,
            'reg_dtm' => Carbon::parse($this->reg_dtm)->format('Y-m-d'),
        ];
    }
}
