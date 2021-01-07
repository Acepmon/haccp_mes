<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function device()
    {
        return $this->belongsTo('App\CommCd', 'DEVICE_ID', 'COMM2_CD')->where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$']);
    }
}
