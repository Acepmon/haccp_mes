<?php

namespace App;

use App\Events\WorkerAttnCreated;
use App\Events\WorkerAttnDeleted;
use App\Events\WorkerAttnUpdated;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class WorkerAttn extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'WORKER_ATTN';
    protected $primaryKey = ['EMP_ID', 'ON_DTM'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => WorkerAttnCreated::class,
        'updated' => WorkerAttnUpdated::class,
        'deleted' => WorkerAttnDeleted::class,
    ];

    public function worker()
    {
        return $this->belongsTo('App\Worker', 'EMP_ID', 'EMP_ID');
    }
}
