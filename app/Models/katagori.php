<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class katagori extends Model
{
    public $timestamps = false;
    protected $table = "katagori";
    // protected $fillable = [nama_katagori];
    protected $guarded = ['id'];
}
