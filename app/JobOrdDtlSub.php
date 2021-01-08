<?php

namespace App;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class JobOrdDtlSub extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'JOB_ORD_DTL_SUB';
    protected $primaryKey = ['JOB_NO', 'ITEM_ID', 'SEQ_NO', 'SUB_SEQ_NO'];
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
}
