<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $categories_id
 * @property string $name
 * @property string $description
 * @property string $nutrition_value
 * @property float $price
 * @property string $foodscol
 * @property Category $category
 * @property Modifier[] $modifiers
 * @property OrderDetail[] $orderDetails
 */
class Food extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['categories_id', 'name', 'description', 'nutrition_value', 'price', 'foodscol'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categories_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modifiers()
    {
        return $this->belongsToMany('App\Models\Modifier', 'modifiers_has_food', 'food_id', 'modifiers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }
}
