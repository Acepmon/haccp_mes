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
            'user_id' => $this->user_id,
            'user_nm' => $this->whenLoaded('user') ? $this->user->user_nm : null,
            'login_dtm' => Carbon::parse($this->login_dtm)->format('Y-m-d'),
            'logout_dtm' => Carbon::parse($this->logout_dtm)->format('Y-m-d'),
            'ip_addr' => $this->ip_addr,
        ];
    }
}
