<?php

namespace App;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_nm', 'user_pw', 'email', 'role_cd', 'appr_cd', 'job_cd', 'user_sts_yn', 'reg_id', 'reg_dtm',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pw',
    ];

    public const STATUS_ACTIVE = 'Y';
    public const STATUS_INACTIVE = 'N';
    public const STATUS_ARRAY = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    protected $casts = [
        // 'reg_dtm' => 'datetime:Y-m-d',
    ];

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'updated' => UserUpdated::class,
        'deleted' => UserDeleted::class,
    ];

    public function username()
    {
        return $this->user_id;
    }

    public function getAuthPassword()
    {
        return $this->user_pw;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo('App\CommCd', 'role_cd', 'comm2_cd')->where('comm1_cd', 'A10')->whereNotIn('comm2_cd', ['$$']);
    }

    public function appr()
    {
        return $this->belongsTo('App\CommCd', 'appr_cd', 'comm2_cd')->where('comm1_cd', 'B10')->whereNotIn('comm2_cd', ['$$']);
    }

    public function job()
    {
        return $this->belongsTo('App\CommCd', 'job_cd', 'comm2_cd')->where('comm1_cd', 'Z10')->whereNotIn('comm2_cd', ['$$']);
    }
}
