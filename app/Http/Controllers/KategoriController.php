<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // untuk memngil tampilan dari file kategori.index
        return view('kategori.index');
    }

    public function data()
    {
        //mengunakan laravel data table yajra dengan beberapa instalasi yajra
        //ambil kategori yanag udah di dekler diatas setelah itu orderBy untuk memilih 
        $kategori = Kategori::orderBy('id_kategori', 'asc')->get();
        //datatables untuk melihatkan tampilan menguanakn iloquent
        return datatables()
            //kategori dari mana "of"
            ->of($kategori)
            //sudah disediakan oleh datatable dan ditambahakan addIndexColumn untuk memunculkan semau data yanag dibutuhkan pada index.blade.php
            ->addIndexColumn()
            //untuk menambahkan aksi untuk semau tampilan jadi dibawah ketika di click maka akan mendairek ke fungsi dari kategori.update dan ada dua tampilan yaitu delet maka akn di arahkan ke fungsi delet
            ->addColumn('aksi', function ($kategori) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('kategori.update', $kategori->id_kategori) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                    <button onclick="deleteData(`'. route('kategori.destroy', $kategori->id_kategori) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            //rawkolom untuk retrun di viewe supaya kebaca html
            ->rawColumns(['aksi'])

            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //membuat kategori baru lalau disimpan di tabel kategori setaleh itu di save pada database
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //untuk memunculkan data yang akan di edit pada kolom 
        $kategori = Kategori::find($id);

        return response()->json($kategori);
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
        //memberikan fungsi pada kategori
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fungsi untuk delet data
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}