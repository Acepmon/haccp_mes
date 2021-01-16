<?php

namespace App;

use App\Events\ProcDtlSubCreated;
use App\Events\ProcDtlSubDeleted;
use App\Events\ProcDtlSubUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProcDtlSub extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'PROC_DTL_SUB';
    protected $primaryKey = ['ITEM_ID', 'SRC_CD', 'SEQ_NO'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => ProcDtlSubCreated::class,
        'updated' => ProcDtlSubUpdated::class,
        'deleted' => ProcDtlSubDeleted::class,
    ];

    public function src()
    {
        return $this->belongsTo('App\CommCd', 'PROC_CD', 'COMM2_CD')->where('COMM1_CD', 'W20')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function proc()
    {
        return $this->belongsTo('App\CommCd', 'PROC_CD', 'COMM2_CD')->where('COMM1_CD', 'B80')->whereNotIn('COMM2_CD', ['$$']);
    }
}
