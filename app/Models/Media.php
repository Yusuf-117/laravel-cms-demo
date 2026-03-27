<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size_bytes',
        'sha256',
        'width',
        'height',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    protected $hidden = [
        'sha256',
    ];
    protected $appends = ['url'];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_media')
            ->withPivot(['context', 'sort_order'])
            ->withTimestamps();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function scopeImages(Builder $query): Builder
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->latest('id');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}