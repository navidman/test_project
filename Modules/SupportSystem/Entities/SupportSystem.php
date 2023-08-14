<?php

namespace Modules\SupportSystem\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\Users;

class SupportSystem extends Model
{
    use HasFactory;

    /* Relationship to User */
    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    /* Relationship to User */
    public function created_by_tbl()
    {
        return $this->belongsTo(Users::class, 'created_by', 'id');
    }

    /* Relationship to User */
    public function department_tbl()
    {
        return $this->belongsTo(SupportDepartments::class, 'department', 'id');
    }

    protected $table = 'support_system';
    protected $fillable = [
        'uid',
        'title',
        'department',
        'priority',
        'ticket_content',
        'attachments',
        'status',
        'created_by',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\SupportSystem\Database\factories\SupportSystemFactory::new();
    }
}
