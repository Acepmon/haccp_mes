<?php

namespace App;

use App\Events\BomConfigCreated;
use App\Events\BomConfigDeleted;
use App\Events\BomConfigUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class BomConfig extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'BOM_CONIFG';
    protected $primaryKey = ['ITEM1_ID', 'ITEM2_ID'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ITEM1_ID', // '자재ID1', -- ITEM1_ID
        'ITEM2_ID', // '자재ID2', -- ITEM2_ID
        'BOM_VER', // 'BOM 버젼', -- BOM_VER
        'PROD_QTY', // '생산수량', -- PROD_QTY
        'USE_QTY', // '소모량', -- USE_QTY
        'REG_ID', // '등록자ID', -- REG_ID 
        'REG_DTM', // '등록일시', -- REG_DTM
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => BomConfigCreated::class,
        'updated' => BomConfigUpdated::class,
        'deleted' => BomConfigDeleted::class,
    ];
}
