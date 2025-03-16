<?php

namespace App\Models\Foods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id", "name", "description",
        "nutrition_value", "price"
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id");
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
