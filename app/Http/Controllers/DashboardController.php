<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //untuk mengambil awal ke routing dan cumn ada satu fungsion 
    public function __invoke(Request $request)
    {
        $date_expired = \date("Y-m-d", \strtotime("+1month"));
        // untuk cek = dd($date_expired); diambil dari baris 35 
        $data = [
            // Total penjualan diambil dari Model / Tabel penjualan, lalu mengguanakan method count untuk menghitung jumlah baris
            "total_penjualan" => Penjualan::count(),
            // Total produk diambil dari model / table produk yang mengandung method count untuk menghitung jumlah baris / produk
            "total_produk" => Produk::count(),
            // Total produk yang sudah kurang dari stok standar diambil dari model / table produk yang dimana stok dibawah 7
            //where = kondisi data stok
            "total_produk_out_stok" => Produk::where("stok", "<", 7)->count(),
            // Total produk yang sudah kadaluarsa diambil dari model / table produk yang dimana stok dibawah 7
            
            "total_produk_expired" => Produk::where("tgl_exp", "<=", $date_expired)->count(),
            // Total pembayaran penjualan yang diambil dari model / table penjualan dan menggunakan method sum() untuk langsung mengambil sum dari pembayaran
            //sun adalah hasil
            "total_penjualan_price" => Penjualan::sum("bayar"),
            // Total asset produk diambil dari model / table produk yang disum menggunakan selectRaw. Lalu diambil row pertama nya saja menggunakan method first(), dan kemudian
            // Langsung diambil data property nya

            //selectRaw = untuk mengisi quer langsung / first menambil datu data 
            "total_produk_price" => Produk::selectRaw("SUM(harga_beli * stok) AS total_produk_price")->first()->total_produk_price,
            // List date adalah data list tanggal yang ada order nya. Diambil mengguanakan selectRaw yang mana bulan nya adalah bulan saat ini (Menggunakan whereMonth())
            // lalu di group by berdasarkan tanggal
            // Hasil yang didapatkan akan menjadi tipe data collection yang mana collection ini berguna untuk mengolah struktur data seperti map.
            // Contoh dibawah data di map lalu di filter unique dan diambil values nya, karena data yang dihasilkan bersifat array of object, maka yang diambil hanya values nya saja
            // Lalu data diubah menjadi array
            
            // wearmont = mengambil bulan
            // object colection untuk menipulasi isi data
            //list date menjadi aray
            // "list_date" => Penjualan::selectRaw("DATE_FORMAT(created_at, '%d %M %Y') AS list_day")->whereMonth("created_at", date("m"))->groupBy("created_at")->get()->map(fn($produk) => $produk->list_day)->unique()->values()->toArray(),
            // List price adalah data list harga per masing-masing tanggal. Menggunakan select raw yang mana bulan nya adalah bulan saat ini.
            // lalu data diubah menggunakan map, lalu ambil unique dan diubah menjadi array kembali
            "list_price" => Penjualan::selectRaw("SUM(bayar) AS bayar")->whereMonth("created_at", date("m"))->groupByRaw("DAY(created_at)")->get()->map(fn($produk) => $produk->bayar)->toArray(),
        ];

        //untuk memunculkan / $data untuk menampilkan view dari data aray
        return \view("home", $data);
    }
}
