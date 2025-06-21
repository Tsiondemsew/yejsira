<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Shipping extends Model
{
    protected $fillable = ['order_id', 'address', 'city', 'country', 'postal_code', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
