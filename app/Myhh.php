<?php

namespace App;

use App\Events\MyhhCreated;
use App\Events\MyhhDeleted;
use App\Events\MyhhUpdated;
use Illuminate\Database\Eloquent\Model;

class Myhh extends Model
{
    protected $table = 'MYHH';
    protected $primaryKey = 'MYHH_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'MYHH_ID',
        'MYHH_NM',
        'USER_STS_YN',
        'REG_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => MyhhCreated::class,
        'updated' => MyhhUpdated::class,
        'deleted' => MyhhDeleted::class,
    ];
}
