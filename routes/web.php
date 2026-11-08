<?php

use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KatagoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SmartController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('frontend.beranda');
});

Route::get('backend/beranda', [BerandaController::class,'berandabackend'])->name('backend.beranda');
Route::get('backend/login', [LoginController::class,'loginbackend'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

// Route::resource('backend/user', UserController::class)->middleware('auth');
Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth');
Route::resource('backend/katagori', KatagoriController::class, ['as' => 'backend'])->middleware('auth');
Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])->middleware('auth');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('backend.produk.update');
Route::get('backend/produk/{id}/edit', [ProdukController::class, 'edit'])->name('backend.produk.edit');

Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk')->middleware('auth');
Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk')->middleware('auth');

Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth');
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth');

// SPK SMART
Route::prefix('backend/smart')->group(function () {

    Route::get('/', [SmartController::class, 'menu'])->name('smart.index');

    // STEP 1
    Route::get('/kriteria', [SmartController::class, 'kriteria'])->name('smart.kriteria');
    Route::post('/kriteria', [SmartController::class, 'storeKriteria'])->name('smart.storeKriteria');
    Route::post('/store-manual', [SmartController::class, 'storeManual'])->name('smart.storeManual');
    Route::put('/update-manual/{id}', [SmartController::class, 'updateManual'])->name('smart.updateManual');
    Route::delete('/destroy-manual/{id}', [SmartController::class, 'destroyManual'])->name('smart.destroyManual');
    Route::post('/import-excel', [SmartController::class, 'importExcel'])->name('smart.importExcel');
    Route::post('/import-kasir', [SmartController::class, 'importKasir'])->name('smart.importKasir');
    Route::get('/preview-kasir', [SmartController::class, 'previewKasir'])->name('smart.previewKasir');
    Route::post('/reset-data', [SmartController::class, 'resetData'])->name('smart.resetData');
    Route::get('/export-template', [SmartController::class, 'exportTemplate'])->name('smart.exportTemplate');

    // STEP 2
    Route::get('/bobot', [SmartController::class, 'bobot'])->name('smart.bobot');
    Route::post('/bobot', [SmartController::class, 'storeBobot'])->name('smart.storeBobot');

    // STEP 3
    Route::get('/perhitungan', [SmartController::class, 'perhitungan'])->name('smart.perhitungan');

    Route::get('/nilai-akhir', [SmartController::class, 'nilaiAkhir'])->name('smart.nilaiAkhir');

    // STEP 4
    Route::get('/hasil', [SmartController::class, 'hasil'])->name('smart.hasil');
});

Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/process', [KasirController::class, 'processTransaction'])->name('kasir.process');
Route::get('/kasir/get-products', [KasirController::class, 'getProducts'])->name('kasir.get-products');
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');

Route::prefix('laporan')->group(function() {
    Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak'); // Ini yang penting
    Route::get('/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/{id}', [LaporanController::class, 'update'])->name('laporan.update');
});

Route::get('frontend/beranda', [HomeController::class,'index'])->name('frontend.beranda');

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/makanan', [MenuController::class, 'makanan'])->name('menu.makanan');
    Route::get('/minuman', [MenuController::class, 'minuman'])->name('menu.minuman');
    Route::get('/snack', [MenuController::class, 'snack'])->name('menu.snack');
    Route::get('/best', [MenuController::class, 'best'])->name('menu.best');
});
// cart
// Route untuk halaman keranjang
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');

// Atau jika Anda ingin menggunakan nama yang berbeda, sesuaikan dengan yang ada di blade
Route::get('/keranjang', [CartController::class, 'viewCart'])->name('cart');

// Route lainnya untuk cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('update.cart');
Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('remove.from.cart');

// Route untuk checkout
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    Route::get('/success/{order_number}', [CheckoutController::class, 'orderSuccess'])->name('order.success');
    Route::get('/payment/qris/{order_number}', [CheckoutController::class, 'showQRISPayment'])->name('payment.qris');
    Route::get('/check-payment-status/{order_number}', [CheckoutController::class, 'checkPaymentStatus'])->name('check.payment.status');
});

Route::get('/order', [OrderController::class, 'index'])->name('backend.orders.index');
Route::post('/orders/{order}/verify', [OrderController::class, 'verifyPayment'])->name('orders.verify');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/verified', [OrderController::class, 'verifiedOrders'])->name('backend.orders.verified');

Route::get('/test-image-upload', function(Request $request) {
    // Simulasikan upload file
    $file = UploadedFile::fake()->image('test-payment.jpg');
    
    // Simpan file
    $path = $file->storeAs('payment_proofs', 'test_'.time().'.jpg', 'public');
    
    return [
        'storage_path' => storage_path('app/public/'.$path),
        'public_url' => asset('storage/'.$path),
        'storage_url' => Storage::url($path),
        'file_exists' => Storage::disk('public')->exists($path),
        'all_files' => Storage::disk('public')->allFiles('payment_proofs')
    ];
});