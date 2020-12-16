<?php

namespace App;

use App\Events\SecuDocMgmtCreated;
use App\Events\SecuDocMgmtDeleted;
use App\Events\SecuDocMgmtUpdated;
use Illuminate\Database\Eloquent\Model;

class SecuDocMgmt extends Model
{
    protected $table = 'secu_doc_mgmt';
    protected $primaryKey = 'DOC_ID';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'DOC_ID',
        'DOC_NM',
        'DOC_DT',
        'ATT_DTM',
        'FROM_DT',
        'TO_DT',
        'REG_ID',
        'REG_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => SecuDocMgmtCreated::class,
        'updated' => SecuDocMgmtUpdated::class,
        'deleted' => SecuDocMgmtDeleted::class,
    ];

    public function att_file() {
        return $this->hasMany('App\AttFile', 'ATT_DTM', 'ATT_DTM');
    }
}
