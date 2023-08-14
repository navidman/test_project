<?php

namespace Modules\EmploymentAdvertisement\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentAdvertisementCategory extends Model
{
    use HasFactory, Sluggable;

    public function EmploymentAdvertisement() {
        return $this->belongsTo(EmploymentAdvertisement::class, 'id', 'cat')->count();
    }

    protected $table = 'employment_advertisement_category';
    protected $fillable = [
        'title',
        'slug'
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
        return \Modules\EmploymentAdvertisement\Database\factories\EmploymentAdvertisementCategoryFactory::new();
    }
}
