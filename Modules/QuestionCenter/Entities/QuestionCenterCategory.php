<?php

namespace Modules\QuestionCenter\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCenterCategory extends Model
{
    use HasFactory, Sluggable;

    /* Relationship to Blog Category */
    public function question_tbl(){
        return $this->belongsTo(QuestionCenter::class, 'id', 'cat');
    }

    protected $table = 'question_center_category';
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
        return \Modules\QuestionCenter\Database\factories\QuestionCenterCategoryFactory::new();
    }
}
