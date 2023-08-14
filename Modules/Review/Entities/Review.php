<?php

namespace Modules\Review\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';
    protected $fillable = [
        'post_id',
        'post_type',
        'rate',
        'ip',
    ];

    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Review\Database\factories\ReviewFactory::new();
    }
}
