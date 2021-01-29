<?php

namespace App;

use App\Events\CcpEscYnCreated;
use App\Events\CcpEscYnDeleted;
use App\Events\CcpEscYnUpdated;
use Illuminate\Database\Eloquent\Model;

class CcpEscYn extends Model
{
    protected $table = 'CCP_ESC_YN';
    protected $primaryKey = 'DEVICE_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $connection = 'haccp_server';

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CcpEscYnCreated::class,
        'updated' => CcpEscYnUpdated::class,
        'deleted' => CcpEscYnDeleted::class,
    ];
}
