<?php

namespace Modules\ResumeMetaData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ResumeManager\Entities\ResumeManager;

class ResumeMetaData extends Model
{
    use HasFactory;

    protected $table = 'resume_meta_data';
    protected $fillable = [
        'resume_id',
        'type',
        'meta_data'
    ];

    public $timestamps = false;

    /* Relationship to User */
    public function resume(){
        return $this->hasOne(ResumeManager::class, 'resume_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\ResumeMetaData\Database\factories\ResumeMetaDataFactory::new();
    }
}
