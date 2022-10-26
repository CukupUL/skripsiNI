<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class PenjualanController extends Controller
{
    public function data()
    {
        $penjualan = Penjualan::select(["id_penjualan", "no_penjualan", "created_at", "total_item", "total_harga"]);
        // dd($penjualan);

        return \datatables()->of($penjualan)
            ->addColumn("created_at", function ($jual) {
                return Carbon::parse($jual->created_at)->format("d M Y");
            })
            ->addColumn("total_harga", function ($jual) {
                return \number_format($jual->total_harga);
            })
            ->addColumn("total_item", function ($jual) {
                return \number_format($jual->total_item);
            })
            ->addColumn("aksi", function ($jual) {
                return '
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" href="/penjualan/' . $jual->id_penjualan . '"><i class="fa fa-eye"></i></a>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(TRUE);
    }

    public function index()
    {
        return view('penjualan.index');
    }

    public function search_produk()
    {
        $response = new stdClass;
        $response->status = FALSE;
        $response->data = [];

        $get_produk = Produk::where("stok", ">", 0)->where('tgl_exp', '>', date('Y-m-d'))->where(function($query)  {
            $query->where("kode_produk", "LIKE", "%" . \request()->kode . "%")->orWhere("nama_produk", "LIKE", "%" . \request()->kode . "%");
        })->orderBy('tgl_exp', 'asc') 
        ->get();
        if (\count($get_produk) > 0) {
            $response->status = TRUE;
            $response->data = $get_produk;
        }

        return \response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("penjualan.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi Input
        $this->validate($request, [
            "id_produk.*" => "required|exists:produk,id_produk",
            "jumlah.*" => "required|string",
            "bayar" => "required|string"
        ]);
        // Memulai transaksi database untuk menjamin data kita berjalan dengan baik
        DB::beginTransaction();

        try {
            // Set values produk dan total harga
            $values_produk = [];
            $total_harga = 0;

            // Loop produk yang diinputkan
            // Kenapa harus looping? 
            // 1. Untuk validasi produk
            // 2. Untuk mengisi data penjualan detail
            for ($i = 0; $i < \count($request->id_produk); $i++) {
                // Get produk
                $produk = Produk::find($request->id_produk[$i]);
                $harga_jual = $produk->harga_jual;
                $jumlah = \str_replace(",", "", $request->jumlah[$i]);

                // Jika stok dibawah permintaan
                if ($produk->stok < $jumlah) {
                    // Jika stok nya masih lebih besar dari 0
                    if ($produk->stok > 0) {
                        $jumlah = $produk->stok;
                    } else {
                        $jumlah = 0;
                    }
                }

                // Jika jumlahnya 0, maka skip
                if ($jumlah > 0) {
                    // Set values produk
                    //aray dalam arai
                    $values_produk[] = [
                        "id_produk" => $request->id_produk[$i],
                        "harga_jual" => $harga_jual,
                        "jumlah" => $jumlah,
                        "subtotal" => $harga_jual * $jumlah
                    ];
                    // untuk mengkalkulasikan harghga jual di tambah harga harga
                    $total_harga += $harga_jual * $jumlah;
    
                    // Update stok produk berdasarkan jumalah sistem dan di kurnagi dari pembalian
                    $produk->update([
                        "stok" => $produk->stok - $jumlah
                    ]);
                }
            }

            // Jika values produk kosong, maka skip // pengecekan 
            if (\count($values_produk) > 0) {
                // Hitung total produk yang di input
                $total_item = \count($values_produk);
                // Ubah values produk menjadi tipe data collection
                $values_produk = \collect($values_produk);
                // Hapus koma dari inputan bayar akan disi olah bayar dari user
                $bayar = \str_replace(",", "", $request->bayar);
                
                // Jika pembayaran nya sama dengan atau lebih besar dari total harga
                if ($bayar >= $total_harga) {
                    // Set kembalian jika ada
                    $kembalian = $bayar - $total_harga;

                    // Set pembayaran yang diterima pegkondisian 
                    $diterima = $bayar;
                    if ($bayar > $total_harga) {
                        $diterima = $total_harga;
                    }

                    // Set values penjualan nya isian
                    $values_penjualan = [
                        "no_penjualan" => \rand(100, 1000000),
                        "total_item" => $total_item,
                        "total_harga" => $total_harga,
                        "bayar" => $bayar,
                        "diterima" => $diterima,
                        "kembalian" => $kembalian,
                        "id_user" => Auth::user()->id
                    ];

                    // Insert kedalam table penjualan kirim  eloqwin 
                    $penjualan = Penjualan::create($values_penjualan);
                    //mengubah koleksi data dan mengulang ngulang // untuk mengambil callback mengunakan = use
                    // Karena values produk tadi sudah diubah menjadi tipe data collection, maka kita bisa manipulasi data nya
                    $values_produk->map(function($produk) use ($penjualan) {
                        // Map untuk menambahkan data baru yaitu ID Penjualan
                        $produk["id_penjualan"] = $penjualan->id_penjualan;
                        return $produk;
                        //untuk disimpan dalam prodak = v_produk
                    })->each(function($v_produk) {
                        // Setiap data, insert / masukan kedalam table penjualan detail
                        PenjualanDetail::create($v_produk);
                    });

                    // jika tidak ada kesalahan dalam query / kode PHP, maka commit / realisasikan query
                    //DB::commit membari ahu mysql sudah selesai dang merealisasikan code kirim mysql
                    DB::commit();
                    return \redirect("/penjualan/$penjualan->id_penjualan")->with("message", "<script>alert('Berhasil membuat penjualan!')</script>");   
                }

                // Jika pembayaran nya kurang dari total harga, maka transaksi database sebelumnya di rollback
                DB::rollBack();
                return \redirect("/penjualan/create")->with("message", "<script>alert('Total Bayar tidak sesuai tagihan!')</script>");
            } else {
                // Jika tidak ada produk, maka rollback data nya
                DB::rollBack();
                return \redirect("/penjualan/create")->with("message", "<script>alert('Produk tidak dimasukan/stok habis!')</script>");
            }
        } catch (\Exception $e) {
            // Jika ada kesalahan dari kode PHPnya, maka rollback transaksi database nya
            DB::rollBack();
            // Masukan ke log
            \info($e->getMessage());
            return \back()->with("message", "<script>alert('Gagal! Terjadi kesalahan, mohon dicoba kembali!')</script>");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        $data = [
            "penjualan" => $penjualan,
            "items" => $penjualan->detail()->with("product")->get()
        ];
        // dd($data);

        return view("penjualan.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
