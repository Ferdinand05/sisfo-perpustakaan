<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAnggota extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id_anggota';
    protected $allowedFields    = [
        'id_anggota', 'nim', 'nama_anggota', 'no_telp', 'alamat_anggota'
    ];
}
