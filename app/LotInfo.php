<?php

namespace App;

use App\Events\LotInfoCreated;
use App\Events\LotInfoDeleted;
use App\Events\LotInfoUpdated;
use Illuminate\Database\Eloquent\Model;

class LotInfo extends Model
{
    protected $table = 'LOT_INFO';
    protected $primaryKey = 'DT_NO';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        '*'
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => LotInfoCreated::class,
        'updated' => LotInfoUpdated::class,
        'deleted' => LotInfoDeleted::class,
    ];
}
