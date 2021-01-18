<?php

namespace App;

use App\Events\CcpCdInfoCreated;
use App\Events\CcpCdInfoDeleted;
use App\Events\CcpCdInfoUpdated;
use Illuminate\Database\Eloquent\Model;

class CcpCdInfo extends Model
{
    protected $table = 'CCP_CD_INFO';
    protected $primaryKey = 'CCD_CD';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CcpCdInfoCreated::class,
        'updated' => CcpCdInfoUpdated::class,
        'deleted' => CcpCdInfoDeleted::class,
    ];
}
