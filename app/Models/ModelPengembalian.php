<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengembalian extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'id_pengembalian';
    protected $allowedFields    = [
        'id_pengembalian', 'tanggal_pengembalian', 'denda', 'id_buku', 'id_anggota', 'id_petugas'
    ];
}
