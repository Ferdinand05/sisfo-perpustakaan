<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBuku;
use App\Models\ModelDTBuku;
use App\Models\ModelKategori;
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
                $btnDetail = '<button type="button" class="btn btn-info" onclick="detailBuku(\'' . $list->id_buku . '\')"><i class="fa fa-info-circle"></i></button>';
                $btnSampul = '<button type="button" class="btn btn-success" onclick="sampulBuku(\'' . $list->id_buku . '\')"><i class="fas fa-images"></i></button>';
                $row[] = $no;
                $row[] = strtoupper($list->kode_buku);
                $row[] = $list->judul_buku;
                $row[] = $list->nama_kategori;
                $row[] = $list->stok;
                $row[] =  $btnDetail . " " . $btnEdit . " " . $btnSampul  .  " " . $btnHapus;
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

            $kategoriModel = new ModelKategori();
            $data = [
                'kategori' => $kategoriModel->findAll()
            ];

            $json = [
                'data' => view('buku/modalTambahBuku', $data)
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
            $kategori = $this->request->getPost('kategori_buku');


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
                'kategori_buku' => [
                    'label' => 'Kategori Buku',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ]
            ]);

            $data = [
                'kode_buku' => $kode_buku,
                'judul_buku' => $judul,
                'penulis_buku' => $penulis,
                'penerbit' => $penerbit,
                'tahun_terbit' => $tahun_terbit,
                'stok_buku' => $stok_buku,
                'kategori_buku' => $kategori
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
                        'errorKategori' => $validation->getError('kategori_buku')
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
                    'buku_katid' => $kategori
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

    public function modalEditBuku()
    {
        if ($this->request->isAJAX()) {

            $id_buku =  $this->request->getPost('id_buku');
            $kategoriModel = new ModelKategori();
            $dataBuku = $this->bukuModel->find($id_buku);
            $selectedKategori = $kategoriModel->find($dataBuku['buku_katid']);
            $data = [
                'kategori' => $kategoriModel->findAll(),
                'selectedKategori' => $selectedKategori['nama_kategori'],
                'buku' => $dataBuku
            ];

            $json = [
                'data' => view('buku/modalEditBuku', $data)
            ];
        }

        return $this->response->setJSON($json);
    }


    public function updateBuku()
    {
        if ($this->request->isAJAX()) {
            $kode_buku = $this->request->getPost('kode_buku');
            $judul = $this->request->getPost('judul_buku');
            $penulis = $this->request->getPost('penulis_buku');
            $penerbit = $this->request->getPost('penerbit');
            $tahun_terbit = $this->request->getPost('tahun_terbit');
            $stok_buku = $this->request->getPost('stok_buku');
            $kategori = $this->request->getPost('kategori_buku');
            $id_buku = $this->request->getPost('id_buku');


            $validation = \Config\Services::validation();
            $validation->setRules([
                'kode_buku' => [
                    'label' => 'Kode Buku',
                    'rules' => 'required|string|max_length[5]|is_unique[buku.kode_buku,id_buku,' . $id_buku . ']',
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
                'kategori_buku' => [
                    'label' => 'Kategori Buku',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ]
            ]);

            $data = [
                'kode_buku' => $kode_buku,
                'judul_buku' => $judul,
                'penulis_buku' => $penulis,
                'penerbit' => $penerbit,
                'tahun_terbit' => $tahun_terbit,
                'stok_buku' => $stok_buku,
                'kategori_buku' => $kategori
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
                        'errorKategori' => $validation->getError('kategori_buku')
                    ]
                ];
            } else {


                $this->bukuModel->update($id_buku, [
                    'kode_buku' => $kode_buku,
                    'judul_buku' => $judul,
                    'penulis_buku' => $penulis,
                    'penerbit_buku' => $penerbit,
                    'tahun_penerbit' => $tahun_terbit,
                    'stok' => $stok_buku,
                    'buku_katid' => $kategori
                ]);

                $json = [
                    'sukses' => 'Buku Berhasil DiUpdate!'
                ];
            }
            return $this->response->setJSON($json);
        } else {
            exit('Tidak Bisa Diakses!');
        }
    }



    public function modalDetailBuku()
    {
        if ($this->request->isAJAX()) {
            $id_buku = $this->request->getPost('id_buku');
            $kategoriModel = new ModelKategori();
            $buku = $this->bukuModel->find($id_buku);
            $kategori = $kategoriModel->find($buku['buku_katid']);
            $data = [
                'buku' => $buku,
                'kategori' => $kategori
            ];

            $json = [
                'data' => view('buku/modalDetailBuku', $data)
            ];

            return $this->response->setJSON($json);
        }
    }

    public function modalSampulBuku()
    {
        $id_buku = $this->request->getPost('id_buku');
        $data = [
            'id_buku' => $id_buku
        ];
        $json = [
            'data' => view('buku/modalSampulBuku', $data)
        ];

        return $this->response->setJSON($json);
    }

    public function uploadSampul()
    {
        if ($this->request->isAJAX()) {
            $id_buku = $this->request->getVar('idBuku');
            $dataBuku = $this->bukuModel->find($id_buku);

            $validation = \Config\Services::validation();

            $validation->setRules([
                'sampulBuku' => [
                    'label' => 'Cover/Sampul Buku',
                    'rules' => 'uploaded[sampulBuku]|mime_in[sampulBuku,image/png,image/jpg,image/jpeg]|is_image[sampulBuku]',
                    'errors' => [
                        'uploaded' => '{field} Tidak Boleh Kosong!',
                        'mime_in' => 'Format Harus dalam Bentuk Gambar!'
                    ]
                ]
            ]);

            $sampul = $this->request->getFile('sampulBuku');
            $data = [
                'sampulBuku' => $sampul
            ];

            if (!$validation->run($data)) {
                // invalid
                $json = [
                    'error' => [
                        'errorSampul' => $validation->getError('sampulBuku')

                    ]
                ];
            } else {
                // valid
                $oldSampul = $dataBuku['sampul'];
                $namaSampul = $dataBuku['kode_buku'] . '.' . $sampul->getExtension();
                if ($namaSampul == $oldSampul) {
                    unlink('images/' . $oldSampul);
                    $sampul->move('images', $namaSampul);
                    $fileSampul = $sampul->getName();
                } else {
                    $sampul->move('images', $namaSampul);
                    $fileSampul = $sampul->getName();
                }


                $this->bukuModel->update($id_buku, [
                    'sampul' => $fileSampul
                ]);

                $json = [
                    'sukses' => 'Gambar berhasil di Upload!'
                ];
            }
            return $this->response->setJSON($json);
        }
    }
}
