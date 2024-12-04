<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\PenyediaModel;
use App\Models\TagihanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Tagihan extends BaseController
{

    protected $tagihan;
    protected $pengguna;
    protected $penyedia;
    public function __construct() {
        $this->tagihan = new TagihanModel();
        $this->pengguna = new PenggunaModel();
        $this->penyedia = new PenyediaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tagihan',
            'data' => $this->tagihan->getTagihan(),
            'pengguna' => $this->pengguna->findAll(),
            'penyedia' => $this->penyedia->findAll(),
        ];
        return view('/admin/tagihan/index', $data);
    }

    public function save(){
        $nomor_tagihan = random_int(10000000, 99999999);
        $this->tagihan->save([
            'nomor_tagihan' => $nomor_tagihan,
            'pengguna_id' => $this->request->getVar('pengguna_id'),
            'penyedia_id' => $this->request->getVar('penyedia_id'),
            'jumlah_tagihan' => $this->request->getVar('jumlah_tagihan'),
            'status_pembayaran' => 'Belum Lunas',
            'tempo' => $this->request->getVar('tempo'),
        ]);
        // dd($data);
        return redirect()->to('/tagihan')->with('success', 'Tagihan Berhasil Dibuat');
    }
}
