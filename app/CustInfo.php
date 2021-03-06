<?php

namespace App;

use App\Events\CustInfoCreated;
use App\Events\CustInfoDeleted;
use App\Events\CustInfoUpdated;
use Illuminate\Database\Eloquent\Model;

class CustInfo extends Model
{
    protected $table = 'CUST_INFO';
    protected $primaryKey = 'COMP_ID';
    public $incrementing = false;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        '*'
    ];

    // protected $fillable = [
    //     'COMP_ID',
    //     'COMP_NM',
    //     'CEO_NM',
    //     'MOB_NO', 
    //     'CUST_NM', 
    //     'CUST_NO',
    //     'TEL_NO',
    //     'FAX_NO',
    //     'SRH_INFO',
    //     'EMAIL',
    //     'GRP_NM',  
    //     'ADDR',
    //     'REMARK',
    //     'USE_YN', 
    //     'REG_ID',
    //     'REG_DTM',
    //     ];
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
