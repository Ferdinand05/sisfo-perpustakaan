<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDTPetugas;
use App\Models\ModelPetugas;
use Config\Services;

class Petugas extends BaseController
{

    protected $petugasModel;
    public function __construct()
    {
        $this->petugasModel = new ModelPetugas();
    }

    public function index()
    {


        return view('petugas/vw_petugas');
    }

    public function listDataPetugas()
    {

        $request = Services::request();
        $datamodel = new ModelDTPetugas($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnEdit = '<button type="button" class="btn btn-primary" onclick="editPetugas(\'' . $list->id_petugas . '\')"><i class="fa fa-user-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger" onclick="hapusPetugas(\'' . $list->id_petugas . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->nama_petugas;
                $row[] = $list->no_telp_petugas;
                $row[] = $list->alamat_petugas;
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

    public function modalTambahPetugas()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('petugas/modalTambahPetugas')
            ];


            return $this->response->setJSON($json);
        }
    }

    public function insertPetugas()
    {
        if ($this->request->isAJAX()) {
            $nama_petugas = $this->request->getPost('nama_petugas');
            $telp_petugas = $this->request->getPost('telp_petugas');
            $alamat_petugas = $this->request->getPost('alamat_petugas');

            $data = [
                'nama_petugas' => $nama_petugas,
                'telp_petugas' => $telp_petugas,
                'alamat_petugas' => $alamat_petugas
            ];

            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_petugas' => [
                    'label' => 'Nama Petugas',
                    'rules' => 'string|required|',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'telp_petugas' => [
                    'label' => 'No Telepon',
                    'rules' => 'required|max_length[14]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'max_length' => 'Maksimal {param} Angka'
                    ]
                ],
                'alamat_petugas' => [
                    'label' => 'Alamat Petugas',
                    'rules' => 'string|required',
                    'errors' => [
                        'required' => '{field} Harus Disi!'
                    ]
                ]
            ]);

            if (!$validation->run($data)) {
                $json = [
                    'error' => [
                        'errorNama' => $validation->getError('nama_petugas'),
                        'errorTelp' => $validation->getError('telp_petugas'),
                        'errorAlamat' => $validation->getError('alamat_petugas'),
                    ]
                ];
            } else {

                $this->petugasModel->insert([
                    'nama_petugas' => $nama_petugas,
                    'no_telp_petugas' => $telp_petugas,
                    'alamat_petugas' => $alamat_petugas
                ]);

                $json = [
                    'sukses' => 'Data Petugas Berhasil Ditambahkan!'
                ];
            }

            return $this->response->setJSON($json);
        } else {
            exit('Tidak bisa diakses');
        }
    }


    public function modalEditPetugas()
    {
        if ($this->request->isAJAX()) {

            $id_petugas = $this->request->getPost('id_petugas');
            $data = [
                'petugas' => $this->petugasModel->find($id_petugas)
            ];


            $json = [
                'data' => view('petugas/modalEditPetugas', $data)
            ];


            return $this->response->setJSON($json);
        }
    }

    public function updatePetugas()
    {
        if ($this->request->isAJAX()) {
            $nama_petugas = $this->request->getPost('nama_petugas');
            $telp_petugas = $this->request->getPost('telp_petugas');
            $alamat_petugas = $this->request->getPost('alamat_petugas');
            $id_petugas = $this->request->getPost('id_petugas');

            $data = [
                'nama_petugas' => $nama_petugas,
                'telp_petugas' => $telp_petugas,
                'alamat_petugas' => $alamat_petugas
            ];

            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_petugas' => [
                    'label' => 'Nama Petugas',
                    'rules' => 'string|required|',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'telp_petugas' => [
                    'label' => 'No Telepon',
                    'rules' => 'required|max_length[14]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'max_length' => 'Maksimal {param} Angka'
                    ]
                ],
                'alamat_petugas' => [
                    'label' => 'Alamat Petugas',
                    'rules' => 'string|required',
                    'errors' => [
                        'required' => '{field} Harus Disi!'
                    ]
                ]
            ]);

            if (!$validation->run($data)) {
                $json = [
                    'error' => [
                        'errorNama' => $validation->getError('nama_petugas'),
                        'errorTelp' => $validation->getError('telp_petugas'),
                        'errorAlamat' => $validation->getError('alamat_petugas'),
                    ]
                ];
            } else {

                $this->petugasModel->update($id_petugas, [
                    'nama_petugas' => $nama_petugas,
                    'no_telp_petugas' => $telp_petugas,
                    'alamat_petugas' => $alamat_petugas
                ]);

                $json = [
                    'sukses' => 'Data Petugas Berhasil DiUpdate!'
                ];
            }

            return $this->response->setJSON($json);
        } else {
            exit('Tidak bisa diakses');
        }
    }

    public function hapusPetugas()
    {
        if ($this->request->isAJAX()) {
            $id_petugas = $this->request->getPost('id_petugas');

            $this->petugasModel->delete($id_petugas);

            $json = [
                'sukses' => 'Data Petugas Berhasil Dihapus!'
            ];


            return $this->response->setJSON($json);
        }
    }
}
