<?php

namespace Modules\Payments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;
    protected $table = 'withdrawal';
    protected $fillable = [
        'user_id',
        'shaba',
        'amount',
        'status',
    ];
    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\Payments\Database\factories\WithdrawalFactory::new();
    }
}
