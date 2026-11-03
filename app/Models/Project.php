<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'category_id',
        'client_id',
        'title',
        'slug',
        'location',
        'year',
        'value_or_area',
        'description',
        'cover_image',
        'is_featured',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)
            ->orderBy('sort_order');
    }
}