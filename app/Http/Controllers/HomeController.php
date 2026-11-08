<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\SmartPenjualan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilan Beranda Pemesanan Cafe & Resto Serendipity
     */
    public function index()
    {
        // 1. Ambil seluruh produk aktif
        $allProduk = Produk::where('status', 1)->get();
        $makanan   = Produk::where('katagori_id', 1)->where('status', 1)->get();
        $minuman   = Produk::where('katagori_id', 2)->where('status', 1)->get();
        $snack     = Produk::where('katagori_id', 3)->where('status', 1)->get();
        $best      = Produk::where('katagori_id', 4)->where('status', 1)->get();

        // 2. Ambil ranking SMART dari database
        $smartRanking = SmartPenjualan::getRankingSmart();

        // 3. Petakan nama produk ke ranking SMART
        $smartMap = [];
        foreach ($smartRanking as $rankIdx => $smartItem) {
            $key = strtolower(preg_replace('/[^a-z0-9]/', '', $smartItem['nama']));
            $smartMap[$key] = [
                'rank' => $rankIdx + 1,
                'skor' => $smartItem['skor_smart'],
                'penjualan_asli' => $smartItem['penjualan_asli'] ?? null,
                'kategori_nama' => $smartItem['kategori_nama'] ?? null,
            ];
        }

        // Pasangkan atribut SMART ke setiap objek produk
        foreach ($allProduk as $prod) {
            $key = strtolower(preg_replace('/[^a-z0-9]/', '', $prod->nama_produk));
            if (isset($smartMap[$key])) {
                $prod->smart_rank = $smartMap[$key]['rank'];
                $prod->smart_skor = $smartMap[$key]['skor'];
                $prod->smart_penjualan = $smartMap[$key]['penjualan_asli'];
            } else {
                $prod->smart_rank = 999;
                $prod->smart_skor = 0;
            }
        }

        // 4. Menu Terbaik SPK SMART (Urutkan berdasarkan ranking SMART)
        $menuTerbaikSmart = $allProduk->filter(function ($p) {
            return $p->katagori_id == 4 || $p->smart_rank <= 6;
        })->sortBy('smart_rank')->values();

        if ($menuTerbaikSmart->isEmpty()) {
            $menuTerbaikSmart = $best;
        }

        return view('frontend.beranda.index', compact(
            'allProduk',
            'makanan',
            'minuman',
            'snack',
            'best',
            'menuTerbaikSmart',
            'smartRanking'
        ));
    }
}
