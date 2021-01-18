<?php

namespace App;

use App\Events\WorkerCreated;
use App\Events\WorkerDeleted;
use App\Events\WorkerUpdated;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'WORKER';
    protected $primaryKey = 'EMP_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => WorkerCreated::class,
        'updated' => WorkerUpdated::class,
        'deleted' => WorkerDeleted::class,
    ];

    public function duty()
    {
        return $this->belongsTo('App\CommCd', 'DUTY_CD', 'COMM2_CD')->where('COMM1_CD', 'W30')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function dept()
    {
        return $this->belongsTo('App\CommCd', 'DEPT_CD', 'COMM2_CD')->where('COMM1_CD', 'W40')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function role()
    {
        return $this->belongsTo('App\CommCd', 'ROLE_CD', 'COMM2_CD')->where('COMM1_CD', 'A05')->whereNotIn('COMM2_CD', ['$$']);
    }
}
