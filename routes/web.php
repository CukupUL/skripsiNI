<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\ExpController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// fiktur erow function karna di php 7 keatas 
// untuk diarahkankelogin = callback diarahkan mengunakan jetstreamn laravel
Route::get('/', fn () => redirect()->route('login'));

    // untuk autentikasi = middeware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    // verived yanag udah terutentikasi
    //pas masuk ke dashboard mak akan di alihkan ke bagian home karna view ('home')
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});


Route::group(['middleware' => 'auth'], function () {
    //ambil kategori kontroler langsung kedata = name('kategori.data') utuk menyederhanaan peroses pemanggilan
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    // resource = umembuat lis kategori mengunakan http feb secara otomatis
    Route::resource('/kategori', KategoriController::class);
    
    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::resource('/produk', ProdukController::class);

    Route::get('/stok/data', [StokController::class, 'data'])->name('stok.data');
    Route::resource('/stok', StokController::class);

    Route::get('/exp/data', [ExpController::class, 'data'])->name('exp.data');
    Route::resource('/exp', ExpController::class);

    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::resource('/transaksi', PenjualanDetailController::class)
          ->except('show');

    Route::get("/reports", [ReportController::class, "index"]);
    Route::get("/reports/produk", [ReportController::class, "index_product"]);
    Route::get("/reports/produk/data", [ReportController::class, "data_product_transaction"])->name("report.product.transaction.data");

    Route::get("/penjualan", [PenjualanController::class, "index"]);
    Route::get("/penjualan/create", [PenjualanController::class, "create"]);
    
    Route::post("/penjualan", [PenjualanController::class, "store"]);
    Route::get("/penjualan/data", [PenjualanController::class, "data"])->name("penjualan.data");
    Route::get("/penjualan/{penjualan}", [PenjualanController::class, "show"]);
    Route::get("/penjualan/produk/search", [PenjualanController::class, "search_produk"]);

    Route::get("/profile", [UserController::class, "show"]);
    Route::post("/profile", [UserController::class, "update"]);
});