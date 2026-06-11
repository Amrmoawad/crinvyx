<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'name',
        'city',
        'home_group',
        'service_type',
        'year',
        'month',
        'day',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'month' => 'integer',
            'day' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Attendee $attendee): void {
            if (auth()->check()) {
                $attendee->created_by ??= auth()->id();
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeForUserEvents(Builder $query, User $user): Builder
    {
        return $query->whereIn('event_id', $user->assignedEventIds());
    }

    public function scopeCreatedToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }
}
