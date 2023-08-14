<?php

namespace Modules\SupportSystem\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportDepartments extends Model
{
    use HasFactory, Sluggable;

    public function support_tbl()
    {
        return $this->belongsTo(SupportSystem::class, 'department', 'id')->count();
    }

    protected $table = 'support_departments';
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
        return \Modules\SupportSystem\Database\factories\SupportDepartmentsFactory::new();
    }
}
