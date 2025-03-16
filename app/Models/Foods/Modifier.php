<?php

namespace App\Models\Foods;

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
}
