<?php

namespace App\Models\Orders;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "payment_id", "customer_id", "date",
        "queue_number", "type", "status"
    ];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payments::class, 'payment_id');
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
