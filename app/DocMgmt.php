<?php

namespace App;

use App\Events\DocMgmtCreated;
use App\Events\DocMgmtDeleted;
use App\Events\DocMgmtUpdated;
use Illuminate\Database\Eloquent\Model;

class DocMgmt extends Model
{
    protected $table = 'DOC_MGMT';
    protected $primaryKey = 'DOC_ID';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'DOC_ID',
        'TYPE_CD',
        'DOC_NM',
        'DOC_DESC',
        'ATT_DTM',
        'REG_ID',
        'REG_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => DocMgmtCreated::class,
        'updated' => DocMgmtUpdated::class,
        'deleted' => DocMgmtDeleted::class,
    ];

    public function att_file() {
        return $this->hasMany('App\AttFile', 'ATT_DTM', 'ATT_DTM');
    }

    public function type()
    {
        return $this->belongsTo('App\CommCd', 'TYPE_CD', 'COMM2_CD')->where('COMM1_CD', 'A35')->whereNotIn('COMM2_CD', ['$$']);
    }
}
