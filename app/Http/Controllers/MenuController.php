<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $makanan = Produk::where('katagori_id', 1)->where('status', 1)->get();
        $minuman = Produk::where('katagori_id', 2)->where('status', 1)->get();
        $snack = Produk::where('katagori_id', 3)->where('status', 1)->get();
        $best = Produk::where('katagori_id', 4)->where('status', 1)->get();
        
        return view('frontend.menu.index', compact('makanan', 'minuman', 'snack', 'best'));
    }

    public function makanan()
    {
        $makanan = Produk::where('katagori_id', 1)->where('status', 1)->get();
        return view('frontend.menu.makanan', compact('makanan'));
    }

    public function minuman()
    {
        $minuman = Produk::where('katagori_id', 2)->where('status', 1)->get();
        return view('frontend.menu.minuman', compact('minuman'));
    }

    public function snack()
    {
        $snack = Produk::where('katagori_id', 3)->where('status', 1)->get();
        return view('frontend.menu.snack', compact('snack'));
    }

    public function best()
    {
        $best = Produk::where('katagori_id', 4)->where('status', 1)->get();
        return view('frontend.menu.best', compact('best'));
    }
}   