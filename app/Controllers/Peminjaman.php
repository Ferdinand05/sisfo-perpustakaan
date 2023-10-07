<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAnggota;
use App\Models\ModelBuku;
use App\Models\ModelDTAnggota;
use App\Models\ModelDTBuku;
use App\Models\ModelDTPeminjaman;
use App\Models\ModelPeminjaman;
use App\Models\ModelPetugas;
use Config\Services;

class Peminjaman extends BaseController
{

    protected $modelPeminjaman;
    public function __construct()
    {
        $this->modelPeminjaman = new ModelPeminjaman();
    }

    public function index()
    {

        return view('peminjaman/vw_peminjaman');
    }


    public function listDataPeminjaman()
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
                $btnEdit = '<button type="button" class="btn btn-primary" onclick="editPeminjaman(\'' . $list->id_peminjaman . '\')"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger" onclick="hapusPeminjaman(\'' . $list->id_peminjaman . '\')"><i class="fa fa-trash-alt"></i></button>';
                $btnDetail = '<button type="button" class="btn btn-info" id="btnDetailPeminjaman" onclick="detailPeminjaman(\'' . $list->id_peminjaman . '\')"><i class="fa fa-info-circle"></i></button>';
                $row[] = $no;
                $row[] = $list->nama_anggota;
                $row[] = $list->tanggal_pinjam;
                $row[] = $list->tanggal_kembali;
                $row[] = $list->judul_buku;
                $row[] = $list->nama_petugas;
                $row[] = $btnDetail . ' ' . $btnEdit . ' ' . $btnHapus;
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

    public function modalTambahPeminjam()
    {
        if ($this->request->isAJAX()) {

            $modelPetugas = new ModelPetugas();
            $data = [
                'petugas' => $modelPetugas->findAll()
            ];
            $json = [
                'data' => view('peminjaman/modalTambahPeminjam', $data)
            ];


            return $this->response->setJSON($json);
        }
    }

    public function modalListMember()
    {
        if ($this->request->isAJAX()) {

            $json = [
                'data' => view('peminjaman/modalListMember')
            ];


            return $this->response->setJSON($json);
        }
    }

    public function listCariDataAnggota()
    {

        $request = Services::request();
        $datamodel = new ModelDTAnggota($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnSelect = '<button type="button" class="btn btn-dark" onclick="selectAnggota(\'' . $list->id_anggota . '\')"><i class="fas fa-mouse-pointer"></i></button>';
                $row[] = $no;
                $row[] = $list->nim;
                $row[] = $list->nama_anggota;
                $row[] = $list->no_telp;
                $row[] = $list->alamat_anggota;
                $row[] =  $btnSelect;
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

    public function getDataAnggota()
    {

        if ($this->request->isAJAX()) {

            $id_anggota = $this->request->getPost('id_anggota');

            $anggotaModel = new ModelAnggota();
            $dataAnggota = $anggotaModel->find($id_anggota);

            $data = [
                'anggota' => $dataAnggota
            ];

            $json = [
                'data' => $data
            ];


            return $this->response->setJSON($json);
        }
    }

    public function modalListBuku()
    {
        if ($this->request->isAJAX()) {

            $json = [
                'data' => view('peminjaman/modalListBuku')
            ];



            return $this->response->setJSON($json);
        }
    }

    public function listCariDataBuku()
    {

        $request = Services::request();
        $datamodel = new ModelDTBuku($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnSelect = '<button type="button" class="btn btn-dark btn-sm" title="Pilih Buku" onclick="selectBuku(\'' . $list->id_buku . '\')"><i class="fas fa-mouse-pointer"></i></button>';
                $btnDetail = '<button type="button" class="btn btn-info btn-sm" onclick="detailBuku(\'' . $list->id_buku . '\')"><i class="fa fa-info-circle"></i></button>';
                $row[] = $no;
                $row[] = strtoupper($list->kode_buku);
                $row[] = $list->judul_buku;
                $row[] = $list->nama_kategori;
                $row[] = $list->stok;
                $row[] =  $btnSelect . " " . $btnDetail;
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


    public function getDataBuku()
    {

        if ($this->request->isAJAX()) {
            $id_buku = $this->request->getPost('id_buku');
            $modelBuku = new ModelBuku();
            $dataBuku = $modelBuku->find($id_buku);

            $data = [
                'buku' => $dataBuku
            ];

            $json = [
                'data' => $data
            ];

            return $this->response->setJSON($json);
        }
    }


    // CRUD PEMINJAMAN
    public function addPeminjam()
    {
        if ($this->request->isAJAX()) {
            $tgl_peminjam = $this->request->getPost('tgl_pinjam');
            $durasi_pinjam = $this->request->getPost('durasi_pinjam');
            $id_buku = $this->request->getPost('id_buku');
            $id_anggota = $this->request->getPost('id_member');
            $id_petugas = $this->request->getPost('id_petugas');

            $modelBuku = new ModelBuku();
            $buku = $modelBuku->find($id_buku);

            if ($buku['stok']  <= 1) {
                $json = [
                    'error' => 'Stok Buku Tidak Mencukupi, Tersisa : ' . $buku['stok']
                ];

                return $this->response->setJSON($json);
            }


            $tgl_kembali = date('Y-m-d', strtotime(strval($durasi_pinjam), strtotime(strval($tgl_peminjam))));

            $this->modelPeminjaman->insert([
                'tanggal_pinjam' => $tgl_peminjam,
                'tanggal_kembali' => $tgl_kembali,
                'id_buku' => $id_buku,
                'id_anggota' => $id_anggota,
                'id_petugas' => $id_petugas
            ]);

            $json = [
                'success' => 'Data Peminjaman Berhasil Ditambahkan!'
            ];


            return $this->response->setJSON($json);
        } else {

            exit('Tidak Bisa Diakses');
        }
    }


    public function deletePeminjaman()
    {

        if ($this->request->isAJAX()) {

            $id_peminjaman = $this->request->getPost('id_peminjaman');

            $this->modelPeminjaman->delete($id_peminjaman);


            $json = [
                'success' => 'Data Berhasil Dihapus!'
            ];

            return $this->response->setJSON($json);
        }
    }

    public function showModalDetail()
    {
        if ($this->request->isAJAX()) {
            $id_peminjaman = $this->request->getPost('id_peminjaman');

            $peminjaman = $this->modelPeminjaman->find($id_peminjaman);
            $modelBuku = new ModelBuku();
            $modelAnggota = new ModelAnggota();
            $buku = $modelBuku->find($peminjaman['id_buku']);
            $anggota = $modelAnggota->find($peminjaman['id_anggota']);

            $data = [
                'peminjaman' => $peminjaman,
                'buku' => $buku,
                'anggota' => $anggota
            ];

            $json = [
                'data' => view('peminjaman/modalDetail', $data)
            ];


            return $this->response->setJSON($json);
        }
    }

    public function modalEdit()
    {
        if ($this->request->isAJAX()) {
            $id_peminjaman = $this->request->getPost('id_peminjaman');

            $peminjaman = $this->modelPeminjaman->find($id_peminjaman);
            $modelBuku = new ModelBuku();
            $buku = $modelBuku->find($peminjaman['id_buku']);
            $modelPetugas = new ModelPetugas();
            $petugas = $modelPetugas->find($peminjaman['id_petugas']);
            $allPetugas = $modelPetugas->findAll();

            $data = [
                'peminjaman' => $peminjaman,
                'buku' => $buku,
                'selectedPetugas' => $petugas,
                'allPetugas' => $allPetugas
            ];

            $json = [
                'data' => view('peminjaman/modalEdit', $data)
            ];

            return $this->response->setJSON($json);
        }
    }

    public function editPeminjaman()
    {
        if ($this->request->isAJAX()) {
            $tgl_pengembalian = $this->request->getPost('tgl_pengembalian');
            $id_buku = $this->request->getPost('id_buku');
            $id_petugas = $this->request->getPost('id_petugas');
            $id_peminjaman = $this->request->getPost('id_peminjaman');

            $this->modelPeminjaman->update($id_peminjaman, [
                'tanggal_kembali' => $tgl_pengembalian,
                'id_buku' => $id_buku,
                'id_petugas' => $id_petugas
            ]);

            $json = [
                'success' => 'Data Peminjaman Berhasil Di Update!'
            ];


            return $this->response->setJSON($json);
        }
    }
}
