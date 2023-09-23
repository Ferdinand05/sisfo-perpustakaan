<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDTKategori;
use App\Models\ModelKategori;
use Config\Services;

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

    public function listDataKategori()
    {

        $request = Services::request();
        $datamodel = new ModelDTKategori($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnEdit = '<button type="button" class="btn btn-primary" onclick="editKategori(\'' . $list->id_kategori . '\')"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger" onclick="hapusKategori(\'' . $list->id_kategori . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->nama_kategori;
                $row[] =  $btnEdit . ' ' . $btnHapus;
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

    public function modalTambahKategori()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('kategori/modalTambahKategori')
            ];

            return $this->response->setJSON($json);
        }
    }

    public function tambahKategori()
    {
        if ($this->request->isAJAX()) {
            $kategori = $this->request->getPost('kategori');

            $validation = \Config\Services::validation();
            $validation->setRules([
                'namaKategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required|is_unique[kategori.nama_kategori]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '({value}) - Sudah Digunakan!'
                    ]
                ]
            ]);

            $data = [
                'namaKategori' => $kategori
            ];

            if (!$validation->run($data)) {
                $json = [
                    'errorKategori' => $validation->getError('namaKategori')
                ];
            } else {
                $this->kategoriModel->insert([
                    'nama_kategori' => $kategori
                ]);

                $json = [
                    'sukses' => 'Kategori Buku berhasil ditambahkan!'
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function hapusKategori()
    {
        if ($this->request->isAJAX()) {
            $id_kategori = $this->request->getPost('id_kategori');

            $this->kategoriModel->delete($id_kategori);

            $json = [
                'sukses' => 'Kategori Buku berhasil Dihapus1'
            ];

            return $this->response->setJSON($json);
        }
    }
}
