<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPeminjaman extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'id_peminjaman';
    protected $allowedFields    = [
        'id_peminjaman',    'tanggal_pinjam',    'tanggal_kembali',    'id_buku',    'id_anggota',    'id_petugas'
    ];
}
