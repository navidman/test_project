<?php

namespace Modules\RequestCenter\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Attachment;
use Modules\Users\Entities\Users;

class RequestCenter extends Model
{
    use HasFactory;

    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    public function owner_tbl()
    {
        return $this->belongsTo(Users::class, 'owner_id', 'id');
    }

    public function voice_tbl()
    {
        return $this->belongsTo(Attachment::class, 'voice', 'id');
    }

    /* Relationship to Blog Category */
    public function received_tbl(){
        return $this->belongsTo(RequestReceived::class, 'id', 'request_center_id');
    }


    protected $table = 'request_center';
    protected $fillable = [
        'uid',
        'title',
        'text_content',
        'amount',
        'title_field',
        'field',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\RequestCenter\Database\factories\RequestCenterFactory::new();
    }
}
