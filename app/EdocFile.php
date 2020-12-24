<?php

namespace App;

use App\Events\EdocFileCreated;
use App\Events\EdocFileDeleted;
use App\Events\EdocFileUpdated;
use Illuminate\Database\Eloquent\Model;

class EdocFile extends Model
{
    protected $table = 'EDOC_FILE';
    protected $primaryKey = 'DOC_ID';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'DOC_ID',
        'TYPE_CD',
        'DOC_NM',
        'DOC_DESC',
        'DOC_CONTENT',
        'DOC_APPDATA',
        'PERIOD_CD',
        'PERIOD_DATA',
        'USE_YN',
        'WORK_ID',
        'APP_ID',
        'UPD_DTM',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => EdocFileCreated::class,
        'updated' => EdocFileUpdated::class,
        'deleted' => EdocFileDeleted::class,
    ];

    public const USE_YES = 'Y';
    public const USE_NO = 'N';
    public const USE_ARRAY = [
        self::USE_YES,
        self::USE_NO
    ];

    public function type()
    {
        return $this->belongsTo('App\CommCd', 'TYPE_CD', 'COMM2_CD')->where('COMM1_CD', 'A40')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function period()
    {
        return $this->belongsTo('App\CommCd', 'PERIOD_CD', 'COMM2_CD')->where('COMM1_CD', 'A50')->whereNotIn('COMM2_CD', ['$$']);
    }
}
