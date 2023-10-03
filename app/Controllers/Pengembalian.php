<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengembalian extends BaseController
{
    public function index()
    {


        return view('pengembalian/vw_pengembalian');
    }
}
