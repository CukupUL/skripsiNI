<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    // untuk memberi tahu tabel yanag digunakan akan yanag mana
    protected $table = 'kategori';
   // untuk memunculkan pada edit 
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];

}
