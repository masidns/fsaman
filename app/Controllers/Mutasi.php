<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MutasiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Mutasi extends BaseController
{

    protected $mutasi;
    public function __construct() {
        $this->mutasi =new MutasiModel();
    }
    public function index()
    {
        $rekening_id = session()->get('user')['rekening_id'];

        $mutasi = $this->mutasi->getMutasi($rekening_id);
        // dd($mutasi);
        $saldo = $this->mutasi->getsaldo($rekening_id);
        // dd($saldo);

        $data =[
            'title' => 'Mutasi',
            'mutasi' => $mutasi,
            'saldo' => $saldo,
        ];
        // dd($data);
        return view('/pengguna/mutasi/index', $data);
    }
}
