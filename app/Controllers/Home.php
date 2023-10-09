<?php

namespace App\Controllers;

use App\Models\ModelBuku;
use App\Models\ModelKategori;
use App\Models\ModelPeminjaman;
use App\Models\ModelPengembalian;

class Home extends BaseController
{
    protected $modelBuku, $modelPengembalian, $modelPeminjaman, $modelKategori;

    public function __construct()
    {
        $this->modelBuku = new ModelBuku();
        $this->modelPeminjaman = new ModelPeminjaman();
        $this->modelPengembalian = new ModelPengembalian();
        $this->modelKategori = new ModelKategori();
    }

    public function index()
    {
        $buku = $this->modelBuku->countAll();
        $peminjaman = $this->modelPeminjaman->countAll();
        $pengembalian = $this->modelPengembalian->countAll();
        $pengembalianDenda = $this->modelPengembalian->where('denda', 15000)->countAllResults();
        $kategori = $this->modelKategori->countAll();

        $data = [
            'buku' => $buku,
            'peminjaman' => $peminjaman,
            'pengembalian' => $pengembalian,
            'pengembalianDenda' => $pengembalianDenda,
            'kategori' => $kategori
        ];

        return view('home/index', $data);
    }


    public function contact()
    {

        return view('home/contact');
    }
}
