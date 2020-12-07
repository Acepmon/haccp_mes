<?php

namespace App;

use App\Events\CompInfoCreated;
use App\Events\CompInfoDeleted;
use App\Events\CompInfoUpdated;
use Illuminate\Database\Eloquent\Model;

class CompInfo extends Model
{
    protected $table = 'comp_info';
    protected $primaryKey = 'COMP_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'COMP_ID',
        'COMP_NM',
        'CEO_NM',
        'TEL_NO',
        'FAX_NO',
        'URL',
        'ZIP_CD',
        'ADDR1',
        'ADDR2',
        'HACCP_ID',
        'HACCP_ITEM',
        'REG_ID',
        'REG_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CompInfoCreated::class,
        'updated' => CompInfoUpdated::class,
        'deleted' => CompInfoDeleted::class,
    ];
}
