<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk; // Tambahkan model Produk
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong');
        }
        
        return view('frontend.keranjang.checkout', compact('cart'));
    }
    
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
    
        // Validasi tambahan
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }
    
        // Validasi semua produk di cart ada di database
        foreach ($cart as $id => $item) {
            if (!Produk::find($id)) {
                return redirect()->back()->with('error', 'Produk tidak valid: ' . $item['name']);
            }
        }
        $request->validate([
            'table_number' => 'required|numeric',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan validasi bukti pembayaran
        ]);
        
        $cart = session()->get('cart');
        $total = 0;
        
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        
        // Upload bukti pembayaran
        $file = $request->file('payment_proof');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Simpan ke storage/app/public/payment_proofs
        $file->storeAs('payment_proofs', $filename, 'public');

        // Copy ke public/storage/payment_proofs
        File::copy(
            storage_path('app/public/payment_proofs/' . $filename),
            public_path('storage/payment_proofs/' . $filename)
        );

        // Simpan path ke database
        $paymentProofPath = 'payment_proofs/' . $filename;

        $order = Order::create([
            'order_number' => 'ORD-' . Str::upper(Str::random(10)),
            'table_number' => $request->table_number,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => 'qris',
            'payment_status' => 'pending_verification', // Ubah status awal
            'qris_reference' => 'QRIS-' . Str::upper(Str::random(10)),
            'payment_proof' => $paymentProofPath, // Simpan path bukti pembayaran
        ]);
        
        foreach($cart as $id => $details) {
            $produk = Produk::find($id);
            
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $id,
                'nama_produk' => $produk->nama_produk,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                // Tambahkan ini untuk konsistensi:
                'harga' => $details['price'],
                'subtotal' => $details['price'] * $details['quantity']
            ]);
            // Untuk transaksi
    $items[] = [
        'produk_id' => $id,
        'nama_produk' => $produk->nama_produk,
        'quantity' => $details['quantity'],
        'harga' => $details['price'],
        'price' => $details['price'], // Untuk kompatibilitas
        'subtotal' => $details['price'] * $details['quantity']
    ];
        }
        
        session()->forget('cart');
        
        return redirect()->route('order.success', $order->order_number); // Arahkan ke halaman sukses
    }
    
    public function orderSuccess($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('frontend.keranjang.order_success', compact('order'));
    }
    
    public function showQRISPayment($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('payment-qris', compact('order'));
    }
    
    public function checkPaymentStatus($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        
        // Di sistem nyata, ini akan dicek dari database setelah kasir memverifikasi
        return response()->json([
            'payment_status' => $order->payment_status
        ]);
    }
}
