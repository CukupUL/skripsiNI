<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_penjualan_detail';
    protected $guarded = [];

    public function product()
    {
        //terkait dengan id_prodak // table penyambung yang punya foreign key
        return $this->belongsTo(Produk::class, "id_produk", "id_produk");
    }
}
