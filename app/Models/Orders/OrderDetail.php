<?php

namespace App\Models\Orders;

use App\Models\Foods\Addon;
use App\Models\Foods\Food;
use App\Models\Foods\Modifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        "food_id", "order_id",
        "subtotal", "note"
    ];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function food() : BelongsTo
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function modifiers() : BelongsToMany
    {
        return $this->belongsToMany(
            Modifier::class,
            'order_modifiers',
            'order_detail_id',
            'modifier_id'
        )
            ->withTimestamps();
    }

    public function addons() : BelongsToMany
    {
        return $this->belongsToMany(
            Addon::class,
            'order_addons',
            'order_detail_id',
            'addon_id'
        )
            ->withPivot(['count'])
            ->withTimestamps();
    }
}
