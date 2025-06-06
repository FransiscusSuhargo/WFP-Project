<?php

namespace App\Models\Foods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function foods() : HasMany
    {
        return $this->hasMany(Food::class, 'category_id');
    }
}
