<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenistagihanModel;
use App\Models\PelayananModel;
use App\Models\PenyediaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Jenis extends BaseController
{
    protected $jenis;
    protected $pelayanan;
    public function __construct() {
        $this->jenis = new JenistagihanModel();
        $this->pelayanan = new PenyediaModel();
    }
    public function index()
    {
        $data = [
            'title' => 'jenis tagihan',
            'data' => $this->jenis->findAll(),
        ];
        return view('/admin/jenis/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'jenis tagihan',
        ];
        return view('/admin/jenis/tambah', $data);
    }

    public function save() {
        $this->jenis->save([
            'nama_tagihan' =>$this->request->getVar('nama_tagihan'),
            'deskripsi' =>$this->request->getVar('deskripsi'),
        ]);
        return redirect()->to('/jenis')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function detail($id) {
        $data = [
            'title' => 'jenis tagihan',
            'item' => $this->jenis->find($id),
            'jenis' => $this->jenis->findAll(),
            'data' => $this->pelayanan->where('jenistagihan_id', $id)->findAll(),
        ];
        return view('/admin/jenis/detail', $data);
    }

    public function detailsave()  {
        $this->pelayanan->save([
            'jenistagihan_id' => $this->request->getVar('jenistagihan_id'),
            'nama_penyedia' => $this->request->getVar('nama_penyedia'),
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        
    }
}
