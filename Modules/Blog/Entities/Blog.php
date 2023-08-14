<?php

namespace Modules\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\Users\Entities\Users;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    /* Relationship to User */
    public function user_tbl(){
        return $this->belongsTo(Users::class, 'author', 'id');
    }

    /* Relationship to Blog Category */
    public function blog_category_tbl(){
        return $this->belongsTo(BlogCategory::class, 'cat', 'id');
    }

    /* Relationship to File Library */
    public function thumbnail_tbl(){
        return $this->belongsTo(FileLibrary::class, 'thumbnail', 'id');
    }

    protected $table = 'blog';
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content_text',
        'cat',
        'thumbnail',
        'author',
        'status',
        'time_watch',
        'article_level',
        'visited',
        'tag',
        'featured',
        'publish_at',
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
        return \Modules\Blog\Database\factories\BlogFactory::new();
    }
}
