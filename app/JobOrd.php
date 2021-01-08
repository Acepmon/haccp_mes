<?php

namespace App;

use App\Events\JobOrdCreated;
use App\Events\JobOrdDeleted;
use App\Events\JobOrdUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class JobOrd extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'JOB_ORD';
    protected $primaryKey = ['JOB_NO', 'ITEM_ID'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => JobOrdCreated::class,
        'updated' => JobOrdUpdated::class,
        'deleted' => JobOrdDeleted::class,
    ];

    public function item()
    {
        return $this->belongsTo('App\ItemMst', 'ITEM_ID', 'ITEM_ID');
    }
}
