<?php

namespace App;

use App\Events\ProcSrcCreated;
use App\Events\ProcSrcDeleted;
use App\Events\ProcSrcUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProcSrc extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'PROC_SRC';
    protected $primaryKey = ['ITEM_ID', 'SEQ_NO'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => ProcSrcCreated::class,
        'updated' => ProcSrcUpdated::class,
        'deleted' => ProcSrcDeleted::class,
    ];

    public function item_mst()
    {
        return $this->belongsTo('App\ItemMst', 'ITEM_ID', 'ITEM_ID');
    }
}
