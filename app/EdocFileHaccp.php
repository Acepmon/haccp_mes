<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EdocFileHaccp extends Model
{
    protected $table = 'EDOC_FILE_HACCP';
    protected $primaryKey = 'HACCP_SEQ';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
