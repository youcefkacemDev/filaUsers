<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slog',
        'tags',
        'thumbnail',
        'publish',
        'color',
        'user_id',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * The roles that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class, // related model
            'category_post', // pivot table
            'post_id', // local id in the pivot table
            'category_id' // forign id in the pivot table
        );
    }

    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'posts');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
