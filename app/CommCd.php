<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommCd extends Model
{
    protected $table = 'comm_cd';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
