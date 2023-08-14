<?php

namespace Modules\ResumeManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchasedResumes extends Model
{
    use HasFactory;

    protected $table = 'purchased_resumes';
    protected $fillable = [
        'buyer_id',
        'resume_id',
        'amount',
        'result',
        'reasons',
    ];
    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\ResumeManager\Database\factories\PurchasedResumesFactory::new();
    }
}
