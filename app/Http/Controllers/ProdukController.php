<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\katagori;
use App\Models\FotoProduk;
use App\Helpers\ImageHelper;
class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $produk = Produk::orderBy('updated_at', 'desc',)->get();
       
        return view('backend.produk.index', [
        'judul' => 'Data Produk',
        'index' => $produk
]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $katagori = katagori::orderBy('nama_katagori', 'asc')->get();
        return view('backend.produk.create', [
        'judul' => 'Tambah Produk',
        'katagori' => $katagori
]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    $validatedData = $request->validate([
    'katagori_id' => 'required|exists:katagori,id', // Pastikan ID ada di tabel katagori
    'nama_produk' => 'required|max:255|unique:produk',
    'detail' => 'required',
    'harga' => 'required',
    'stok' => 'required',
    'berat' => 'required',
    'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024',
    ], $messages = [
    'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png,
    atau gif.',
    'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
    ]);

    $validatedData['status'] = 0;
    if ($request->file('foto')) {
    $file = $request->file('foto');
    $extension = $file->getClientOriginalExtension();
    $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
    $directory = 'storage/img-produk/';
    // Simpan gambar asli
    $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
    $validatedData['foto'] = $fileName;
    // create thumbnail 1 (lg)
    $thumbnailLg = 'thumb_lg_' . $originalFileName;
    ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
    // create thumbnail 2 (md)
    $thumbnailMd = 'thumb_md_' . $originalFileName;
    ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
    // create thumbnail 3 (sm)
    $thumbnailSm = 'thumb_sm_' . $originalFileName;
    ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
    // Simpan nama file asli di database
    $validatedData['foto'] = $originalFileName;
    }
$validatedData['user_id'] = auth()->id(); // ✅ Tambahkan ini
Produk::create($validatedData, $messages);
return redirect()->route('backend.produk.index')->with('success', 'Data berhasil
tersimpan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with('fotoProduk')->findOrFail($id);
        $katagori = katagori::orderBy('nama_katagori', 'asc')->get();
        return view('backend.produk.show', [
        'judul' => 'Detail Produk',
        'show' => $produk,
        'katagori' => $katagori
]);
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $katagori = katagori::orderBy('nama_katagori', 'asc')->get();
        
        return view('backend.produk.edit', [
            'judul' => 'Edit Produk',
            'produk' => $produk,
            'katagori' => $katagori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $validatedData = $request->validate([
          'katagori_id' => 'required|exists:katagori,id', // Pastikan ID ada di tabel katagori
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $produk->id,
            'detail' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'berat' => 'required',
            'status' => 'required|in:0,1',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar maksimal adalah 1024 KB.'
        ]);

         $validatedData['user_id'] = auth()->id(); // ✅ Tambahkan ini
        // Jika ada file foto baru diunggah
        if ($request->file('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto) {
                $oldFilePath = public_path('storage/img-produk/' . $produk->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                $thumbnails = [
                    'thumb_lg_' . $produk->foto,
                    'thumb_md_' . $produk->foto,
                    'thumb_sm_' . $produk->foto
                ];

                foreach ($thumbnails as $thumbnail) {
                    $thumbnailPath = public_path('storage/img-produk/' . $thumbnail);
                    if (file_exists($thumbnailPath)) {
                        unlink($thumbnailPath);
                    }
                }
            }

            // Upload foto baru
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';

            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['foto'] = $fileName;

            // Create thumbnails
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);
        }

        // Update produk
        $produk->update($validatedData);

        return redirect()->route('backend.produk.index')->with('success', 'Data produk berhasil diperbarui');
    
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // Mencari produk berdasarkan ID
    $produk = Produk::find($id);

    // Jika produk tidak ditemukan
    if (!$produk) {
        return redirect()->route('backend.produk.index')->with('error', 'Produk tidak ditemukan');
    }

    // Menghapus file gambar terkait jika ada
    if ($produk->foto) {
        $filePath = public_path('storage/img-produk/' . $produk->foto);
        
        // Cek apakah file ada dan menghapusnya
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Menghapus thumbnail terkait
        $thumbnails = [
            'thumb_lg_' . $produk->foto,
            'thumb_md_' . $produk->foto,
            'thumb_sm_' . $produk->foto
        ];

        foreach ($thumbnails as $thumbnail) {
            $thumbnailPath = public_path('storage/img-produk/' . $thumbnail);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }
    }

    // Menghapus data produk dari database
    $produk->delete();

    return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil dihapus');
}

// Method untuk Form Laporan Produk
public function formProduk()
{
return view('backend.produk.form', [
'judul' => 'Laporan Data Produk',
]);
}
// Method untuk Cetak Laporan Produk
public function cetakProduk(Request $request)
{
// Menambahkan aturan validasi
$request->validate([
'tanggal_awal' => 'required|date',
'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
], [
'tanggal_awal.required' => 'Tanggal Awal harus diisi.',
'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.',
'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.',
]);
$tanggalAwal = $request->input('tanggal_awal');
$tanggalAkhir = $request->input('tanggal_akhir');
$query = Produk::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])
->orderBy('id', 'desc');
$produk = $query->get();


return view('backend.produk.cetak', [
'judul' => 'Laporan Produk',
'tanggalAwal' => $tanggalAwal,
'tanggalAkhir' => $tanggalAkhir,
'cetak' => $produk
]);
}

}
