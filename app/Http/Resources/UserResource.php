<?php

namespace App\Http\Resources;

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
            'user_sts_yn' => $this->user_sts_yn,
        ];
    }
}
