<?php

namespace Modules\EmploymentAdvertisement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\Users;

class EmploymentAdvertisement extends Model
{
    use HasFactory;

    public function user_tbl() {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    public function category_tbl() {
        return $this->belongsTo(EmploymentAdvertisementCategory::class, 'cat', 'id');
    }

    protected $table = 'employment_advertisement';
    protected $fillable = [
        'uid',
        'title',
        'cat',
        'proficiency',
        'city',
//        'personal_proficiency',
        'cooperation_type',
        'minimum_salary',
        'gender',
        'content_text',
        'head_hunt_recommended',
        'expert_ads_recommended',
        'status',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\EmploymentAdvertisement\Database\factories\EmploymentAdvertisementFactory::new();
    }
}
