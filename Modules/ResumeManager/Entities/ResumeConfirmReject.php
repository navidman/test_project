<?php

namespace Modules\ResumeManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class ResumeConfirmReject extends Model
{
    use HasFactory;

    /* Relationship to Employer */
    public function employmer_tbl()
    {
        return $this->belongsTo(Users::class, 'employer_id', 'id');
        return $this->belongsTo(Users::class, 'employer_id', 'id');
    }

    /* Relationship to Resume */
    public function resume_file_tbl()
    {
        return $this->belongsTo(ResumeManager::class, 'resume_id', 'id');
    }


    protected $table = 'resume_confirm_reject';
    protected $fillable = [
        'employer_id',
        'resume_id',
        'status'
    ];


    protected static function newFactory()
    {
        return \Modules\ResumeManager\Database\factories\ResumeConfirmRejectFactory::new();
    }
}
