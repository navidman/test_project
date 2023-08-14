<?php

namespace Modules\SupportSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class Ticket extends Model
{
    use HasFactory;

    public function user_tbl() {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    protected $table = 'ticket';
    protected $fillable = [
        'uid',
        'support_id',
        'replay_text',
        'attachments',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\SupportSystem\Database\factories\TicketFactory::new();
    }
}
