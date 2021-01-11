<?php

namespace App;

use App\Events\CcpEscDataCreated;
use App\Events\CcpEscDataDeleted;
use App\Events\CcpEscDataUpdated;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class CcpEscData extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'CCP_ESC_DATA';
    protected $primaryKey = ['DEVICE_ID', 'SRT_DTM'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CcpEscDataCreated::class,
        'updated' => CcpEscDataUpdated::class,
        'deleted' => CcpEscDataDeleted::class,
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(env('DB_CCP_CONNECTION', 'mysql'));
    }
}
