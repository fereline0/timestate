<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_role';

    protected $fillable = ['user_id', 'role_id'];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с моделью Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}