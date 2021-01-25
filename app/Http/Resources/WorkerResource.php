<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
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
            'worker:emp_id' => $this->EMP_ID,
            'worker:emp_nm' => $this->EMP_NM,
            'worker:duty_cd' => $this->DUTY_CD,
            'worker:duty_cd_nm' => $this->whenLoaded('duty', function () {
                return $this->duty->COMM2_NM;
            }),
            'worker:mob_no' => $this->MOB_NO,
            'worker:pass_no' => $this->PASS_NO,
            'worker:dept_cd' => $this->DEPT_CD,
            'worker:dept_cd_nm' => $this->whenLoaded('dept', function () {
                return $this->dept->COMM2_NM;
            }),
            'worker:in_dt' => $this->IN_DT,
            'worker:in_dt_parsed' => $this->IN_DT ? now()->parse($this->IN_DT)->format('Y-m-d') : null,
            'worker:out_dt' => $this->OUT_DT,
            'worker:out_dt_parsed' => $this->OUT_DT ? now()->parse($this->OUT_DT)->format('Y-m-d') : null,
            'worker:jumin_no' => $this->JUMIN_NO,
            'worker:birth_dt' => $this->BIRTH_DT,
            'worker:birth_dt_parsed' => $this->BIRTH_DT ? now()->parse($this->BIRTH_DT)->format('Y-m-d') : null,
            'worker:bank_nm' => $this->BANK_NM,
            'worker:acct_no' => $this->ACCT_NO,
            'worker:address' => $this->ADDRESS,
            'worker:email' => $this->EMAIL,
            'worker:main_job' => $this->MAIN_JOB,
            'worker:health_chk_dt' => $this->HEALTH_CHK_DT,
            'worker:health_chk_dt_parsed' => $this->HEALTH_CHK_DT ? now()->parse($this->HEALTH_CHK_DT)->format('Y-m-d') : null,
            'worker:haccp_doc' => $this->HACCP_DOC,
            'worker:role_cd' => $this->ROLE_CD,
            'worker:role_cd_nm' => $this->whenLoaded('role', function () {
                return $this->role->COMM2_NM;
            }),
            'worker:haccp_role' => $this->HACCP_ROLE,
            'worker:reg_id' => $this->REG_ID,
            'worker:reg_dtm' => $this->REG_DTM,
            'worker:reg_dtm_parsed' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
