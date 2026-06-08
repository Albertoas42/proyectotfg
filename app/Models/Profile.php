<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- 1. IMPORTA EL TRAIT AQUÍ

class Profile extends Model
{
    use HasFactory; // <-- 2. ACTIVA EL TRAIT AQUÍ

    protected $primaryKey = 'profile_id';
    protected $fillable = ['user_id', 'bio', 'course', 'avatar_path', 'is_verified'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
