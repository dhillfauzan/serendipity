<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);
        
        $cart = session()->get('cart', []);
        
        // Cek apakah produk sudah ada di keranjang
        if(isset($cart[$request->produk_id])) {
            // Jika sudah ada, tambahkan quantity
            $cart[$request->produk_id]['quantity'] += 1;
        } else {
            // Jika belum ada, tambahkan produk baru
            $cart[$request->produk_id] = [
                "name" => $produk->nama_produk,
                "quantity" => 1,
                "price" => $produk->harga,
                "image" => $produk->foto,
                "type" => $produk->kategori
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('frontend.keranjang.cart', compact('cart', 'total'));
    }
    
    public function updateCart(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'quantity' => 'required|numeric|min:1'
        ]);
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$request->produk_id])) {
            $cart[$request->produk_id]['quantity'] = (int)$request->quantity;
            session()->put('cart', $cart);
            
            // Hitung total baru
            $subtotal = $cart[$request->produk_id]['price'] * $cart[$request->produk_id]['quantity'];
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil diperbarui',
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'total' => number_format($total, 0, ',', '.')
            ]);
        }
        
        return response()->json(['success' => false, 'error' => 'Produk tidak ditemukan'], 404);
    }
    
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'produk_id' => 'required'
        ]);
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$request->produk_id])) {
            unset($cart[$request->produk_id]);
            session()->put('cart', $cart);
            
            // Hitung total baru
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang',
                'total' => number_format($total, 0, ',', '.'),
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json(['success' => false, 'error' => 'Produk tidak ditemukan'], 404);
    }
}