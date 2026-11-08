<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmartPenjualan;
use Illuminate\Support\Facades\Response;

class SmartController extends Controller
{
    private function safeDivide($a, $b)
    {
        return $b == 0 ? 0 : $a / $b;
    }

    public function menu()
    {
        return view('backend.smart.menu');
    }

    // ================= STEP 1: KRITERIA =================
    public function kriteria(Request $request)
    {
        // Auto-seed data Serendipity 2025 jika tabel masih kosong
        if (SmartPenjualan::count() === 0) {
            foreach (SmartPenjualan::dataAwalSerendipity() as $i => $item) {
                $item['kode_alternatif'] = 'A' . ($i + 1);
                SmartPenjualan::create($item);
            }
        }

        $filterKategori = $request->query('kategori', 'all');

        $query = SmartPenjualan::query();

        if ($filterKategori === 'minuman') {
            $query->whereIn('kategori_nama', ['Coffee', 'Tea', 'Mocktail', 'Chocolate']);
        } elseif ($filterKategori === 'makanan') {
            $query->where('kategori_nama', 'Makanan');
        } elseif ($filterKategori === 'snack') {
            $query->where('kategori_nama', 'Snack');
        } elseif ($filterKategori !== 'all' && !empty($filterKategori)) {
            $query->where('kategori_nama', $filterKategori);
        }

        $dataPenjualan = $query->orderBy('id', 'asc')->get();

        $kategoriList = SmartPenjualan::select('kategori_nama')->distinct()->pluck('kategori_nama')->filter();

        // Data statistik dari Laporan Kasir
        $kasirStats = [
            'total_transaksi' => \App\Models\Transaksi::count(),
            'total_pendapatan' => \App\Models\Transaksi::sum('total'),
            'total_item' => \App\Models\Transaksi::sum('total_item'),
        ];

        return view('backend.smart.kriteria', compact('dataPenjualan', 'filterKategori', 'kategoriList', 'kasirStats'));
    }

    // SIMPAN 1 DATA MANUAL KE DATABASE
    public function storeManual(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'kategori' => 'required',
            'harga' => 'required',
            'penjualan' => 'required',
            'estimasi' => 'required',
        ]);

        $nextNum = SmartPenjualan::count() + 1;

        $penjualan = SmartPenjualan::create([
            'kode_alternatif' => 'A' . $nextNum,
            'nama' => $request->nama,
            'kategori_nama' => $request->kategori_nama ?: 'Umum',
            'kategori' => (float) $request->kategori,
            'harga_asli' => $request->harga_asli ?: null,
            'harga' => (float) $request->harga,
            'penjualan_asli' => $request->penjualan_asli ?: null,
            'penjualan' => (float) $request->penjualan,
            'penyajian_asli' => $request->penyajian_asli ?: null,
            'estimasi' => (float) $request->estimasi,
            'laba_penjualan' => $request->laba_penjualan ?: null,
            'tahun' => $request->tahun ?: '2025',
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $penjualan]);
        }

        return redirect()->route('smart.kriteria')->with('success', 'Data produk berhasil ditambahkan ke database!');
    }

    // UPDATE DATA MANUAL DI DATABASE
    public function updateManual(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'kategori' => 'required',
            'harga' => 'required',
            'penjualan' => 'required',
            'estimasi' => 'required',
        ]);

        $penjualan = SmartPenjualan::findOrFail($id);
        $penjualan->update([
            'nama' => $request->nama,
            'kategori_nama' => $request->kategori_nama ?: $penjualan->kategori_nama,
            'kategori' => (float) $request->kategori,
            'harga_asli' => $request->harga_asli ?: $penjualan->harga_asli,
            'harga' => (float) $request->harga,
            'penjualan_asli' => $request->penjualan_asli ?: $penjualan->penjualan_asli,
            'penjualan' => (float) $request->penjualan,
            'penyajian_asli' => $request->penyajian_asli ?: $penjualan->penyajian_asli,
            'estimasi' => (float) $request->estimasi,
            'laba_penjualan' => $request->laba_penjualan ?: $penjualan->laba_penjualan,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $penjualan]);
        }

        return redirect()->route('smart.kriteria')->with('success', 'Data produk berhasil diperbarui di database!');
    }

    // HAPUS 1 DATA DARI DATABASE
    public function destroyManual($id)
    {
        $penjualan = SmartPenjualan::findOrFail($id);
        $penjualan->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('smart.kriteria')->with('success', 'Data berhasil dihapus dari database!');
    }

    // IMPORT EXCEL / CSV / JSON KE DATABASE
    public function importExcel(Request $request)
    {
        $mode = $request->input('mode', 'replace'); // 'replace' atau 'append'
        $items = [];

        // 1. Data dikirim dalam bentuk JSON (dari parsing frontend SheetJS)
        if ($request->has('data_json') && !empty($request->data_json)) {
            $parsed = json_decode($request->data_json, true);
            if (is_array($parsed)) {
                $items = $parsed;
            }
        }
        // 2. Data dikirim dalam file CSV
        elseif ($request->hasFile('file_excel')) {
            $file = $request->file('file_excel');
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, ['csv', 'txt'])) {
                $handle = fopen($file->getRealPath(), 'r');
                $header = null;
                while (($row = fgetcsv($handle, 10000, ',')) !== false) {
                    if (count($row) === 1 && str_contains($row[0], ';')) {
                        $row = explode(';', $row[0]);
                    }
                    if (!$header) {
                        $rowLower = array_map(function ($c) {
                            return strtolower(trim((string)$c));
                        }, $row);
                        if (in_array('menu', $rowLower) || in_array('nama', $rowLower) || in_array('kategori', $rowLower)) {
                            $header = $rowLower;
                        }
                        continue;
                    }

                    if (empty(array_filter($row))) continue;

                    $assoc = [];
                    foreach ($header as $idx => $colName) {
                        $assoc[$colName] = $row[$idx] ?? '';
                    }

                    $nama = $assoc['menu'] ?? $assoc['nama'] ?? ($row[1] ?? 'Menu');
                    $kategori = $assoc['kategori'] ?? ($row[2] ?? '');
                    $harga = $assoc['harga'] ?? ($row[3] ?? 0);
                    $penjualan = $assoc['penjualan'] ?? ($row[4] ?? 0);
                    $penyajian = $assoc['penyajian'] ?? $assoc['waktu penyajian'] ?? $assoc['estimasi'] ?? ($row[5] ?? '');
                    $laba = $assoc['laba penjualan'] ?? $assoc['laba'] ?? ($row[6] ?? 0);

                    $items[] = [
                        'nama' => $nama,
                        'kategori_nama' => $kategori,
                        'harga_asli' => (float) preg_replace('/[^0-9.]/', '', (string)$harga),
                        'penjualan_asli' => (int) preg_replace('/[^0-9]/', '', (string)$penjualan),
                        'penyajian_asli' => (string) $penyajian,
                        'laba_penjualan' => (float) preg_replace('/[^0-9.]/', '', (string)$laba),
                        'kategori' => SmartPenjualan::hitungSkalaKategori($kategori),
                        'harga' => SmartPenjualan::hitungSkalaHarga($harga),
                        'penjualan' => SmartPenjualan::hitungSkalaPenjualan($penjualan),
                        'estimasi' => SmartPenjualan::hitungSkalaPenyajian($penyajian),
                    ];
                }
                fclose($handle);
            }
        }

        if (empty($items)) {
            return redirect()->back()->with('error', 'Gagal memproses data Excel/CSV! Pastikan format file sesuai.');
        }

        if ($mode === 'replace') {
            SmartPenjualan::truncate();
        }

        $existingCount = SmartPenjualan::count();
        foreach ($items as $idx => $it) {
            $nama = trim($it['nama'] ?? '');
            if (empty($nama)) continue;

            $kategoriNama = $it['kategori_nama'] ?? ($it['kategori'] ?? 'Umum');
            $hargaRaw = $it['harga_asli'] ?? ($it['harga'] ?? 0);
            $penjualanRaw = $it['penjualan_asli'] ?? ($it['penjualan'] ?? 0);
            $penyajianRaw = $it['penyajian_asli'] ?? ($it['penyajian'] ?? ($it['estimasi'] ?? ''));

            $kategoriScore = isset($it['kategori']) && is_numeric($it['kategori']) ? (float)$it['kategori'] : SmartPenjualan::hitungSkalaKategori($kategoriNama);
            $hargaScore = isset($it['harga']) && is_numeric($it['harga']) && $it['harga'] <= 5 ? (float)$it['harga'] : SmartPenjualan::hitungSkalaHarga($hargaRaw);
            $penjualanScore = isset($it['penjualan']) && is_numeric($it['penjualan']) && $it['penjualan'] <= 5 ? (float)$it['penjualan'] : SmartPenjualan::hitungSkalaPenjualan($penjualanRaw);
            $estimasiScore = isset($it['estimasi']) && is_numeric($it['estimasi']) && $it['estimasi'] <= 4 ? (float)$it['estimasi'] : SmartPenjualan::hitungSkalaPenyajian($penyajianRaw);

            SmartPenjualan::create([
                'kode_alternatif' => 'A' . ($existingCount + $idx + 1),
                'nama' => $nama,
                'kategori_nama' => $kategoriNama,
                'kategori' => $kategoriScore,
                'harga_asli' => (float) preg_replace('/[^0-9.]/', '', (string)$hargaRaw),
                'harga' => $hargaScore,
                'penjualan_asli' => (int) preg_replace('/[^0-9]/', '', (string)$penjualanRaw),
                'penjualan' => $penjualanScore,
                'penyajian_asli' => (string)$penyajianRaw,
                'estimasi' => $estimasiScore,
                'laba_penjualan' => isset($it['laba_penjualan']) ? (float) preg_replace('/[^0-9.]/', '', (string)$it['laba_penjualan']) : null,
                'tahun' => $it['tahun'] ?? '2025',
            ]);
        }

        return redirect()->route('smart.kriteria')->with('success', count($items) . ' Data penjualan berhasil diimport dan disimpan ke database!');
    }

    // ================= TARIK / SINKRON DATA DARI LAPORAN KASIR =================
    public function importKasir(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $mode = $request->input('mode', 'replace'); // 'replace' atau 'append'
        $includeOrders = $request->boolean('include_orders', false);

        // 1. Ambil data transaksi kasir
        $query = \App\Models\Transaksi::query();
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif (!empty($startDate)) {
            $query->where('tanggal', '>=', $startDate . ' 00:00:00');
        } elseif (!empty($endDate)) {
            $query->where('tanggal', '<=', $endDate . ' 23:59:59');
        }

        $transaksis = $query->get();
        $aggregated = [];

        foreach ($transaksis as $trx) {
            $items = is_array($trx->items) ? $trx->items : json_decode(json_encode($trx->items), true);
            if (!$items) continue;

            foreach ($items as $item) {
                $nama = trim($item['nama_produk'] ?? $item['name'] ?? '');
                if (empty($nama)) continue;

                $qty = (int)($item['quantity'] ?? $item['qty'] ?? 1);
                $subtotal = (float)($item['subtotal'] ?? 0);
                $price = (float)($item['harga'] ?? $item['price'] ?? 0);
                $prodId = $item['produk_id'] ?? null;

                if (!isset($aggregated[$nama])) {
                    $aggregated[$nama] = [
                        'nama' => $nama,
                        'produk_id' => $prodId,
                        'harga' => $price,
                        'penjualan_asli' => 0,
                        'laba_penjualan' => 0,
                    ];
                }

                $aggregated[$nama]['penjualan_asli'] += $qty;
                $aggregated[$nama]['laba_penjualan'] += ($subtotal > 0 ? $subtotal : ($price * $qty));
                if ($price > 0 && $aggregated[$nama]['harga'] == 0) {
                    $aggregated[$nama]['harga'] = $price;
                }
            }
        }

        // 2. Opsional: Sertakan juga pesanan online (Order) jika dicentang
        if ($includeOrders) {
            $orderQuery = \App\Models\Order::with('items.produk')->where('status', '!=', 'cancelled');
            if (!empty($startDate) && !empty($endDate)) {
                $orderQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }
            $orders = $orderQuery->get();
            foreach ($orders as $ord) {
                foreach ($ord->items as $it) {
                    $nama = $it->produk ? $it->produk->nama_produk : 'Menu Online';
                    $qty = (int)$it->quantity;
                    $price = (float)$it->price;
                    $subtotal = $price * $qty;
                    $prodId = $it->produk_id;

                    if (!isset($aggregated[$nama])) {
                        $aggregated[$nama] = [
                            'nama' => $nama,
                            'produk_id' => $prodId,
                            'harga' => $price,
                            'penjualan_asli' => 0,
                            'laba_penjualan' => 0,
                        ];
                    }

                    $aggregated[$nama]['penjualan_asli'] += $qty;
                    $aggregated[$nama]['laba_penjualan'] += $subtotal;
                }
            }
        }

        if (empty($aggregated)) {
            return redirect()->back()->with('error', 'Tidak ditemukan data penjualan kasir pada rentang waktu yang dipilih!');
        }

        // Hitung max & min penjualan untuk penskalaan dinamis
        $allQtys = array_column($aggregated, 'penjualan_asli');
        $maxQty = max($allQtys);
        $minQty = min($allQtys);

        // Ambil master produk untuk melengkapi info kategori
        $allProduks = \App\Models\Produk::with('katagori')->get()->keyBy('id');
        $allProduksByName = [];
        foreach ($allProduks as $p) {
            $allProduksByName[strtolower(trim($p->nama_produk))] = $p;
        }

        $itemsToSave = [];
        foreach ($aggregated as $nama => $data) {
            $prod = null;
            if ($data['produk_id'] && isset($allProduks[$data['produk_id']])) {
                $prod = $allProduks[$data['produk_id']];
            } else {
                $lower = strtolower($nama);
                if (isset($allProduksByName[$lower])) {
                    $prod = $allProduksByName[$lower];
                }
            }

            // Tentukan Kategori & Skala
            $kategoriNama = 'Umum';
            $lowerNama = strtolower($nama);

            if ($prod && $prod->katagori) {
                $katRaw = $prod->katagori->nama_katagori;
                if ($katRaw === 'Terbaik' || $katRaw === 'Umum') {
                    if (str_contains($lowerNama, 'kopi') || str_contains($lowerNama, 'coffee') || str_contains($lowerNama, 'espresso')) {
                        $kategoriNama = 'Coffee';
                    } elseif (str_contains($lowerNama, 'tea') || str_contains($lowerNama, 'teh')) {
                        $kategoriNama = 'Tea';
                    } elseif (str_contains($lowerNama, 'mocktail') || str_contains($lowerNama, 'rum') || str_contains($lowerNama, 'mojito') || str_contains($lowerNama, 'berry')) {
                        $kategoriNama = 'Mocktail';
                    } elseif (str_contains($lowerNama, 'choc') || str_contains($lowerNama, 'cokelat')) {
                        $kategoriNama = 'Chocolate';
                    } else {
                        $kategoriNama = 'Minuman';
                    }
                } else {
                    $kategoriNama = $katRaw;
                }
            } else {
                if (str_contains($lowerNama, 'kopi') || str_contains($lowerNama, 'coffee') || str_contains($lowerNama, 'espresso') || str_contains($lowerNama, 'latte')) {
                    $kategoriNama = 'Coffee';
                } elseif (str_contains($lowerNama, 'tea') || str_contains($lowerNama, 'teh')) {
                    $kategoriNama = 'Tea';
                } elseif (str_contains($lowerNama, 'mocktail') || str_contains($lowerNama, 'rum') || str_contains($lowerNama, 'mojito') || str_contains($lowerNama, 'berry')) {
                    $kategoriNama = 'Mocktail';
                } elseif (str_contains($lowerNama, 'choc') || str_contains($lowerNama, 'cokelat')) {
                    $kategoriNama = 'Chocolate';
                } elseif (str_contains($lowerNama, 'ayam') || str_contains($lowerNama, 'beef') || str_contains($lowerNama, 'burger') || str_contains($lowerNama, 'pasta') || str_contains($lowerNama, 'nasi') || str_contains($lowerNama, 'steak') || str_contains($lowerNama, 'bolognese') || str_contains($lowerNama, 'carbonara') || str_contains($lowerNama, 'fish')) {
                    $kategoriNama = 'Makanan';
                } elseif (str_contains($lowerNama, 'fries') || str_contains($lowerNama, 'roti') || str_contains($lowerNama, 'cireng') || str_contains($lowerNama, 'wings') || str_contains($lowerNama, 'snack') || str_contains($lowerNama, 'dimsum')) {
                    $kategoriNama = 'Snack';
                }
            }

            $kategoriSkala = SmartPenjualan::hitungSkalaKategori($kategoriNama);

            // Harga Asli & Skala Harga (Cost)
            $hargaAsli = $data['harga'] > 0 ? $data['harga'] : ($prod ? (float)$prod->harga : 25000);
            $hargaSkala = SmartPenjualan::hitungSkalaHarga($hargaAsli);

            // Penjualan Asli & Skala Penjualan (Benefit)
            $penjualanAsli = $data['penjualan_asli'];
            if ($maxQty <= 100) {
                // Skala proporsional 1 - 5 untuk data kasir
                if ($maxQty == $minQty) {
                    $penjualanSkala = 3;
                } else {
                    $step = ($maxQty - $minQty) / 4;
                    if ($penjualanAsli >= $minQty + (3 * $step)) {
                        $penjualanSkala = 5;
                    } elseif ($penjualanAsli >= $minQty + (2 * $step)) {
                        $penjualanSkala = 4;
                    } elseif ($penjualanAsli >= $minQty + (1 * $step)) {
                        $penjualanSkala = 3;
                    } elseif ($penjualanAsli > $minQty) {
                        $penjualanSkala = 2;
                    } else {
                        $penjualanSkala = 1;
                    }
                }
            } else {
                $penjualanSkala = SmartPenjualan::hitungSkalaPenjualan($penjualanAsli);
            }

            // Waktu Penyajian Asli & Skala Estimasi (Benefit)
            $lowerKat = strtolower($kategoriNama);
            if ($lowerKat === 'coffee' || str_contains($lowerKat, 'kopi')) {
                $penyajianAsli = '4 Menit';
                $estimasiSkala = 3;
            } elseif ($lowerKat === 'tea' || str_contains($lowerKat, 'teh')) {
                $penyajianAsli = '3 Menit';
                $estimasiSkala = 4;
            } elseif ($lowerKat === 'makanan') {
                $penyajianAsli = '7 Menit';
                $estimasiSkala = 1;
            } elseif ($lowerKat === 'snack' || $lowerKat === 'cemilan') {
                $penyajianAsli = '5 Menit';
                $estimasiSkala = 2;
            } else {
                $penyajianAsli = '5 Menit';
                $estimasiSkala = 2;
            }

            $itemsToSave[] = [
                'nama' => $nama,
                'kategori_nama' => $kategoriNama,
                'kategori' => $kategoriSkala,
                'harga_asli' => $hargaAsli,
                'harga' => $hargaSkala,
                'penjualan_asli' => $penjualanAsli,
                'penjualan' => $penjualanSkala,
                'penyajian_asli' => $penyajianAsli,
                'estimasi' => $estimasiSkala,
                'laba_penjualan' => $data['laba_penjualan'],
                'tahun' => date('Y'),
            ];
        }

        // Urutkan dari penjualan terbanyak
        usort($itemsToSave, function($a, $b) {
            return $b['penjualan_asli'] <=> $a['penjualan_asli'];
        });

        // Simpan ke Database
        if ($mode === 'replace') {
            SmartPenjualan::truncate();
            foreach ($itemsToSave as $i => $it) {
                $it['kode_alternatif'] = 'A' . ($i + 1);
                SmartPenjualan::create($it);
            }
        } else {
            // Mode Append / Merge
            $startNum = SmartPenjualan::count();
            foreach ($itemsToSave as $it) {
                $existing = SmartPenjualan::where('nama', $it['nama'])->first();
                if ($existing) {
                    $existing->update([
                        'kategori_nama' => $it['kategori_nama'],
                        'kategori' => $it['kategori'],
                        'harga_asli' => $it['harga_asli'],
                        'harga' => $it['harga'],
                        'penjualan_asli' => $it['penjualan_asli'],
                        'penjualan' => $it['penjualan'],
                        'penyajian_asli' => $it['penyajian_asli'],
                        'estimasi' => $it['estimasi'],
                        'laba_penjualan' => $it['laba_penjualan'],
                    ]);
                } else {
                    $startNum++;
                    $it['kode_alternatif'] = 'A' . $startNum;
                    SmartPenjualan::create($it);
                }
            }
        }

        return redirect()->route('smart.kriteria')->with('success', 'Berhasil mengambil data dari Laporan Kasir! ' . count($itemsToSave) . ' menu yang dipesan telah disinkronkan ke dalam SPK SMART.');
    }

    // ================= PREVIEW DATA KASIR VIA AJAX =================
    public function previewKasir(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = \App\Models\Transaksi::query();
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif (!empty($startDate)) {
            $query->where('tanggal', '>=', $startDate . ' 00:00:00');
        } elseif (!empty($endDate)) {
            $query->where('tanggal', '<=', $endDate . ' 23:59:59');
        }

        $transaksis = $query->get();
        $aggregated = [];
        $totalQty = 0;
        $totalOmset = 0;

        foreach ($transaksis as $trx) {
            $items = is_array($trx->items) ? $trx->items : json_decode(json_encode($trx->items), true);
            if (!$items) continue;

            foreach ($items as $item) {
                $nama = trim($item['nama_produk'] ?? $item['name'] ?? '');
                if (empty($nama)) continue;

                $qty = (int)($item['quantity'] ?? $item['qty'] ?? 1);
                $subtotal = (float)($item['subtotal'] ?? 0);
                $price = (float)($item['harga'] ?? $item['price'] ?? 0);

                if (!isset($aggregated[$nama])) {
                    $aggregated[$nama] = [
                        'nama' => $nama,
                        'qty' => 0,
                        'subtotal' => 0,
                        'harga' => $price,
                    ];
                }

                $aggregated[$nama]['qty'] += $qty;
                $lineSubtotal = $subtotal > 0 ? $subtotal : ($price * $qty);
                $aggregated[$nama]['subtotal'] += $lineSubtotal;
                $totalQty += $qty;
                $totalOmset += $lineSubtotal;
            }
        }

        uasort($aggregated, function($a, $b) {
            return $b['qty'] <=> $a['qty'];
        });

        return response()->json([
            'total_transaksi' => $transaksis->count(),
            'total_menu' => count($aggregated),
            'total_qty' => $totalQty,
            'total_omset' => $totalOmset,
            'top_menus' => array_slice(array_values($aggregated), 0, 10),
        ]);
    }

    // RESET ATAU MUAT DATA DEFAULT 2025
    public function resetData(Request $request)
    {
        $action = $request->input('action', 'default');

        SmartPenjualan::truncate();

        if ($action === 'default') {
            foreach (SmartPenjualan::dataAwalSerendipity() as $i => $item) {
                $item['kode_alternatif'] = 'A' . ($i + 1);
                SmartPenjualan::create($item);
            }
            return redirect()->route('smart.kriteria')->with('success', 'Data berhasil direset ke data penjualan default Serendipity 2025 (50 Menu)!');
        }

        return redirect()->route('smart.kriteria')->with('success', 'Semua data di database berhasil dikosongkan!');
    }

    // DOWNLOAD TEMPLATE EXCEL / CSV
    public function exportTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_data_penjualan_smart.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Menu', 'Kategori', 'Harga', 'Penjualan', 'Penyajian', 'Laba Penjualan']);
            fputcsv($file, [1, 'Caramel Macchiato', 'Coffee', 32000, 518, '6 Menit', 16576000]);
            fputcsv($file, [2, 'Latte', 'Coffee', 29000, 602, '5 Menit', 17458000]);
            fputcsv($file, [3, 'Thai Tea', 'Tea', 25000, 621, '5 Menit', 15525000]);
            fputcsv($file, [4, 'Mojito', 'Mocktail', 28000, 532, '5 Menit', 14896000]);
            fputcsv($file, [5, 'Chocolate Drink', 'Chocolate', 28000, 516, '6 Menit', 14448000]);
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function storeKriteria(Request $request)
    {
        $produk = $request->produk;

        if (empty($produk) || !is_array($produk)) {
            return redirect()->route('smart.kriteria')->with('error', 'Tidak ada data produk yang dipilih untuk perhitungan SMART!');
        }

        session(['data_smart' => array_values($produk)]);
        return redirect()->route('smart.bobot');
    }

    // ================= STEP 2: BOBOT =================
    public function bobot()
    {
        return view('backend.smart.bobot');
    }

    public function storeBobot(Request $request)
    {
        session(['bobot_smart' => $request->bobot]);
        return redirect()->route('smart.perhitungan');
    }

    // ================= STEP 3: PERHITUNGAN =================
    public function perhitungan()
    {
        $data = session('data_smart');
        $bobot = session('bobot_smart');

        // VALIDASI
        if (!$data || !$bobot) {
            return redirect()->route('smart.kriteria')
                ->with('error', 'Data atau bobot belum diisi!');
        }

        // ================= MAX & MIN =================
        $max_kategori  = max(array_column($data, 'kategori'));
        $min_kategori  = min(array_column($data, 'kategori'));

        $max_penjualan = max(array_column($data, 'penjualan'));
        $min_penjualan = min(array_column($data, 'penjualan'));

        $max_estimasi  = max(array_column($data, 'estimasi'));
        $min_estimasi  = min(array_column($data, 'estimasi'));

        $max_harga     = max(array_column($data, 'harga'));
        $min_harga     = min(array_column($data, 'harga'));

        $minMax = [
            'kategori'  => ['min' => $min_kategori, 'max' => $max_kategori, 'tipe' => 'Benefit', 'bobot' => $bobot['kategori'] ?? 0.2],
            'harga'     => ['min' => $min_harga, 'max' => $max_harga, 'tipe' => 'Cost', 'bobot' => $bobot['harga'] ?? 0.2],
            'penjualan' => ['min' => $min_penjualan, 'max' => $max_penjualan, 'tipe' => 'Benefit', 'bobot' => $bobot['penjualan'] ?? 0.35],
            'estimasi'  => ['min' => $min_estimasi, 'max' => $max_estimasi, 'tipe' => 'Benefit', 'bobot' => $bobot['estimasi'] ?? 0.25],
        ];

        foreach ($data as $idx => &$item) {
            $item['kode_alternatif'] = $item['kode_alternatif'] ?? ('A' . ($idx + 1));

            // ================= UTILITY =================
            // BENEFIT: (Val - Min) / (Max - Min)
            $item['u_kategori'] = $this->safeDivide(
                ($item['kategori'] - $min_kategori),
                ($max_kategori - $min_kategori)
            );

            $item['u_penjualan'] = $this->safeDivide(
                ($item['penjualan'] - $min_penjualan),
                ($max_penjualan - $min_penjualan)
            );

            $item['u_estimasi'] = $this->safeDivide(
                ($item['estimasi'] - $min_estimasi),
                ($max_estimasi - $min_estimasi)
            );

            // COST: (Max - Val) / (Max - Min)
            $item['u_harga'] = $this->safeDivide(
                ($max_harga - $item['harga']),
                ($max_harga - $min_harga)
            );

            // ================= NILAI AKHIR =================
            $item['nilai'] =
                (($bobot['kategori'] ?? 0) * $item['u_kategori']) +
                (($bobot['harga'] ?? 0) * $item['u_harga']) +
                (($bobot['penjualan'] ?? 0) * $item['u_penjualan']) +
                (($bobot['estimasi'] ?? 0) * $item['u_estimasi']);
        }

        session(['hasil_smart' => $data]);
        session(['min_max_smart' => $minMax]);

        return view('backend.smart.perhitungan', compact('data', 'bobot', 'minMax'));
    }

    public function nilaiAkhir()
    {
        $data = session('hasil_smart');

        return view('backend.smart.nilai_akhir', compact('data'));
    }

    // ================= STEP 4: HASIL =================
    public function hasil()
    {
        $data = session('hasil_smart');

        if (!$data) {
            return redirect()->route('smart.kriteria')
                ->with('error', 'Belum ada hasil perhitungan!');
        }

        // SORT RANKING DESCENDING
        usort($data, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        return view('backend.smart.hasil', compact('data'));
    }
}
