<?php

namespace Modules\EmploymentAdvertisement\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmploymentAdvertisementProficiency extends Model
{
    use HasFactory, Sluggable;

    public function EmploymentAdvertisement() {
        return $this->belongsTo(EmploymentAdvertisement::class, 'id', 'proficiency')->count();
    }

    protected $table = 'employment_advertisement_proficiency';
    protected $fillable = [
        'title',
        'slug',
    ];

    public $timestamps = true;

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
        return \Modules\EmploymentAdvertisement\Database\factories\EmploymentAdvertisementProficiencyFactory::new();
    }
}
