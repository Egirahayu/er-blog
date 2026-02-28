<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Scope;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'author', 'body'];
 
    protected $with = ['author', 'category'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    #[Scope]
    protected function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['keyword'] ?? false, function($query, $keyword) {
            $query->where('title','like','%'. $keyword .'%');
        });

        $query->when($filters['category'] ?? false, function($query, $category) {
            $query->whereHas(
                'category', 
                fn(Builder $query) =>
                $query->where('slug', $category)
            );
        });

        $query->when($filters['author'] ?? false, function($query, $author) {
            $query->whereHas(
                'author', 
                fn (Builder $query) =>
                $query->where('username', $author)
            );
        });
    }
}