<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Event $event): void {
            if (auth()->check()) {
                $event->created_by ??= auth()->id();
                $event->updated_by ??= auth()->id();
            }
        });

        static::updating(function (Event $event): void {
            if (auth()->check()) {
                $event->updated_by = auth()->id();
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_events')->withTimestamps();
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
