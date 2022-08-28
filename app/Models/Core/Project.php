<?php

namespace App\Models\Core;

use App\Models\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, HasImage, SoftDeletes;

    public const STATUS_TYPE = 'projects';

    protected $fillable = [
        'name',
        'image',
        'description',
        'deadline',
        'author_id',
        'client_id',
        'status_id'
    ];

    protected $dates = [
        'deadline'
    ];

    protected function outOfTime(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return new \Illuminate\Database\Eloquent\Casts\Attribute(
            get: fn ($value) => $this->deadline->isPast()
        );
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
