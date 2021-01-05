<?php

namespace App;

use App\Events\JobOrdDtlCreated;
use App\Events\JobOrdDtlDeleted;
use App\Events\JobOrdDtlUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class JobOrdDtl extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'JOB_ORD_DTL';
    protected $primaryKey = ['JOB_DT', 'SEQ_NO', 'ITEM_ID', 'PROC_SEQ_NO'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => JobOrdDtlCreated::class,
        'updated' => JobOrdDtlUpdated::class,
        'deleted' => JobOrdDtlDeleted::class,
    ];
}
