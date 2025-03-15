<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $addons_id
 * @property integer $order_details_food_id
 * @property integer $order_details_orders_id
 * @property integer $count
 * @property Addon $addon
 */
class FoodAddon extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addon()
    {
        return $this->belongsTo('App\Models\Addon', 'addons_id');
    }
}
