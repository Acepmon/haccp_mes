<?php

namespace App;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens;

    protected $table = 'USER';
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

    public function routeNotificationForMail($notification)
    {
        // Return email address and name...
        return [$this->EMAIL => $this->USER_NM];
    }

    public function role()
    {
        return $this->hasMany('App\CommCd', 'COMM2_CD', 'ROLE_CD')->where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function appr()
    {
        return $this->hasMany('App\CommCd', 'COMM2_CD', 'APPR_CD')->where('COMM1_CD', 'A20')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function job()
    {
        return $this->belongsTo('App\CommCd', 'JOB_CD', 'COMM2_CD')->where('COMM1_CD', 'A30')->whereNotIn('COMM2_CD', ['$$']);
    }
}
