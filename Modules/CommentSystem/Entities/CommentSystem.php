<?php

namespace Modules\CommentSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Entities\Users;

class CommentSystem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /* Relationship to User */
    public function user_tbl(){
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    protected $table = 'comment';
    protected $fillable = [
        'uid',
        'name',
        'url',
        'email',
        'post_type',
        'post_id',
        'parent_id',
        'status',
        'message',
        'like',
    ];
    public $timestamps = true;
    protected $date = ['deleted_at'];

    protected static function newFactory()
    {
        return \Modules\CommentSystem\Database\factories\CommentSystemFactory::new();
    }
}
