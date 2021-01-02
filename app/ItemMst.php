<?php

namespace App;

use App\Events\ItemMstCreated;
use App\Events\ItemMstDeleted;
use App\Events\ItemMstUpdated;
use Illuminate\Database\Eloquent\Model;

class ItemMst extends Model
{
    protected $table = 'ITEM_MST';
    protected $primaryKey = 'ITEM_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ITEM_ID', // '자재 ID', -- ITEM_ID
        'ITEM_NM', // '자재이름', -- ITEM_NM
        'SPEC', // '규격', -- SPEC
        'UNIT', // '단위', -- UNIT
        'QTY1', // '당수량', -- QTY1
        'QTY2', // '봉수량', -- QTY2
        'CONN_NO', // '대표품목', -- CONN_NO
        'CONN_QTY', // '연결품목', -- CONN_QTY
        'IN_AMT', // '입고가', -- IN_AMT
        'OUT_AMT', // '출고가', -- OUT_AMT
        'ITEM_CD', // '자재구분', -- ITEM_CD > B10
        'GRP1_CD', // '그룹코드1', -- GRP1_CD > B11
        'GRP2_CD', // '그룹코드2', -- GRP2_CD > B12
        'GRP3_CD', // '그룹코드3', -- GRP3_CD > B13
        'USE_YN', // '사용구분', -- USE_YN
        'PROCESS_CD', // '공정코드', -- PROCESS_CD > B14
        'UNIT1_NM', // '대단위명', -- UNIT1_NM
        'UNIT1_QTY', // '대단위수', -- UNIT1_QTY
        'UNIT2_NM', // '중단위명', -- UNIT2_NM
        'UNIT2_QTY', // '중단위수', -- UNIT2_QTY
        'UNIT3_NM', // '소단위명', -- UNIT3_NM
        'UNIT3_QTY', // '소단위수', -- UNIT3_QTY
        'REG_ID', // '등록자ID', -- REG_ID 
        'REG_DTM', // '등록일시', -- REG_DTM
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => ItemMstCreated::class,
        'updated' => ItemMstUpdated::class,
        'deleted' => ItemMstDeleted::class,
    ];

    public function item()
    {
        return $this->belongsTo('App\CommCd', 'ITEM_CD', 'COMM2_CD')->where('COMM1_CD', 'B10')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function grp1()
    {
        return $this->belongsTo('App\CommCd', 'GRP1_CD', 'COMM2_CD')->where('COMM1_CD', 'B11')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function grp2()
    {
        return $this->belongsTo('App\CommCd', 'GRP2_CD', 'COMM2_CD')->where('COMM1_CD', 'B12')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function grp3()
    {
        return $this->belongsTo('App\CommCd', 'GRP3_CD', 'COMM2_CD')->where('COMM1_CD', 'B13')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function process()
    {
        return $this->belongsTo('App\CommCd', 'PROCESS_CD', 'COMM2_CD')->where('COMM1_CD', 'B14')->whereNotIn('COMM2_CD', ['$$']);
    }

    public function proc_dtl()
    {
        return $this->hasMany('App\ProcDtl', 'ITEM_ID', 'ITEM_ID');
    }

    public function proc_src()
    {
        return $this->hasMany('App\ProcSrc', 'ITEM_ID', 'ITEM_ID');
    }
}
