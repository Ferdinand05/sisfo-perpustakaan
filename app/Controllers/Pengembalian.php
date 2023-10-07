<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAnggota;
use App\Models\ModelBuku;
use App\Models\ModelDTPeminjaman;
use App\Models\ModelDTPengembalian;
use App\Models\ModelPeminjaman;
use App\Models\ModelPengembalian;
use App\Models\ModelPetugas;
use Config\Services;

class Pengembalian extends BaseController
{
    protected $modelPeminjaman, $modelPengembalian;

    public function __construct()
    {
        $this->modelPeminjaman = new ModelPeminjaman();
        $this->modelPengembalian = new ModelPengembalian();
    }

    public function index()
    {


        return view('pengembalian/vw_pengembalian');
    }

    public function listDataPengembalian()
    {

        $request = Services::request();
        $datamodel = new ModelDTPengembalian($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnDelete = '<button type="button" class="btn btn-danger" title="Hapus Buku" onclick="deletePengembalian(\'' . $list->id_pengembalian . '\')"><i class="fa fa-trash-alt"></i></button>';
                $btnEdit = '<button type="button" class="btn btn-primary" title="Edit Buku" onclick="editPengembalian(\'' . $list->id_pengembalian . '\')"><i class="fa fa-edit"></i></button>';
                $btnDetail = '<button type="button" class="btn btn-info " onclick="detailPengembalian(\'' . $list->id_pengembalian . '\')"><i class="fa fa-info-circle"></i></button>';
                $row[] = $no;
                $row[] = $list->nama_anggota;
                $row[] = $list->jatuhtempo;
                $row[] = $list->tanggal_pengembalian;
                $row[] = $list->judul_buku;
                $row[] = $list->denda;
                $row[] =  $btnDetail . ' ' . $btnEdit . ' ' . $btnDelete;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function modalTambahPengembalian()
    {
        if ($this->request->isAJAX()) {

            $json = [
                'data' => view('pengembalian/modalTambahPengembalian')
            ];


            return $this->response->setJSON($json);
        }
    }

    public function modalListPengembalian()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('pengembalian/modalList')
            ];


            return $this->response->setJSON($json);
        }
    }

    public function listCariDataPeminjaman()
    {
        $request = Services::request();
        $datamodel = new ModelDTPeminjaman($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnSelect = '<button type="button" class="btn btn-dark" onclick="selectPeminjaman(\'' . $list->id_peminjaman . '\')"><i class="fa fa-mouse-pointer"></i></button>';
                $row[] = $no;
                $row[] = $list->nama_anggota;
                $row[] = $list->tanggal_pinjam;
                $row[] = $list->tanggal_kembali;
                $row[] = $list->judul_buku;
                $row[] = $list->nama_petugas;
                $row[] = $btnSelect;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function selectPeminjaman()
    {
        if ($this->request->isAJAX()) {
            $id_peminjaman = $this->request->getPost('id_peminjaman');

            $peminjaman = $this->modelPeminjaman->find($id_peminjaman);
            $modelAnggota = new ModelAnggota();
            $modelBuku = new ModelBuku();
            $modelPetugas = new ModelPetugas();

            $anggota = $modelAnggota->find($peminjaman['id_anggota']);
            $buku = $modelBuku->find($peminjaman['id_buku']);
            $petugas = $modelPetugas->find($peminjaman['id_petugas']);

            $data = [
                'peminjaman' => $peminjaman,
                'anggota' => $anggota,
                'buku' => $buku,
                'petugas' => $petugas
            ];

            $json = [
                'data' => $data
            ];


            return $this->response->setJSON($json);
        }
    }


    public function addPengembalian()
    {
        if ($this->request->isAJAX()) {
            $tgl_pengembalian = $this->request->getPost('tgl_pengembalian');
            $id_peminjaman = $this->request->getPost('id_peminjaman');
            $id_buku = $this->request->getPost('id_buku');
            $id_anggota = $this->request->getPost('id_anggota');
            $id_petugas = $this->request->getPost('id_petugas');

            $peminjaman = $this->modelPeminjaman->find($id_peminjaman);
            $tgl_jatuh_tempo = $peminjaman['tanggal_kembali'];



            if ($tgl_pengembalian > $tgl_jatuh_tempo) {
                $denda = 15000;
            } else {
                $denda = 0;
            }


            // Tambah Pengembalian
            $this->modelPengembalian->insert([
                'tanggal_pengembalian' => $tgl_pengembalian,
                'jatuhtempo' => $tgl_jatuh_tempo,
                'denda' => $denda,
                'id_petugas' => $id_petugas,
                'id_anggota' => $id_anggota,
                'id_buku' => $id_buku
            ]);

            // hapus Peminjaman
            $this->modelPeminjaman->delete($id_peminjaman);

            $json = [
                'success' => 'Data Pengembalian Berhasil Disimpan!'
            ];


            return $this->response->setJSON($json);
        }
    }


    public function deletePengembalian()
    {
        if ($this->request->isAJAX()) {
            $id_pengembalian = $this->request->getPost('id_pengembalian');

            $this->modelPengembalian->delete($id_pengembalian);


            $json = [
                'success' => 'Data Pengembalian Berhasil Dihapus!'
            ];


            return $this->response->setJSON($json);
        }
    }

    public function modalEditPengembalian()
    {
        if ($this->request->isAJAX()) {
            $id_pengembalian = $this->request->getPost('id_pengembalian');

            $pengembalian = $this->modelPengembalian->find($id_pengembalian);
            $modelBuku = new ModelBuku();
            $modelAnggota = new ModelAnggota();
            $modelPetugas = new ModelPetugas();


            $data = [
                'pengembalian' => $pengembalian,
                'buku' => $modelBuku->find($pengembalian['id_buku']),
                'anggota' => $modelAnggota->find($pengembalian['id_anggota']),
                'petugas' => $modelPetugas->find($pengembalian['id_petugas']),
                'allPetugas' => $modelPetugas->findAll()
            ];

            $json = [
                'data' => view('pengembalian/modalEditPengembalian', $data)
            ];

            return $this->response->setJSON($json);
        }
    }

    public function editPengembalian()
    {
        if ($this->request->isAJAX()) {
            $id_pengembalian = $this->request->getPost('id_pengembalian');
            $tgl_pengembalian = $this->request->getPost('tgl_pengembalian');
            $id_petugas = $this->request->getPost('petugas');
            $tgl_jatuhtempo = $this->request->getPost('tgl_jatuhtempo');


            if ($tgl_pengembalian > $tgl_jatuhtempo) {
                $denda = 15000;
            } else if ($tgl_pengembalian <= $tgl_jatuhtempo) {
                $denda = 0;
            }

            $this->modelPengembalian->update($id_pengembalian, [
                'tanggal_pengembalian' => $tgl_pengembalian,
                'jatuhtempo' => $tgl_jatuhtempo,
                'id_petugas' => $id_petugas,
                'denda' => $denda
            ]);

            $json = [
                'success' => 'Data Pengembalian, Berhasil Di Update!'
            ];


            return $this->response->setJSON($json);
        }
    }


    public function detailPengembalian()
    {
        if ($this->request->isAJAX()) {
            $id_pengembalian = $this->request->getPost('id_pengembalian');
            $modelBuku = new ModelBuku();
            $modelAnggota = new ModelAnggota();
            $modelPetugas = new ModelPetugas();
            $pengembalian = $this->modelPengembalian->find($id_pengembalian);


            $data = [
                'pengembalian' => $pengembalian,
                'buku' => $modelBuku->find($pengembalian['id_buku']),
                'anggota' => $modelAnggota->find($pengembalian['id_anggota']),
                'petugas' => $modelPetugas->find($pengembalian['id_petugas'])
            ];

            $json = [
                'data' => view('pengembalian/modalDetail', $data)
            ];


            return $this->response->setJSON($json);
        }
    }
}
