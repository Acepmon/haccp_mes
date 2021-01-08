<?php

namespace App;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class JobOrdBom extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'JOB_ORD_BOM';
    protected $primaryKey = ['JOB_NO', 'ITEM_ID', 'ITEM2_ID'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => JobOrdBomCreated::class,
        'updated' => JobOrdBomUpdated::class,
        'deleted' => JobOrdBomDeleted::class,
    ];
}
