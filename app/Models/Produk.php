<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = "produk";
    protected $guarded = ['id'];
    protected $appends = ['status_text'];
    public $timestamps = true;

    public function katagori()
    {
        return $this->belongsTo(Katagori::class, 'katagori_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    // Akses untuk mengubah status menjadi teks
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'Publis' : 'Blok';
    }
}



