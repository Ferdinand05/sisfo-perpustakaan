<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBuku extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'id_buku';
    protected $allowedFields    = [
        'id_buku', 'kode_buku', 'judul_buku', 'penulis_buku', 'penerbit_buku', 'tahun_penerbit', 'stok', 'sampul', 'buku_katid'
    ];
}
