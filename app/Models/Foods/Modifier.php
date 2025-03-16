<?php

namespace App\Models\Foods;

use App\Models\Orders\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modifier extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "price", "type"
    ];

    public function foods() : BelongsToMany
    {
        return $this->belongsToMany(
            Food::class,
            'food_modifiers',
            'modifier_id',
            'food_id'
        )
            ->withTimestamps();
    }

    public function orderDetails() : BelongsToMany
    {
        return $this->belongsToMany(
            OrderDetail::class,
            'order_modifiers',
            'modifier_id',
            'order_detail_id'
        )
            ->withTimestamps();
    }
}
