<?php

namespace App;

use App\Events\CcpEscDataCreated;
use App\Events\CcpEscDataDeleted;
use App\Events\CcpEscDataUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class CcpEscData extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'CCP_ESC_DATA';
    protected $primaryKey = ['DEVICE_ID', 'SRT_DTM'];
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
        'created' => CcpEscDataCreated::class,
        'updated' => CcpEscDataUpdated::class,
        'deleted' => CcpEscDataDeleted::class,
    ];

    public function ccp_limit()
    {
        return $this->belongsTo('App\CcpLimit', 'DEVICE_ID', 'DEVICE_ID');
    }
}
