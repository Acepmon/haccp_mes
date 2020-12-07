<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginHistResource extends JsonResource
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
            'user_nm' => $this->whenLoaded('user', function () {
                return $this->user->USER_NM;
            }),
            'login_dtm' => Carbon::parse($this->LOGIN_DTM)->format('Y-m-d'),
            'logout_dtm' => Carbon::parse($this->LOGOUT_DTM)->format('Y-m-d'),
            'ip_addr' => $this->IP_ADDR,
        ];
    }
}
