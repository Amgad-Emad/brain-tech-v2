<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasTranslations;

    protected array $translatable = [
        'name', 'tag', 'metric_label', 'client', 'alt',
        'summary', 'challenge', 'approach',
    ];

    protected $fillable = [
        'slug', 'name', 'tag', 'year', 'metric', 'metric_label', 'client',
        'image_path', 'alt', 'summary', 'challenge', 'approach',
        'results', 'services_used', 'sort_order', 'is_visible',
    ];

    protected $casts = [
        'results' => 'array',
        'services_used' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Public image URL, falling back to a bundled placeholder.
     */
    public function imageUrl(): string
    {
        if (! $this->image_path) {
            return asset('Brain-Tech-Premium-Website/brand/mark-512.png');
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/'.$this->image_path);
    }
}
