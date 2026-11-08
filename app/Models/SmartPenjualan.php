<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartPenjualan extends Model
{
    use HasFactory;

    protected $table = 'smart_penjualan';
    protected $guarded = ['id'];

    /**
     * Hitung Hasil Ranking SMART untuk Menampilkan Menu Terbaik
     */
    public static function getRankingSmart($kategoriFilter = null)
    {
        $query = self::query();
        if ($kategoriFilter === 'minuman') {
            $query->whereIn('kategori_nama', ['Coffee', 'Tea', 'Mocktail', 'Chocolate']);
        } elseif ($kategoriFilter === 'makanan') {
            $query->where('kategori_nama', 'Makanan');
        } elseif ($kategoriFilter === 'snack') {
            $query->where('kategori_nama', 'Snack');
        }

        $items = $query->get()->toArray();
        if (empty($items)) {
            return [];
        }

        $max_kategori  = max(array_column($items, 'kategori'));
        $min_kategori  = min(array_column($items, 'kategori'));
        $max_penjualan = max(array_column($items, 'penjualan'));
        $min_penjualan = min(array_column($items, 'penjualan'));
        $max_estimasi  = max(array_column($items, 'estimasi'));
        $min_estimasi  = min(array_column($items, 'estimasi'));
        $max_harga     = max(array_column($items, 'harga'));
        $min_harga     = min(array_column($items, 'harga'));

        $bobot = [
            'kategori' => 0.20,
            'harga' => 0.20,
            'penjualan' => 0.35,
            'estimasi' => 0.25,
        ];

        $safeDiv = function ($a, $b) {
            return $b == 0 ? 0 : $a / $b;
        };

        foreach ($items as &$it) {
            $u_kategori = $safeDiv($it['kategori'] - $min_kategori, $max_kategori - $min_kategori);
            $u_penjualan = $safeDiv($it['penjualan'] - $min_penjualan, $max_penjualan - $min_penjualan);
            $u_estimasi = $safeDiv($it['estimasi'] - $min_estimasi, $max_estimasi - $min_estimasi);
            $u_harga = $safeDiv($max_harga - $it['harga'], $max_harga - $min_harga); // Cost

            $it['skor_smart'] = ($bobot['kategori'] * $u_kategori) +
                                ($bobot['harga'] * $u_harga) +
                                ($bobot['penjualan'] * $u_penjualan) +
                                ($bobot['estimasi'] * $u_estimasi);
        }

        usort($items, function ($a, $b) {
            return $b['skor_smart'] <=> $a['skor_smart'];
        });

        return $items;
    }

    /**
     * Konversi Nama Kategori ke Skala Likert (1-4 atau 1-6)
     * 1: Chocolate
     * 2: Mocktail
     * 3: Tea
     * 4: Coffee
     * 5: Snack / Cemilan
     * 6: Makanan
     */
    public static function hitungSkalaKategori($kategoriNama)
    {
        if (is_numeric($kategoriNama) && $kategoriNama >= 1 && $kategoriNama <= 10) {
            return (float) $kategoriNama;
        }

        $kat = strtolower(trim((string)$kategoriNama));
        if (str_contains($kat, 'choc')) return 1;
        if (str_contains($kat, 'mock')) return 2;
        if (str_contains($kat, 'tea') || str_contains($kat, 'teh')) return 3;
        if (str_contains($kat, 'coff') || str_contains($kat, 'kopi')) return 4;
        if (str_contains($kat, 'snack') || str_contains($kat, 'cemil')) return 5;
        if (str_contains($kat, 'makan')) return 6;

        return 1;
    }

    /**
     * Konversi Harga ke Skala Likert (1-5, Cost)
     * 1: Sangat Murah (<= 20.000)
     * 2: Murah (21.000 - 25.000)
     * 3: Sedang (26.000 - 28.000)
     * 4: Mahal (29.000 - 30.000)
     * 5: Sangat Mahal (> 30.000)
     */
    public static function hitungSkalaHarga($harga)
    {
        if (is_numeric($harga) && $harga >= 1 && $harga <= 5) {
            return (float) $harga;
        }

        $clean = (float) preg_replace('/[^0-9.]/', '', (string)$harga);
        if ($clean <= 0) return 1;
        if ($clean <= 20000) return 1;
        if ($clean <= 25000) return 2;
        if ($clean <= 28000) return 3;
        if ($clean <= 30000) return 4;
        return 5;
    }

    /**
     * Konversi Penjualan ke Skala Likert (1-5, Benefit)
     * 1: Sangat Dikit (< 300)
     * 2: Sedikit (300 - 399)
     * 3: Cukup Banyak (400 - 499)
     * 4: Banyak (500 - 599)
     * 5: Sangat Banyak (>= 600)
     */
    public static function hitungSkalaPenjualan($qty)
    {
        if (is_numeric($qty) && $qty >= 1 && $qty <= 5) {
            return (float) $qty;
        }

        $clean = (int) preg_replace('/[^0-9]/', '', (string)$qty);
        if ($clean < 300) return 1;
        if ($clean < 400) return 2;
        if ($clean < 500) return 3;
        if ($clean < 600) return 4;
        return 5;
    }

    /**
     * Konversi Waktu Penyajian ke Skala Likert (1-4, Benefit)
     * Di Excel: 1 = Sangat Lama (>= 6 menit), 2 = Lama (5 menit), 3 = Cepat (4 menit), 4 = Sangat Cepat (<= 3 menit)
     */
    public static function hitungSkalaPenyajian($menit)
    {
        if (is_numeric($menit) && $menit >= 1 && $menit <= 4) {
            return (float) $menit;
        }

        $clean = (int) preg_replace('/[^0-9]/', '', (string)$menit);
        if ($clean <= 3 && $clean > 0) return 4; // Sangat Cepat
        if ($clean == 4) return 3;               // Cepat
        if ($clean == 5) return 2;               // Lama
        return 1;                                // Sangat Lama (>= 6 menit)
    }

    /**
     * Data Penjualan Bawaan dari Excel Serendipity 2025
     */
    public static function dataAwalSerendipity()
    {
        return [
            ['nama' => 'Caramel Macchiato', 'kategori_nama' => 'Coffee', 'harga_asli' => 32000, 'penjualan_asli' => 518, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 16576000, 'kategori' => 4, 'harga' => 5, 'penjualan' => 4, 'estimasi' => 1],
            ['nama' => 'Latte', 'kategori_nama' => 'Coffee', 'harga_asli' => 29000, 'penjualan_asli' => 602, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 17458000, 'kategori' => 4, 'harga' => 4, 'penjualan' => 5, 'estimasi' => 2],
            ['nama' => 'Cappuccino', 'kategori_nama' => 'Coffee', 'harga_asli' => 29000, 'penjualan_asli' => 477, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 13833000, 'kategori' => 4, 'harga' => 4, 'penjualan' => 3, 'estimasi' => 2],
            ['nama' => 'Mochaccino', 'kategori_nama' => 'Coffee', 'harga_asli' => 32000, 'penjualan_asli' => 502, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 16064000, 'kategori' => 4, 'harga' => 5, 'penjualan' => 4, 'estimasi' => 2],
            ['nama' => 'Kopi Susu', 'kategori_nama' => 'Coffee', 'harga_asli' => 25000, 'penjualan_asli' => 628, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 15700000, 'kategori' => 4, 'harga' => 2, 'penjualan' => 5, 'estimasi' => 2],
            ['nama' => 'Americano', 'kategori_nama' => 'Coffee', 'harga_asli' => 25000, 'penjualan_asli' => 426, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 10650000, 'kategori' => 4, 'harga' => 2, 'penjualan' => 3, 'estimasi' => 3],
            ['nama' => 'Long Black', 'kategori_nama' => 'Coffee', 'harga_asli' => 25000, 'penjualan_asli' => 396, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 9900000, 'kategori' => 4, 'harga' => 2, 'penjualan' => 2, 'estimasi' => 3],
            ['nama' => 'Espresso', 'kategori_nama' => 'Coffee', 'harga_asli' => 18000, 'penjualan_asli' => 261, 'penyajian_asli' => '3 Menit', 'laba_penjualan' => 4698000, 'kategori' => 4, 'harga' => 1, 'penjualan' => 1, 'estimasi' => 4],
            ['nama' => 'Avacado Coffee', 'kategori_nama' => 'Coffee', 'harga_asli' => 32000, 'penjualan_asli' => 388, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 12416000, 'kategori' => 4, 'harga' => 5, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Coconut Coffee', 'kategori_nama' => 'Coffee', 'harga_asli' => 32000, 'penjualan_asli' => 403, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 12896000, 'kategori' => 4, 'harga' => 5, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Kopi Tubruk', 'kategori_nama' => 'Coffee', 'harga_asli' => 20000, 'penjualan_asli' => 302, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 6040000, 'kategori' => 4, 'harga' => 1, 'penjualan' => 2, 'estimasi' => 3],
            ['nama' => 'Japanese Iced Coffee', 'kategori_nama' => 'Coffee', 'harga_asli' => 25000, 'penjualan_asli' => 449, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 11225000, 'kategori' => 4, 'harga' => 2, 'penjualan' => 3, 'estimasi' => 2],
            ['nama' => 'Butterscotch Brulee', 'kategori_nama' => 'Coffee', 'harga_asli' => 32000, 'penjualan_asli' => 443, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 14176000, 'kategori' => 4, 'harga' => 5, 'penjualan' => 3, 'estimasi' => 2],
            ['nama' => 'Mojito', 'kategori_nama' => 'Mocktail', 'harga_asli' => 28000, 'penjualan_asli' => 532, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 14896000, 'kategori' => 2, 'harga' => 3, 'penjualan' => 4, 'estimasi' => 2],
            ['nama' => 'Rainbow Citrus', 'kategori_nama' => 'Mocktail', 'harga_asli' => 28000, 'penjualan_asli' => 294, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 8232000, 'kategori' => 2, 'harga' => 3, 'penjualan' => 1, 'estimasi' => 1],
            ['nama' => 'Lemonade', 'kategori_nama' => 'Mocktail', 'harga_asli' => 28000, 'penjualan_asli' => 455, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 12740000, 'kategori' => 2, 'harga' => 3, 'penjualan' => 3, 'estimasi' => 2],
            ['nama' => 'Pinapple Rum', 'kategori_nama' => 'Mocktail', 'harga_asli' => 28000, 'penjualan_asli' => 522, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 14616000, 'kategori' => 2, 'harga' => 3, 'penjualan' => 4, 'estimasi' => 2],
            ['nama' => 'Cotton Candy', 'kategori_nama' => 'Mocktail', 'harga_asli' => 28000, 'penjualan_asli' => 362, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 10136000, 'kategori' => 2, 'harga' => 3, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Passion Berry', 'kategori_nama' => 'Mocktail', 'harga_asli' => 28000, 'penjualan_asli' => 472, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 13216000, 'kategori' => 2, 'harga' => 3, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Thai Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 621, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 15525000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 5, 'estimasi' => 2],
            ['nama' => 'Green Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 553, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 13825000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 4, 'estimasi' => 2],
            ['nama' => 'Lychee Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 604, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 15100000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 5, 'estimasi' => 3],
            ['nama' => 'Lemon Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 373, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 9325000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 2, 'estimasi' => 3],
            ['nama' => 'Strawberry Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 502, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 12550000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 4, 'estimasi' => 3],
            ['nama' => 'Peach Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 469, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 11725000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 3, 'estimasi' => 3],
            ['nama' => 'Jasmine Tea', 'kategori_nama' => 'Tea', 'harga_asli' => 25000, 'penjualan_asli' => 296, 'penyajian_asli' => '4 Menit', 'laba_penjualan' => 7400000, 'kategori' => 3, 'harga' => 2, 'penjualan' => 1, 'estimasi' => 3],
            ['nama' => 'Chocolate Drink', 'kategori_nama' => 'Chocolate', 'harga_asli' => 28000, 'penjualan_asli' => 516, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 14448000, 'kategori' => 1, 'harga' => 3, 'penjualan' => 4, 'estimasi' => 1],
            ['nama' => 'Chocolove', 'kategori_nama' => 'Chocolate', 'harga_asli' => 28000, 'penjualan_asli' => 416, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 11648000, 'kategori' => 1, 'harga' => 3, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Beef Bolognese', 'kategori_nama' => 'Makanan', 'harga_asli' => 45000, 'penjualan_asli' => 342, 'penyajian_asli' => '10 Menit', 'laba_penjualan' => 15390000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Aglio Olio', 'kategori_nama' => 'Makanan', 'harga_asli' => 45000, 'penjualan_asli' => 354, 'penyajian_asli' => '9 Menit', 'laba_penjualan' => 15930000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Chicken Carbonara', 'kategori_nama' => 'Makanan', 'harga_asli' => 45000, 'penjualan_asli' => 367, 'penyajian_asli' => '10 Menit', 'laba_penjualan' => 16515000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Fish & Chips', 'kategori_nama' => 'Makanan', 'harga_asli' => 45000, 'penjualan_asli' => 354, 'penyajian_asli' => '9 Menit', 'laba_penjualan' => 15930000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Burger Steak', 'kategori_nama' => 'Makanan', 'harga_asli' => 55000, 'penjualan_asli' => 290, 'penyajian_asli' => '12 Menit', 'laba_penjualan' => 15950000, 'kategori' => 5, 'harga' => 5, 'penjualan' => 1, 'estimasi' => 1],
            ['nama' => 'Chilli Cheese Fries', 'kategori_nama' => 'Makanan', 'harga_asli' => 40000, 'penjualan_asli' => 414, 'penyajian_asli' => '8 Menit', 'laba_penjualan' => 16560000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Wing Rice', 'kategori_nama' => 'Makanan', 'harga_asli' => 40000, 'penjualan_asli' => 422, 'penyajian_asli' => '8 Menit', 'laba_penjualan' => 16880000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Beef Rice', 'kategori_nama' => 'Makanan', 'harga_asli' => 40000, 'penjualan_asli' => 436, 'penyajian_asli' => '8 Menit', 'laba_penjualan' => 17440000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Chicken Teriyaki', 'kategori_nama' => 'Makanan', 'harga_asli' => 55000, 'penjualan_asli' => 332, 'penyajian_asli' => '11 Menit', 'laba_penjualan' => 18260000, 'kategori' => 5, 'harga' => 5, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Prawn Rice', 'kategori_nama' => 'Makanan', 'harga_asli' => 40000, 'penjualan_asli' => 371, 'penyajian_asli' => '8 Menit', 'laba_penjualan' => 14840000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 2, 'estimasi' => 1],
            ['nama' => 'Nasi Goreng', 'kategori_nama' => 'Makanan', 'harga_asli' => 30000, 'penjualan_asli' => 572, 'penyajian_asli' => '8 Menit', 'laba_penjualan' => 17160000, 'kategori' => 5, 'harga' => 4, 'penjualan' => 4, 'estimasi' => 1],
            ['nama' => 'Tomyam Soup', 'kategori_nama' => 'Makanan', 'harga_asli' => 70000, 'penjualan_asli' => 243, 'penyajian_asli' => '12 Menit', 'laba_penjualan' => 17010000, 'kategori' => 5, 'harga' => 5, 'penjualan' => 1, 'estimasi' => 1],
            ['nama' => 'Japanese Curry Rice', 'kategori_nama' => 'Makanan', 'harga_asli' => 65000, 'penjualan_asli' => 266, 'penyajian_asli' => '11 Menit', 'laba_penjualan' => 17290000, 'kategori' => 5, 'harga' => 5, 'penjualan' => 1, 'estimasi' => 1],
            ['nama' => 'Chicken Wings', 'kategori_nama' => 'Snack', 'harga_asli' => 45000, 'penjualan_asli' => 478, 'penyajian_asli' => '9 Menit', 'laba_penjualan' => 21510000, 'kategori' => 6, 'harga' => 4, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Cireng', 'kategori_nama' => 'Snack', 'harga_asli' => 25000, 'penjualan_asli' => 635, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 15875000, 'kategori' => 6, 'harga' => 2, 'penjualan' => 5, 'estimasi' => 1],
            ['nama' => 'French Fries', 'kategori_nama' => 'Snack', 'harga_asli' => 25000, 'penjualan_asli' => 607, 'penyajian_asli' => '5 Menit', 'laba_penjualan' => 15175000, 'kategori' => 6, 'harga' => 2, 'penjualan' => 5, 'estimasi' => 2],
            ['nama' => 'Singkong Keju', 'kategori_nama' => 'Snack', 'harga_asli' => 25000, 'penjualan_asli' => 563, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 14075000, 'kategori' => 6, 'harga' => 2, 'penjualan' => 4, 'estimasi' => 1],
            ['nama' => 'Siomay', 'kategori_nama' => 'Snack', 'harga_asli' => 35000, 'penjualan_asli' => 468, 'penyajian_asli' => '7 Menit', 'laba_penjualan' => 16380000, 'kategori' => 6, 'harga' => 5, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Pempek', 'kategori_nama' => 'Snack', 'harga_asli' => 40000, 'penjualan_asli' => 422, 'penyajian_asli' => '8 Menit', 'laba_penjualan' => 16880000, 'kategori' => 6, 'harga' => 5, 'penjualan' => 3, 'estimasi' => 1],
            ['nama' => 'Dimsum', 'kategori_nama' => 'Snack', 'harga_asli' => 25000, 'penjualan_asli' => 616, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 15400000, 'kategori' => 6, 'harga' => 2, 'penjualan' => 5, 'estimasi' => 1],
            ['nama' => 'Roti Bakar', 'kategori_nama' => 'Snack', 'harga_asli' => 25000, 'penjualan_asli' => 591, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 14775000, 'kategori' => 6, 'harga' => 2, 'penjualan' => 4, 'estimasi' => 1],
            ['nama' => 'Risoles', 'kategori_nama' => 'Snack', 'harga_asli' => 30000, 'penjualan_asli' => 503, 'penyajian_asli' => '6 Menit', 'laba_penjualan' => 15090000, 'kategori' => 6, 'harga' => 4, 'penjualan' => 4, 'estimasi' => 1],
        ];
    }
}

