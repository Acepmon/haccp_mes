<?php

namespace App;

use App\Events\CcpEscYnHistCreated;
use App\Events\CcpEscYnHistDeleted;
use App\Events\CcpEscYnHistUpdated;
use Illuminate\Database\Eloquent\Model;

class CcpEscYnHist extends Model
{
    protected $table = 'CCP_ESC_YN_HIST';
    protected $primaryKey = 'DEVICE_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    // protected $connection = 'haccp_server';

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CcpEscYnHistCreated::class,
        'updated' => CcpEscYnHistUpdated::class,
        'deleted' => CcpEscYnHistDeleted::class,
    ];
}
