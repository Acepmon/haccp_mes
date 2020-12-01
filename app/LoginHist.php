<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginHist extends Model
{
    protected $table = 'login_hist';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
