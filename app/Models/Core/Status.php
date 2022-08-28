<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Status extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    public const AVAILABLE_TYPES_CLASSES = [
        'clients' => Client::class,
        'projects' => Project::class
    ];

    public array $translatable = [
        'name'
    ];

    protected $fillable = [
        'name',
        'color',
        'text_color',
        'type',
        'is_started',
        'is_ended',
        'weight'
    ];

    protected $casts = [
        'is_started' => 'boolean',
        'is_ended' => 'boolean'
    ];

    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class);
    }
}
