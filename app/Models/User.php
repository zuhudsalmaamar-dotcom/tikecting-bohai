<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI ELOQUENT ---

    // Relasi: User membuat banyak tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    // Relasi: User (teknisi) menangani banyak tiket
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'technician_id');
    }

    // Relasi: User membuat banyak komentar
    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }
}