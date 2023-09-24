<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAnggota;
use App\Models\ModelDTAnggota;
use Config\Services;

class Anggota extends BaseController
{

    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new ModelAnggota();
    }

    public function index()
    {


        return view('anggota/vw_anggota');
    }


    public function listDataAnggota()
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
                $btnEdit = '<button type="button" class="btn btn-primary" onclick="editAnggota(\'' . $list->id_anggota . '\')"><i class="fa fa-user-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger" onclick="hapusAnggota(\'' . $list->id_anggota . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->nim;
                $row[] = $list->nama_anggota;
                $row[] = $list->no_telp;
                $row[] = $list->alamat_anggota;
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

    public function modalTambahAnggota()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('anggota/modalTambahAnggota')
            ];

            return $this->response->setJSON($json);
        }
    }

    public function tambahAnggota()
    {
        if ($this->request->isAJAX()) {
            $nim = $this->request->getPost('nim');
            $nama_anggota = $this->request->getPost('nama_anggota');
            $no_telp = $this->request->getPost('no_telp');
            $alamat_anggota = $this->request->getPost('alamat_anggota');


            $validation = \Config\Services::validation();
            $validation->setRules([
                'nim' => [
                    'label' => 'Nomer Induk Anggota',
                    'rules' => 'required|string|max_length[9]|is_unique[anggota.nim]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong.',
                        'max_length' => 'Maksimal {param} karakter',
                        'is_unique' => '{value} Sudah Digunakan. Tidak boleh sama'
                    ]
                ],
                'nama_anggota' => [
                    'label' => 'Nama Anggota',
                    'rules' => 'required|string',
                    'errors' => [
                        'required' => '{field} Tidak boleh Kosong.'
                    ]
                ],
                'no_telp' => [
                    'label' => 'No. Telepon',
                    'rules' => 'max_length[13]|required',
                    'errors' => [
                        'required' => '{field} Tidak boleh Kosong.',
                        'max_length' => '{field} Maksimal {param} Angka'
                    ]
                ],
                'alamat_anggota' => [
                    'label' => 'Alamat Anggota',
                    'rules' => 'string|required',
                    'errors' => [
                        'required' => '{field} Tidak boleh Kosong.'
                    ]
                ]
            ]);

            $data = [
                'nim' => $nim,
                'nama_anggota' => $nama_anggota,
                'no_telp' => $no_telp,
                'alamat_anggota' => $alamat_anggota
            ];


            if (!$validation->run($data)) {
                $json = [
                    'error' => [
                        'errorNim' => $validation->getError('nim'),
                        'errorNama' => $validation->getError('nama_anggota'),
                        'errorTelp' => $validation->getError('no_telp'),
                        'errorAlamat' => $validation->getError('alamat_anggota'),
                    ]
                ];
            } else {

                $this->anggotaModel->insert([
                    'nim' => $nim,
                    'nama_anggota' => $nama_anggota,
                    'no_telp' => $no_telp,
                    'alamat_anggota' => $alamat_anggota
                ]);

                $json = [
                    'sukses' => 'Anggota berhasil Di Tambahkan!'
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function hapusAnggota()
    {
        if ($this->request->isAJAX()) {

            $id_anggota = $this->request->getPost('id_anggota');

            $this->anggotaModel->delete($id_anggota);
            $json = [
                'sukses' => 'Anggota Berhasil Dihapus!'
            ];

            return $this->response->setJSON($json);
        }
    }

    public function modalEditAnggota()
    {
        if ($this->request->isAJAX()) {
            $id_anggota = $this->request->getPost('id_anggota');
            $dataAnggota = $this->anggotaModel->find($id_anggota);

            $data = [
                'anggota' => $dataAnggota
            ];

            $json = [
                'data' => view('anggota/modalEditAnggota', $data)
            ];


            return $this->response->setJSON($json);
        }
    }

    public function updateAnggota()
    {
        if ($this->request->isAJAX()) {
            $nim = $this->request->getPost('nim');
            $nama_anggota = $this->request->getPost('nama_anggota');
            $no_telp = $this->request->getPost('no_telp');
            $alamat_anggota = $this->request->getPost('alamat_anggota');
            $id_anggota = $this->request->getPost('id_anggota');


            $validation = \Config\Services::validation();
            $validation->setRules([
                'nim' => [
                    'label' => 'Nomer Induk Anggota',
                    'rules' => 'required|string|max_length[9]|is_unique[anggota.nim,id_anggota,' . $id_anggota . ']',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong.',
                        'max_length' => 'Maksimal {param} karakter',
                        'is_unique' => '{value} Sudah Digunakan. Tidak boleh sama'
                    ]
                ],
                'nama_anggota' => [
                    'label' => 'Nama Anggota',
                    'rules' => 'required|string',
                    'errors' => [
                        'required' => '{field} Tidak boleh Kosong.'
                    ]
                ],
                'no_telp' => [
                    'label' => 'No. Telepon',
                    'rules' => 'max_length[13]|required',
                    'errors' => [
                        'required' => '{field} Tidak boleh Kosong.',
                        'max_length' => '{field} Maksimal {param} Angka'
                    ]
                ],
                'alamat_anggota' => [
                    'label' => 'Alamat Anggota',
                    'rules' => 'string|required',
                    'errors' => [
                        'required' => '{field} Tidak boleh Kosong.'
                    ]
                ]
            ]);

            $data = [
                'nim' => $nim,
                'nama_anggota' => $nama_anggota,
                'no_telp' => $no_telp,
                'alamat_anggota' => $alamat_anggota
            ];


            if (!$validation->run($data)) {
                $json = [
                    'error' => [
                        'errorNim' => $validation->getError('nim'),
                        'errorNama' => $validation->getError('nama_anggota'),
                        'errorTelp' => $validation->getError('no_telp'),
                        'errorAlamat' => $validation->getError('alamat_anggota'),
                    ]
                ];
            } else {

                $this->anggotaModel->update($id_anggota, [
                    'nim' => $nim,
                    'nama_anggota' => $nama_anggota,
                    'no_telp' => $no_telp,
                    'alamat_anggota' => $alamat_anggota
                ]);

                $json = [
                    'sukses' => 'Anggota berhasil Di Update!'
                ];
            }

            return $this->response->setJSON($json);
        }
    }
}
