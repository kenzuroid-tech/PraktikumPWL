<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'nama',
        'email',
        'category_id',
        'color',
        'content',
        'image',
        // 'tags',
        'published',
        'published_at'
    ];

    protected $casts = [
        // "tags" => "array",
        "published" => "boolean",
        "published_at" => "date"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'post_tag');
    }
}
