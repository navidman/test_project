<?php

namespace Modules\Payments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallet';
    protected $fillable = [
        'uid',
        'topli',
        'topli_score'
    ];

    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Payments\Database\factories\WalletFactory::new();
    }
}
