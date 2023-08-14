<?php

namespace Modules\EmploymentAdvertisement\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentAdvertisementPersonalProficiency extends Model
{
    use HasFactory, Sluggable;

    public function EmploymentAdvertisement() {
        return $this->belongsTo(EmploymentAdvertisement::class, 'id', 'personal_proficiency');
    }

    protected $table = 'employment_advertisement_personal_proficiency';
    protected $fillable = [
        'title',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['slug']
            ]
        ];
    }

    protected static function newFactory()
    {
        return \Modules\EmploymentAdvertisement\Database\factories\EmploymentAdvertisementPersonalProficiencyFactory::new();
    }
}
