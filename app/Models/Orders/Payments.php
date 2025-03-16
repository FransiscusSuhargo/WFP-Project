<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class, 'payment_id');
    }
}
