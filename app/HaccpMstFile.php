<?php

namespace App;

use App\Events\HaccpMstFileCreated;
use App\Events\HaccpMstFileDeleted;
use App\Events\HaccpMstFileUpdated;
use Illuminate\Database\Eloquent\Model;

class HaccpMstFile extends Model
{
    protected $table = 'haccp_mst_file';
    protected $primaryKey = 'REV_SEQ';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'REV_NO',
        'REV_DT',
        'ATT_DTM',
        'REV_CONTENT',
        'REV_REASON',
        'REG_ID',
        'REG_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => HaccpMstFileCreated::class,
        'updated' => HaccpMstFileUpdated::class,
        'deleted' => HaccpMstFileDeleted::class,
    ];

    public function att_file() {
        return $this->hasMany('App\AttFile', 'ATT_DTM', 'ATT_DTM');
    }
}
