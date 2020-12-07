<?php

namespace App;

use App\Events\CommCdCreated;
use App\Events\CommCdDeleted;
use App\Events\CommCdUpdated;
use Illuminate\Database\Eloquent\Model;

class CommCd extends Model
{
    protected $table = 'comm_cd';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'COMM1_CD',
        'COMM2_CD',
        'COMM2_NM',
        'REG_ID',
        'REG_DTM',
    ];

    protected $dispatchesEvents = [
        'created' => CommCdCreated::class,
        'updated' => CommCdUpdated::class,
        'deleted' => CommCdDeleted::class,
    ];
}
