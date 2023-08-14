<?php

namespace Modules\QuestionCenter\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Entities\Users;

class QuestionCenter extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    /* Relationship to User */
    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id');
    }

    /* Relationship to Blog Category */
    public function question_category_tbl(){
        return $this->belongsTo(QuestionCenterCategory::class, 'cat', 'id');
    }

    protected $table = 'question_center';
    protected $fillable = [
        'uid',
        'title',
        'slug',
        'content_text',
        'cat',
        'rate',
        'status',
    ];

    public $timestamps = true;
    protected $date = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title']
            ]
        ];
    }

    protected static function newFactory()
    {
        return \Modules\QuestionCenter\Database\factories\QuestionCenterFactory::new();
    }
}
