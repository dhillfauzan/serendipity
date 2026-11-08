<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'total',
        'total_item',
        'user_id',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
        'tanggal' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate kode transaksi
    public static function generateCode()
    {
        $date = now()->format('Ymd');
        $lastTransaction = self::where('kode_transaksi', 'like', "TRX-$date%")->latest()->first();
        $lastNumber = $lastTransaction ? (int)substr($lastTransaction->kode_transaksi, -4) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return "TRX-$date-$newNumber";
    }
    public function getFormattedItemsAttribute()
{
    $items = is_array($this->items) ? $this->items : json_decode(json_encode($this->items), true);
    
    return array_map(function($item) {
        $harga = $item['harga'] ?? $item['price'] ?? 0;
        $quantity = $item['quantity'] ?? 0;
        
        return [
            'nama_produk' => $item['nama_produk'] ?? $item['name'] ?? 'Produk Tidak Diketahui',
            'quantity' => $quantity,
            'harga' => $harga,
            'subtotal' => $item['subtotal'] ?? ($harga * $quantity)
        ];
    }, $items);
}
// Di file App\Models\Transaksi.php
public function order()
{
    return $this->belongsTo(Order::class);
}
}