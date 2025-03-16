<?php

namespace App\Models\Foods;

use App\Models\Orders\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        "category_id", "name", "description",
        "nutrition_value", "price"
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(OrderDetail::class, 'food_id');
    }

    public function modifiers() : BelongsToMany
    {
        return $this->belongsToMany(
            Modifier::class,
            'food_modifiers',
            "food_id",
            "modifier_id"
        )
            ->withTimestamps();
    }
}
