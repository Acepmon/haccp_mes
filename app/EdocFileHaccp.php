<?php

namespace App;

use App\Events\EdocFileHaccpCreated;
use App\Events\EdocFileHaccpDeleted;
use App\Events\EdocFileHaccpUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function previewHtml()
    {
        $preview = $this->DOC_HTML;
        $qrWrite = "";
        $qrApproval = "";

        if (!empty($this->WORK_ID) && !empty($this->WORK_DTM)) {
            $qrWrite = "<img src='".route('api.edoc_file_haccp.qr_write', $this->HACCP_SEQ)."' class='blank_box' />";
        }

        if (!empty($this->APP_ID) && !empty($this->APP_DTM)) {
            $qrApproval = "<img src='".route('api.edoc_file_haccp.qr_approval', $this->HACCP_SEQ)."' class='blank_box' />";
        }

        $preview = Str::replaceFirst("{qr_write}", $qrWrite, $preview);
        $preview = Str::replaceFirst("{qr_approval}", $qrApproval, $preview);
        return $preview;
    }
}
