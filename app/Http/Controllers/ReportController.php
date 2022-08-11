<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetail;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return \view("reports.index");
    }

    public function index_product()
    {
        $date_expired = Carbon::now()->addMonth(1);
        $data = [
            "count_out_stok" => Produk::where("stok", 0)->count(),
            "product_out_stok" => Produk::where("stok", 0)->limit(10)->get(),
            "product_approach_stok" => Produk::orderBy("stok", "ASC")->where("stok", "<", 7)->get(),
            "product_expires" => Produk::whereDate("tgl_exp", "<=", $date_expired)->orderBy("tgl_exp", "ASC")->limit(10)->get()
        ];

        return \view("reports.index_product", $data);
    }

    public function data_product_transaction()
    {
        $produk = PenjualanDetail::select([
                    "penjualan_detail.*", "p.nama_produk", "pj.no_penjualan"
                ])->join("produk AS p", "p.id_produk", "penjualan_detail.id_produk")
                ->join("penjualan AS pj", "pj.id_penjualan", "penjualan_detail.id_penjualan");

        return \datatables()
            ->of($produk)
            ->addColumn("subtotal", function($jual) {
                return number_format($jual->subtotal);
            })
            ->make(TRUE);         
    }
}
