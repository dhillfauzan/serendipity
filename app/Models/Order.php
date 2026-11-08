<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'payment_verified' => 'datetime',
    ];
    protected $fillable = [
        'order_number',
        'table_number',
        'customer_name',
        'customer_phone',
        'notes',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'qris_reference',
        'payment_proof',
        'payment_verified'
    ];
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Di model Order
public function transaksi()
{
    return $this->belongsTo(Transaksi::class);
}
}