<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileVerifyCode extends Model
{
    use HasFactory;

    protected $table = 'mobile_verify_code';
    protected $fillable = [
        'mobile_number',
        'code'
    ];

    public $timestamps = true;
}
