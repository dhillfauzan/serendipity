<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\katagori; // Pastikan model Katagori diimport
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
{
    // Ambil semua kategori untuk filter
    $categories = katagori::all();
    $produks = Produk::with('katagori') // Eager load relasi kategori
                ->where('status', '!=', 'Blok')
                ->where('stok', '>', 0)
                ->get();
    
    return view('backend.kasir.index', compact('produks', 'categories'));
}

  public function processTransaction(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.produk_id' => 'required|exists:produk,id',
        'items.*.quantity' => 'required|integer|min:1'
    ]);

    $total = 0;
    $totalItem = 0;
    $items = [];

    \DB::beginTransaction();
    try {
        foreach ($request->items as $item) {
            $produk = Produk::findOrFail($item['produk_id']);
            
            if ($produk->stok < $item['quantity']) {
                return back()->with('error', 'Stok ' . $produk->nama_produk . ' tidak mencukupi');
            }

            $subtotal = $produk->harga * $item['quantity'];
            $total += $subtotal;
            $totalItem += $item['quantity'];

            $items[] = [
                'produk_id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ];

            // Update stok
            $produk->decrement('stok', $item['quantity']);
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => Transaksi::generateCode(),
            'tanggal' => now(),
            'total' => $total,
            'total_item' => $totalItem,
            'user_id' => auth()->id(),
            'items' => $items
        ]);

        \DB::commit();

        return view('backend.kasir.receipt', [
            'items' => $items,
            'total' => $total,
            'transaksi' => $transaksi
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
    }
}

public function getProducts()
{
    $products = Produk::where('status', true)
        ->where('stok', '>', 0)
        ->get(['id', 'stok']);
    
    return response()->json($products);
}
}