<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CcpData extends Model
{
    protected $table = 'CCP_DATA';
    protected $primaryKey = 'CCP_SEQ';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;
    protected $connection = 'haccp_server';

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
