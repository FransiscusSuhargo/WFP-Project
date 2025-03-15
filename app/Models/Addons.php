<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property float $price
 * @property FoodAddon[] $foodAddons
 */
class Addons extends Model
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
    protected $fillable = ['name', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foodAddons()
    {
        return $this->hasMany('App\Models\FoodAddon', 'addons_id');
    }
}
