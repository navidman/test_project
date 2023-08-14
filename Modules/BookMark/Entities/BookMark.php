<?php

namespace Modules\BookMark\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookMark extends Model
{
    use HasFactory;

    protected $table = 'bookmark';
    protected $fillable = [
        'uid',
        'object_id',
        'type'
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\BookMark\Database\factories\BookMarkFactory::new();
    }
}
