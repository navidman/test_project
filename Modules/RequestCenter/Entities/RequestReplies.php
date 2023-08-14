<?php

namespace Modules\RequestCenter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class RequestReplies extends Model
{
    use HasFactory;


    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    public function request_received()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    protected $table = 'request_replies';
    protected $fillable = [
        'uid',
        'request_id',
        'content_text',
        'attachments',
        'voice',
        'need_to_answer',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\RequestCenter\Database\factories\RequestRepliesFactory::new();
    }
}
