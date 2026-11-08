<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('payment_status', 'pending_verification')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('backend.orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        return view('backend.orders.show', compact('order'));
    }
    
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        DB::beginTransaction();
        try {
            if ($request->status === 'verified') {
                // 1. Update status order
                $order->update([
                    'payment_status' => 'paid',
                    'payment_verified' => now(),
                    'user_id' => auth()->id()
                ]);

                // 2. Kurangi stok produk
                foreach ($order->items as $item) {
                    Produk::where('id', $item->produk_id)
                        ->decrement('stok', $item->quantity);
                }

                // 3. Catat di tabel transaksi
                Transaksi::create([
                    'kode_transaksi' => 'TRX-' . time() . '-' . $order->id,
                    'tanggal' => now(),
                    'total' => $order->total_amount,
                    'total_item' => $order->items->sum('quantity'),
                    'user_id' => auth()->id(),
                    'items' => $order->items->map(function($item) {
                        return [
                            'produk_id' => $item->produk_id,
                            'nama_produk' => $item->nama_produk,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'subtotal' => $item->price * $item->quantity
                        ];
                    })->toArray()
                ]);
            } else {
                $order->update([
                    'payment_status' => 'rejected',
                    'user_id' => auth()->id()
                ]);
            }

            DB::commit();

            return redirect()->route('backend.orders.index')
                ->with('success', 'Status pembayaran berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    public function verifiedOrders()
{
    $orders = Order::with('items')
        ->where('payment_status', 'paid')
        ->orderBy('created_at', 'desc')
        ->get();
        
    return view('backend.orders.verified', compact('orders'));
}

public function countPendingOrders()
{
    return Order::where('payment_status', 'pending_verification')->count();
}
  
}