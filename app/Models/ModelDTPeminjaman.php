<?php

namespace App\Models;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
use Config\Services;

class ModelDTPeminjaman extends Model
{
    protected $table = "peminjaman";
    protected $column_order = array('', 'nama_anggota', 'tanggal_pinjam', 'tanggal_kembali', 'judul_buku', 'nama_petugas', '');
    protected $column_search = array('tanggal_pinjam', 'tanggal_kembali');
    protected $order = array('tanggal_pinjam' => 'ASC');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(IncomingRequest $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->builder('peminjaman pm')->join('buku as b', 'pm.id_buku=b.id_buku')->join('anggota as a', 'pm.id_anggota=a.id_anggota')
            ->join('petugas as p', 'pm.id_petugas=p.id_petugas');
    }
    private function _get_datatables_query()
    {



        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->dt = $this->builder('peminjaman pm')->join('buku as b', 'pm.id_buku=b.id_buku')->join('anggota as a', 'pm.id_anggota=a.id_anggota')
            ->join('petugas as p', 'pm.id_petugas=p.id_petugas');
        return $tbl_storage->countAllResults();
    }
}
