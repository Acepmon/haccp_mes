<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginHist extends Model
{
    protected $table = 'login_hist';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
