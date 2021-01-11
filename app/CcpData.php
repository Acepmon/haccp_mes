<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CcpData extends Model
{
    protected $table = 'CCP_DATA';
    protected $primaryKey = 'CCP_SEQ';
    public $incrementing = true;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(env('DB_CCP_CONNECTION', 'mysql'));
    }
}
