<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKategori;

class Kategori extends BaseController
{

    protected $kategoriModel;
    public function __construct()
    {
        $this->kategoriModel = new ModelKategori();
    }

    public function index()
    {
        //

        return view('kategori/vw_kategori');
    }
}
