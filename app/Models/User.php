<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'full_name',
        'password',
        'access_create_users',
        'access_manage_events',
        'access_record_attendees',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'access_create_users' => 'boolean',
            'access_manage_events' => 'boolean',
            'access_record_attendees' => 'boolean',
        ];
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'user_events')->withTimestamps();
    }

    public function createdEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class, 'created_by');
    }

    public function assignedEventIds(): array
    {
        return $this->events()->pluck('events.id')->all();
    }

    public function canManageUsers(): bool
    {
        return $this->access_create_users;
    }

    public function canManageEvents(): bool
    {
        return $this->access_manage_events;
    }

    public function canRecordAttendees(): bool
    {
        return $this->access_record_attendees;
    }
}
