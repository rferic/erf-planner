<?php

namespace App\Models\Core;

use App\Models\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, HasImage, SoftDeletes;

    public const STATUS_TYPE = 'clients';

    protected $fillable = [
        'name',
        'image',
        'email',
        'phone',
        'web',
        'status_id'
    ];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class);
    }
}
