<?php

namespace App;

use App\Events\EdocFileCreated;
use App\Events\EdocFileDeleted;
use App\Events\EdocFileUpdated;
use Illuminate\Database\Eloquent\Model;

class CustInfo extends Model
{
    protected $table = 'CUST_INFO';
    protected $primaryKey = 'COMP_ID';
    public $incrementing = false;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['*'];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CustInfoCreated::class,
        'updated' => CustInfoUpdated::class,
        'deleted' => CustInfoDeleted::class,
    ];

    public const USE_Y = 'Y';
    public const USE_N = 'N';
    public const USE_ARRAY = [
        self::USE_Y,
        self::USE_N
    ];
}
