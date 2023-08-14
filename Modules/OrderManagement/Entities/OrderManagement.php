<?php

namespace Modules\OrderManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderManagement extends Model
{
    use HasFactory;

    protected $table = 'order_management';
    protected $fillable = [
        'uid',
        'title',
        'object',
        'score',
        'type',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\OrderManagement\Database\factories\OrderManagementFactory::new();
    }
}
