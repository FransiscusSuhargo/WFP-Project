<?php

namespace App\Models\Foods;

use App\Models\Orders\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Addon extends Model
{
    use HasFactory;

    protected $table = 'addons';

    protected $fillable = ["name", "price"];

    public function orderDetails() : BelongsToMany
    {
        return $this->belongsToMany(
            OrderDetail::class,
            'order_addons',
            'addon_id',
            'order_detail_id',
        )
            ->withPivot(['count'])
            ->withTimestamps();
    }
}
