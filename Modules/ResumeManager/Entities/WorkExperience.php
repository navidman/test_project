<?php

namespace Modules\ResumeManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experience';
    protected $fillable = [
        'resume_id',
        'full_name',
        'email',
        'phone',
        'company_name',
        'cooperation_period',
        'cooperation_type',
        'linkedin',
        'linkedin_status',
        'experience_message',
        'status',
        'key'
    ];
    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\ResumeManager\Database\factories\WorkExperienceFactory::new();
    }
}
