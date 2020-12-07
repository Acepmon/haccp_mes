<?php

namespace App;

use App\Events\AttFileCreated;
use App\Events\AttFileDeleted;
use App\Events\AttFileUpdated;
use Illuminate\Database\Eloquent\Model;

class AttFile extends Model
{
    protected $table = 'comp_info';
    protected $primaryKey = 'ATT_SEQ';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ATT_DTM',
        'ATT_SEQ',
        'ATT_NM',
        'ATT_PATH',
        'FILE_SZ',
        'RMK',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => AttFileCreated::class,
        'updated' => AttFileUpdated::class,
        'deleted' => AttFileDeleted::class,
    ];
}
