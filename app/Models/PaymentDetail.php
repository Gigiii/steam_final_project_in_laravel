<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentDetailFactory> */
    use HasFactory;

    protected $fillable = ['payment_method', 'price', 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
