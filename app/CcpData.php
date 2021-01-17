<?php

namespace App;

use App\Events\CcpDataCreated;
use App\Events\CcpDataDeleted;
use App\Events\CcpDataUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CcpData extends Model
{
    protected $table = 'CCP_DATA';
    protected $primaryKey = 'CCP_SEQ';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;
    protected $connection = 'haccp_server';

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CcpDataCreated::class,
        'updated' => CcpDataUpdated::class,
        'deleted' => CcpDataDeleted::class,
    ];

    public function ccp_limit()
    {
        return $this->hasMany('App\CcpLimit', 'DEVICE_ID', 'DEVICE_ID');
    }
}
