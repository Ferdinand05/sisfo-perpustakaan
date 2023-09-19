<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBuku;
use App\Models\ModelDTBuku;
use Config\Services;

class Buku extends BaseController
{
    protected $bukuModel;
    public function __construct()
    {
        $this->bukuModel = new ModelBuku();
    }


    public function index()
    {


        return view('buku/vw_buku');
    }

    public function listDataBuku()
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
                $btnEdit = '<button type="button" class="btn btn-primary" onclick="editBuku(\'' . $list->id_buku . '\')"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger" onclick="hapusBuku(\'' . $list->id_buku . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = strtoupper($list->kode_buku);
                $row[] = $list->judul_buku;
                $row[] = $list->penulis_buku;
                $row[] = $list->penerbit_buku;
                $row[] = $list->tahun_penerbit;
                $row[] = $list->stok;
                $row[] =  $btnEdit . " " . $btnHapus;
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

    public function modalTambahBuku()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('buku/modalTambahBuku')
            ];
        }

        return $this->response->setJSON($json);
    }

    public function tambahBuku()
    {
        if ($this->request->isAJAX()) {
            $kode_buku = $this->request->getPost('kode_buku');
            $judul = $this->request->getPost('judul_buku');
            $penulis = $this->request->getPost('penulis_buku');
            $penerbit = $this->request->getPost('penerbit');
            $tahun_terbit = $this->request->getPost('tahun_terbit');
            $stok_buku = $this->request->getPost('stok_buku');



            $validation = \Config\Services::validation();
            $validation->setRules([
                'kode_buku' => [
                    'label' => 'Kode Buku',
                    'rules' => 'required|string|is_unique[buku.kode_buku]|max_length[5]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field}  Sudah Digunakan!',
                        'max_length' => ' Maksimal {param} Huruf'
                    ]
                ],
                'judul_buku' => [
                    'label' => 'Judul Buku',
                    'rules' => 'string|required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'penulis_buku' => [
                    'label' => 'Penulis Buku',
                    'rules' => 'required|string',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'penerbit' => [
                    'label' => 'Nama Penerbit Buku',
                    'rules' => 'required|string',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'tahun_terbit' => [
                    'label' => 'Tahun Penerbit',
                    'rules' => 'required|max_length[4]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'max_length' => 'Maksimal {param} Huruf'
                    ]

                ],
                'stok_buku' => [
                    'label' => 'Stok Buku',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
            ]);

            $sampul = $this->request->getFile('sampul');
            $data = [
                'kode_buku' => $kode_buku,
                'judul_buku' => $judul,
                'penulis_buku' => $penulis,
                'penerbit' => $penerbit,
                'tahun_terbit' => $tahun_terbit,
                'stok_buku' => $stok_buku,
            ];

            if (!$validation->run($data)) {
                $json = [
                    'error' => [
                        'errorKode' => $validation->getError('kode_buku'),
                        'errorJudul' => $validation->getError('judul_buku'),
                        'errorPenulis' => $validation->getError('penulis_buku'),
                        'errorPenerbit' => $validation->getError('penerbit'),
                        'errorTahun' => $validation->getError('tahun_terbit'),
                        'errorStok' => $validation->getError('stok_buku'),
                    ]
                ];
            } else {


                $this->bukuModel->insert([
                    'kode_buku' => $kode_buku,
                    'judul_buku' => $judul,
                    'penulis_buku' => $penulis,
                    'penerbit_buku' => $penerbit,
                    'tahun_penerbit' => $tahun_terbit,
                    'stok' => $stok_buku,
                ]);

                $json = [
                    'sukses' => 'Buku Berhasil Ditambahkan!'
                ];
            }
            return $this->response->setJSON($json);
        } else {
            exit('Tidak Bisa Diakses!');
        }
    }

    public function hapusBuku()
    {
        if ($this->request->isAJAX()) {
            $idBuku = $this->request->getPost('id_buku');

            $this->bukuModel->delete($idBuku);

            $json = [
                'sukses' => 'Buku Berhasil Dihapus!'
            ];


            return $this->response->setJSON($json);
        }
    }
}
