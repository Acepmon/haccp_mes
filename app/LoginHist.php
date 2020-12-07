<?php

namespace App;

use App\Events\LoginHistCreated;
use App\Events\LoginHistDeleted;
use App\Events\LoginHistUpdated;
use Illuminate\Database\Eloquent\Model;

class LoginHist extends Model
{
    protected $table = 'login_hist';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $dispatchesEvents = [
        'created' => LoginHistCreated::class,
        'updated' => LoginHistUpdated::class,
        'deleted' => LoginHistDeleted::class,
    ];

    protected $casts = [
        // 'LOGIN_DTM' => 'datetime',
        // 'LOGOUT_DTM' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'USER_ID', 'USER_ID');
    }
}
