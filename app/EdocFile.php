<?php

namespace App;

use App\Events\EdocFileCreated;
use App\Events\EdocFileDeleted;
use App\Events\EdocFileUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EdocFile extends Model
{
    protected $table = 'EDOC_FILE';
    protected $primaryKey = 'DOC_ID';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

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

    public function previewHtml()
    {
        $preview = $this->DOC_HTML;
        $preview = Str::replaceFirst("{qr_write}", "<img src='".route('api.edoc_file.qr_write', $this->DOC_ID)."' class='blank_box' />", $preview);
        $preview = Str::replaceFirst("{qr_approval}", "<img src='".route('api.edoc_file.qr_approval', $this->DOC_ID)."' class='blank_box' />", $preview);
        return $preview;
    }

    public function type()
    {
        return $this->belongsTo('App\CommCd', 'TYPE_CD', 'COMM2_CD')->where('COMM1_CD', 'A40')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function period()
    {
        return $this->belongsTo('App\CommCd', 'PERIOD_CD', 'COMM2_CD')->where('COMM1_CD', 'A50')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function edoc_file_haccp()
    {
        return $this->hasMany('App\EdocFileHaccp', 'DOC_ID', 'DOC_ID');
    }
}
