<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'visitor_id',
        'content',
    ];

    protected $casts = [
        'article_id' => 'integer',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeForVisitor(Builder $query, string $visitorId): Builder
    {
        return $query->where('visitor_id', $visitorId);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->latest('id');
    }
}