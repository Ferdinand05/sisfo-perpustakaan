<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPetugas extends Model
{
    protected $table            = 'petugas';
    protected $primaryKey       = 'id_petugas';

    protected $allowedFields    = [
        'id_petugas', 'nama_petugas', 'no_telp_petugas', 'alamat_petugas'
    ];
}
