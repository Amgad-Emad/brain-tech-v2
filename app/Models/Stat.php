<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasTranslations;

    protected array $translatable = ['label'];

    protected $fillable = ['key', 'value', 'suffix', 'label', 'sort_order', 'is_visible'];

    protected $casts = [
        'value' => 'integer',
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

    /**
     * Formatted display value, e.g. "480+" or "99%".
     */
    public function display(): string
    {
        return number_format($this->value).($this->suffix ?? '');
    }
}
