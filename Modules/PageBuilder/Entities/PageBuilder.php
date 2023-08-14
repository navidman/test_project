<?php

namespace Modules\PageBuilder\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class PageBuilder extends Model
{
    use HasFactory, Sluggable;

    /* Relationship to User */
    public function user_tbl(){
        return $this->belongsTo(Users::class, 'author', 'id');
    }

    protected $table = 'page_builder';
    protected $fillable = [
        'title',
        'slug',
        'content_text',
        'author',
        'visited',
        'status',
    ];

    public $timestamps = true;

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
        return \Modules\PageBuilder\Database\factories\PageBuilderFactory::new();
    }
}
