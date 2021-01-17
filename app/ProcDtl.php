<?php

namespace App;

use App\Events\ProcDtlCreated;
use App\Events\ProcDtlDeleted;
use App\Events\ProcDtlUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProcDtl extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'PROC_DTL';
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
        'created' => ProcDtlCreated::class,
        'updated' => ProcDtlUpdated::class,
        'deleted' => ProcDtlDeleted::class,
    ];

    public function item_mst()
    {
        return $this->belongsTo('App\ItemMst', 'ITEM_ID', 'ITEM_ID');
    }

    public function proc()
    {
        return $this->belongsTo('App\CommCd', 'PROC_CD', 'COMM2_CD')->where('COMM1_CD', 'B80')->whereNotIn('COMM2_CD', ['$$']);
    }
}
