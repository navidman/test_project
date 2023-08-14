<?php

namespace Modules\ConsultationRequest\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $table = 'consultation_request';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'title',
        'message',
        'status',
        'meta_data'
    ];
    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\ConsultationRequest\Database\factories\ConsultationRequestFactory::new();
    }
}
