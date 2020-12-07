<?php

namespace App;

use App\Events\WorkerCreated;
use App\Events\WorkerDeleted;
use App\Events\WorkerUpdated;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'worker';
    protected $primaryKey = 'WORKER_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'WORKER_ID',
        'WORKER_NM',
        'TEL_NO',
        'WORK_CD',
        'HEALTH_CHK_DT',
        'ROLE_CD',
        'REMARK',
        'REG_ID',
        'REG_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => WorkerCreated::class,
        'updated' => WorkerUpdated::class,
        'deleted' => WorkerDeleted::class,
    ];
}
