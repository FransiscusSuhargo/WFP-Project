<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $food_id
 * @property integer $orders_id
 * @property integer $modifiers_id
 * @property float $subtotal
 * @property string $note
 * @property integer $quantity
 * @property Food $food
 * @property Modifier $modifier
 * @property Order $order
 */
class OrderDetails extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['modifiers_id', 'subtotal', 'note', 'quantity'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food()
    {
        return $this->belongsTo('App\Models\Food');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modifier()
    {
        return $this->belongsTo('App\Models\Modifier', 'modifiers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'orders_id');
    }
}
