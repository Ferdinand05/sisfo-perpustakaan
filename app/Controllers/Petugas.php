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
                // $btnEdit = '<button type="button" class="btn btn-primary" onclick="editKategori(\'' . $list->id_kategori . '\')"><i class="fa fa-edit"></i></button>';
                // $btnHapus = '<button type="button" class="btn btn-danger" onclick="hapusKategori(\'' . $list->id_kategori . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->nama_kategori;
                $row[] = $list->no_telp_petugas;
                $row[] = $list->alamat_petugas;
                $row[] =  '';
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
}
