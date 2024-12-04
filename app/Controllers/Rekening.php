<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Rekening extends BaseController
{
    protected $rekening;

    public function __construct()
    {
        $this->rekening = new \App\Models\RekeningModel();
    }

    public function tambah()
    {
        return view('admin/rekening/tambah', ['title' => 'Tambah Rekening']);
    }

    public function save()
    {
        $pengguna_id = session()->get('pengguna_id');
        if (!session()->has('pengguna_id')) {
            return redirect()->to('/pengguna/tambah')->with('error', 'Session pengguna tidak ditemukan. Mulai dari awal.');
        }
        

        $rekening = [
            'pengguna_id' => $pengguna_id,
            'nomor_rekening' => $this->request->getVar('nomor_rekening'),
            'bank' => $this->request->getVar('bank'),
            'tipe' => $this->request->getVar('tipe'),
            'saldo' => 0,
        ];
        $this->rekening->save($rekening);

        session()->set('rekening_id', $this->rekening->getInsertID());
        return redirect()->to('/transaksi/tambah')->with('success', 'Data rekening berhasil disimpan. Lanjutkan ke transaksi.');
    }
}
