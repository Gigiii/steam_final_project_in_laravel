<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'address', 'user_id', 'game_id'];

    public function payment_details()
    {
        return $this->hasOne(PaymentDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(User::class);
    }

    public function library()
    {
        return $this->hasOne(Library::class);
    }
}
