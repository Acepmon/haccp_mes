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
    protected $primaryKey = 'USER_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'USER_ID',
        'USER_NM',
        'USER_PW',
        'EMAIL',
        'ROLE_CD',
        'APPR_CD',
        'JOB_CD',
        'USER_STS_YN',
        'REG_DTM',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'USER_PW',
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
        return $this->USER_ID;
    }

    public function getAuthPassword()
    {
        return $this->USER_PW;
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
        return $this->belongsTo('App\CommCd', 'ROLE_CD', 'COMM2_CD')->where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function appr()
    {
        return $this->belongsTo('App\CommCd', 'APPR_CD', 'COMM2_CD')->where('COMM1_CD', 'B10')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function job()
    {
        return $this->belongsTo('App\CommCd', 'JOB_CD', 'COMM2_CD')->where('COMM1_CD', 'Z10')->whereNotIn('COMM2_CD', ['$$']);
    }
}
