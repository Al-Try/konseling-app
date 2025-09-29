<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role'];
    protected $hidden   = ['password','remember_token'];

    public function guruWali()
    {
        return $this->hasOne(GuruWali::class, 'user_id'); // guru_walis.user_id
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isGuruWali(): bool { return in_array($this->role, ['guru_wali','guru']); }
}
