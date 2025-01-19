<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'address'];

    public function payment_details()
    {
        return $this->hasOne(PaymentDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
