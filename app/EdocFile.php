<?php

namespace App;

use App\Events\EdocFileCreated;
use App\Events\EdocFileDeleted;
use App\Events\EdocFileUpdated;
use Illuminate\Database\Eloquent\Model;

class EdocFile extends Model
{
    protected $table = 'edoc_file';
    protected $primaryKey = 'DOC_ID';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'DOC_ID',
        'TYPE_CD',
        'DOC_NM',
        'DOC_DESC',
        'DOC_CONTENT',
        'DOC_APPDATA',
        'PERIOD_CD',
        'PERIOD_DATA',
        'USE_YN',
        'WORK_ID',
        'APP_ID',
        'UPD_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => EdocFileCreated::class,
        'updated' => EdocFileUpdated::class,
        'deleted' => EdocFileDeleted::class,
    ];
}
