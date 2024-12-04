<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;
use App\Models\PenggunaModel;
use App\Models\RekeningModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{

    protected $user;
    protected $pengguna;
    protected $rekening;
    public function __construct() {
        $this->user = new UserModel();
        $this->pengguna = new PenggunaModel();
        $this->rekening = new RekeningModel();
    }

    public function index()
    {
        $user = $this->user->where('username', 'admin')->orWhere('role', 'admin')->first();
        if(!$user){
            $this->user->save([
                'username' => 'admin',
                'password' =>  password_hash('admin', PASSWORD_DEFAULT),
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'status' => '1', 
                'PIN' => password_hash('12345678', PASSWORD_DEFAULT)
            ]);
        }
        return view('login');
    }

    public function login(){
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->user->where('username', $username)->first(); // Cek jika pengguna ada
    
        if ($user && password_verify($password, $user->password)) { // Verifikasi password
            // Dapatkan pengguna terkait dan rekeningnya
            $datapengguna = $this->pengguna->where('user_id', $user->id)->first();
            $rekening = $this->rekening->where('pengguna_id', $datapengguna->id)->first();
    
            // Jika rekening ditemukan, simpan ke session
            if ($rekening) {
                session()->set('user', [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status,
                    'pengguna_id' => $datapengguna->id, // Simpan rekening_id untuk referensi transaksi
                    'rekening_id' => $rekening->id, // Simpan rekening_id untuk referensi transaksi
                    'login' => true,
                ]);
                log_message('info', 'Rekening Pengguna ditemukan dengan ID: ' . $rekening->id); // Debug
            } else {
                session()->set('user', [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status,
                    'login' => true,
                ]);
                log_message('info', 'Pengguna login tanpa rekening, lanjutkan proses');
            }
    
            // Arahkan pengguna berdasarkan peran mereka
            if ($user->role == 'admin') {
                return redirect()->to('/Home');
            } else {
                return redirect()->to('/Home');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Username atau password salah.');
        }
    }
    

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }

}