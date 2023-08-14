<?php

namespace Modules\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory, Sluggable;

    /* Relationship to Blog Category */
    public function blog_tbl(){
        return $this->belongsTo(Blog::class, 'id', 'cat');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'id', 'cat');
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'parent', 'id');
    }

    protected $table = 'blog_category';
    protected $fillable = [
        'title',
        'slug',
        'parent',
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
        return \Modules\Blog\Database\factories\BlogCategoryFactory::new();
    }
}
