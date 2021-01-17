<?php

namespace App;

use App\Events\ProdInfoCreated;
use App\Events\ProdInfoDeleted;
use App\Events\ProdInfoUpdated;
use Illuminate\Database\Eloquent\Model;

class ProdInfo extends Model
{
    protected $table = 'PROD_INFO';
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
        'created' => ProdInfoCreated::class,
        'updated' => ProdInfoUpdated::class,
        'deleted' => ProdInfoDeleted::class,
    ];
}
