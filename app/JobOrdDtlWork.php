<?php

namespace App;

use App\Events\JobOrdDtlWorkCreated;
use App\Events\JobOrdDtlWorkDeleted;
use App\Events\JobOrdDtlWorkUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class JobOrdDtlWork extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'JOB_ORD_DTL_WORK';
    protected $primaryKey = ['JOB_NO', 'ITEM_ID', 'SEQ_NO', 'EMP_ID'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => JobOrdDtlWorkCreated::class,
        'updated' => JobOrdDtlWorkUpdated::class,
        'deleted' => JobOrdDtlWorkDeleted::class,
    ];

    public function worker()
    {
        return $this->belongsTo('App\Worker', 'EMP_ID', 'EMP_ID');
    }
}
