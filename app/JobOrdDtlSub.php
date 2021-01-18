<?php

namespace App;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class JobOrdDtlSub extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'JOB_ORD_DTL_SUB';
    protected $primaryKey = ['JOB_NO', 'ITEM_ID', 'SRC_CD', 'SEQ_NO'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => JobOrdDtlSubCreated::class,
        'updated' => JobOrdDtlSubUpdated::class,
        'deleted' => JobOrdDtlSubDeleted::class,
    ];

    public function src()
    {
        return $this->belongsTo('App\CommCd', 'SRC_CD', 'COMM2_CD')->where('COMM1_CD', 'W20')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function proc()
    {
        return $this->belongsTo('App\CommCd', 'PROC_CD', 'COMM2_CD')->where('COMM1_CD', 'B80')->whereNotIn('COMM2_CD', ['$$']);
    }
}
