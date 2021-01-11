<?php

namespace App;

use App\Events\EdocFileHaccpCreated;
use App\Events\EdocFileHaccpDeleted;
use App\Events\EdocFileHaccpUpdated;
use Illuminate\Database\Eloquent\Model;

class EdocFileHaccp extends Model
{
    protected $table = 'EDOC_FILE_HACCP';
    protected $primaryKey = 'HACCP_SEQ';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => EdocFileHaccpCreated::class,
        'updated' => EdocFileHaccpUpdated::class,
        'deleted' => EdocFileHaccpDeleted::class,
    ];

    public function edoc_file()
    {
        return $this->belongsTo('App\EdocFile', 'DOC_ID', 'DOC_ID');
    }

    public function apr()
    {
        return $this->belongsTo('App\CommCd', 'APR_CD', 'COMM2_CD')->where('COMM1_CD', 'C10')->whereNotIn('COMM2_CD', ['$$']);
    }
}
