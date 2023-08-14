<?php

namespace Modules\ResumeIntroducer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\Users\Entities\Users;

class ResumeIntroducer extends Model
{
    use HasFactory;

    /* Relationship to Resume */
    public function resume_tbl()
    {
        return $this->belongsTo(ResumeManager::class, 'resume_id', 'id');
    }

    /* Relationship to Job Seeker */
    public function job_seeker_tbl()
    {
        return $this->belongsTo(Users::class, 'job_seeker_id', 'id');
    }

    /* Relationship to Employment */
    public function employment_tbl()
    {
        return $this->belongsTo(Users::class, 'employment_id', 'id')->select('id', 'company_name_fa', 'full_name');
    }

    /* Relationship to Interview File */
    public function interview_file_tbl()
    {
        return $this->belongsTo(FileLibrary::class, 'interview_file', 'id');
    }

    /* Relationship to Voice File */
    public function voice_file_tbl()
    {
        return $this->belongsTo(FileLibrary::class, 'voice', 'id');
    }

    protected $table = 'resume_introducer';
    protected $fillable = [
        'resume_id', // شناسه رزومه
        'job_seeker_id', // شناسه کارجو
        'employment_id', // شناسه معرفی کننده
        'recognition', // نحوه آشنایی
        'confidence', // سطح اطمینان از تجربه پیشین
        'expertise', // شایستگی های تخصصی
        'personality', // شایستگی های روانشناختی
        'experience', // میزان تجربه در شغل
        'software', // مهارت های نرم افزاری
        'organizational_behavior', // رفتار حرفه ای
        'passion', // اشتیاق در شغل
        'salary_rate', // حقوق و دستمزد
        'reason_adjustment', // با این اوصاف چرا امکان همکاری فراهم نگردید؟
        'comment_employment', // نظر کارفرما
        'expert_opinion', // نظر تخصصی کارفرما
        'interview_file', // فایل مصاحبه
        'voice', // ویس
        'status', // وضعیت
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\ResumeIntroducer\Database\factories\ResumeIntroducerFactory::new();
    }
}
