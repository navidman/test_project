<?php

namespace Modules\ResumeManager\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementProficiency;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\ResumeMetaData\Entities\ResumeMetaData;
use Modules\Users\Entities\Users;

class ResumeManager extends Model
{
    use HasFactory, SoftDeletes;

    /* Relationship to User */
    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id')->select('id', 'full_name', 'province', 'district', 'city', 'gender', 'email', 'phone', 'avatar');
    }

    /* Relationship to Resume File */
    public function resume_file_tbl()
    {
        return $this->belongsTo(FileLibrary::class, 'resume_file', 'id');
    }

    /* Relationship to Skills */
    public function skill_tbl()
    {
        return $this->belongsTo(EmploymentAdvertisementProficiency::class, 'skills', 'id');
    }

    /* Relationship to Introducer */
    public function introducer_tbl()
    {
        return $this->belongsTo(ResumeIntroducer::class, 'id', 'resume_id');
    }

    protected $table = 'resume_manager';
    protected $fillable = [
        'uid',
        'job_position', // عنوان شغلي
        'level', // ارشدیت
        'cooperation_type', // نوع همکاری
        'presence_type', // نوع حضور
        'birth_day', // تاریخ تولد
        'sarbazi', // وضعیت سربازی
        'access_resume', // چه کسانی دسترسی داشته باشند
        'salary', // حقوق درخواستی
        'specialty', // تخصص های فردی
        'resume_file', // فایل رزومه
        'linkedin', // لینکدین
        'dribbble', // دریبل
        'skills', // دانش و مهارت تخصصی
        'education', // سطح تحصیلات
        'experience', // تجربه
        'status',
        'job_status',
        'requirements',
        'confirm_date'
    ];
    public $timestamps = true;
    protected $date = ['deleted_at'];

    /* Relationship to User */
    public function resume_meta_data()
    {
        return $this->hasMany(ResumeMetaData::class, 'resume_id');
    }


    protected static function newFactory()
    {
        return \Modules\ResumeManager\Database\factories\ResumeManagerFactory::new();
    }
}
