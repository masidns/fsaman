<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MutasiModel;
use App\Models\PenggunaModel;
use App\Models\RekeningModel;
use App\Models\TransasksiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pengguna extends BaseController
{

    protected $pengguna;
    protected $user;
    protected $rekening;
    protected $transaksi;
    protected $mutasi;
    // public function __construct () {
    //     $this->pengguna = new PenggunaModel();
    //     $this->user = new UserModel();
    //     $this->rekening = new RekeningModel();
    //     $this->transaksi = new TransasksiModel();
    //     $this->mutasi = new MutasiModel();
    // }

    public function __construct()
    {
        $this->pengguna = new PenggunaModel();
        $this->user = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pengguna',
            'data' => $this->pengguna->getPengguna(),
        ];
        return view('admin/pengguna/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Pengguna',
        ];

        return view('admin/pengguna/pengguna_tambah', $data);
    }

    public function save()
    {
        $user = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getVar('email'),
            'role' => 'pengguna',
            'status' => '1',
            'PIN' => password_hash($this->request->getVar('PIN'), PASSWORD_DEFAULT),
        ];
        $this->user->save($user);
        $user_id = $this->user->getInsertID();

        $pengguna = [
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'tanggal_daftar' => date('Y-m-d'),
            'user_id' => $user_id,
        ];
        $this->pengguna->save($pengguna);

        session()->set('pengguna_id', $this->pengguna->getInsertID());
        return redirect()->to('/rekening/tambah')->with('success', 'Data pengguna berhasil disimpan. Lanjutkan ke rekening.');
    }
    
}