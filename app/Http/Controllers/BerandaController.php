<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        $totalProduk = Produk::count();

        $totalTransaksi = Transaksi::count();

        $totalPendapatan = Transaksi::sum('total');

        $latestTransaksi = Transaksi::latest()
            ->take(5)
            ->get();

        // Produk terlaris
        $produkTerlaris = DB::table('order_items')
            ->join('produk', 'order_items.produk_id', '=', 'produk.id')
            ->select(
                'produk.nama_produk',
                DB::raw('SUM(order_items.quantity) as total_qty')
            )
            ->groupBy('produk.nama_produk')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Grafik pendapatan bulanan
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];

        $pendapatanBulanan = [500000, 800000, 650000, 900000, 1200000, 1500000];

        return view('backend.beranda.index', compact(
            'totalProduk',
            'totalTransaksi',
            'totalPendapatan',
            'latestTransaksi',
            'produkTerlaris',
            'bulan',
            'pendapatanBulanan'
        ));
    }
}