<?php

namespace Modules\RequestCenter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;
use function Symfony\Component\Translation\t;

class RequestReceived extends Model
{
    use HasFactory;

    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }


    public function request_center_btl()
    {
        return $this->belongsTo(RequestCenter::class, 'request_center_id', 'id');
    }

    protected $table = 'requests_received';
    protected $fillable = [
        'uid',
        'request_center_id',
        'field',
        'status'
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\RequestCenter\Database\factories\RequestReceivedFactory::new();
    }
}
