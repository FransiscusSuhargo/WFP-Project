<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Krlove\EloquentModelGenerator\Model\HasMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $personal_access_token
 * @property string $email_verified
 * @property Customer[] $customers
 * @property Employee[] $employees
 */
class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email', 'password', 'role',
        'personal_access_token', 'email_verified'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customers() : HasMany
    {
        return $this->hasMany(Customer::class, 'user_id');
    }
    public function employees()
    {
        return $this->hasMany(Employee::class, 'user_id');
    }
}
