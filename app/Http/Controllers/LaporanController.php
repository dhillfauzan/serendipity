<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $transaksis = Transaksi::with('user')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = $transaksis->sum('total');
        $totalTransaksi = $transaksis->count();
        $totalItemTerjual = $transaksis->sum('total_item');

        return view('backend.laporan.index', compact(
            'transaksis',
            'startDate',
            'endDate',
            'totalPendapatan',
            'totalTransaksi',
            'totalItemTerjual'
        ));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);
        return view('backend.laporan.detail', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Kembalikan stok produk
        foreach ($transaksi->items as $item) {
            $produk = Produk::find($item['produk_id']);
            if ($produk) {
                $produk->increment('stok', $item['quantity']);
            }
        }
        
        $transaksi->delete();
        
        return redirect()->route('laporan.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    public function cetak(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $transaksis = Transaksi::with(['user', 'order'])
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->orderBy('tanggal', 'desc')
        ->get()
        ->map(function($transaksi) {
            // Handle both array and object items
            $items = is_array($transaksi->items) ? $transaksi->items : json_decode(json_encode($transaksi->items), true);
            
            $transaksi->formatted_items = array_map(function($item) {
                $harga = $item['harga'] ?? $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
                
                return [
                    'nama_produk' => $item['nama_produk'] ?? $item['name'] ?? 'Produk Tidak Diketahui',
                    'quantity' => $quantity,
                    'harga' => $harga,
                    'subtotal' => $item['subtotal'] ?? ($harga * $quantity)
                ];
            }, $items);

            return $transaksi;
        });

    $totalPendapatan = $transaksis->sum('total');
    $totalTransaksi = $transaksis->count();
    $totalItemTerjual = $transaksis->sum(function($transaksi) {
        return array_sum(array_column($transaksi->formatted_items, 'quantity'));
    });

    return view('backend.laporan.cetak', [
        'transaksis' => $transaksis,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'totalPendapatan' => $totalPendapatan,
        'totalTransaksi' => $totalTransaksi,
        'totalItemTerjual' => $totalItemTerjual
    ]);
}

}