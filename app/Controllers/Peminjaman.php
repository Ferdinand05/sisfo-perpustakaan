<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Peminjaman extends BaseController
{
    public function index()
    {

        return view('peminjaman/vw_peminjaman');
    }
}
