<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "user_id", "member_start_date",
        "member_end_date", "status"
    ];

    protected $casts = [
        "member_start_date" => "date",
        "member_end_date" => "date"
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
