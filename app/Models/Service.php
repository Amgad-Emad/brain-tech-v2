<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasTranslations;

    protected array $translatable = [
        'title', 'description', 'tagline', 'long_description',
        'offer_label', 'offer_title', 'offer_text', 'offer_until',
    ];

    protected $fillable = [
        'icon_key', 'slug', 'title', 'description', 'tagline', 'long_description',
        'deliverables', 'offer_enabled', 'offer_label', 'offer_title',
        'offer_text', 'offer_until', 'sort_order', 'is_visible',
    ];

    protected $casts = [
        'deliverables' => 'array',
        'offer_enabled' => 'boolean',
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
}
