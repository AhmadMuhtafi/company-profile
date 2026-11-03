<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'show_logo',
    ];

    protected function casts(): array
    {
        return [
            'show_logo' => 'boolean',
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}