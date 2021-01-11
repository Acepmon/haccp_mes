<?php

namespace App;

use App\Events\CcpLimitCreated;
use App\Events\CcpLimitDeleted;
use App\Events\CcpLimitUpdated;
use Illuminate\Database\Eloquent\Model;

class CcpLimit extends Model
{
    protected $table = 'CCP_LIMIT';
    protected $primaryKey = 'DEVICE_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => CcpLimitCreated::class,
        'updated' => CcpLimitUpdated::class,
        'deleted' => CcpLimitDeleted::class,
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(env('DB_CCP_CONNECTION', 'mysql'));
    }
}
