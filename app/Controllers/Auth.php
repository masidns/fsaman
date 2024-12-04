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

    public function login() {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->user->where('username', $username)->first(); // Cek jika pengguna ada
    
        if ($user && password_verify($password, $user->password)) { // Verifikasi password
            // Jika pengguna admin, tidak perlu cek datapengguna dan rekening
            if ($user->role == 'admin') {
                session()->set('user', [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status,
                    'login' => true,
                ]);
                log_message('info', 'Admin login berhasil.');
    
                // Redirect ke halaman admin
                return redirect()->to('/Home'); // Halaman admin
            } else {
                // Untuk pengguna biasa, cek apakah ada relasi ke tabel pengguna
                $datapengguna = $this->pengguna->where('user_id', $user->id)->first();
    
                // Pastikan datapengguna ditemukan
                if ($datapengguna) {
                    // Cek apakah rekening ada untuk pengguna
                    $rekening = $this->rekening->where('pengguna_id', $datapengguna->id)->first();
                    
                    if ($rekening) {
                        session()->set('user', [
                            'id' => $user->id,
                            'username' => $user->username,
                            'email' => $user->email,
                            'role' => $user->role,
                            'status' => $user->status,
                            'pengguna_id' => $datapengguna->id, // Simpan pengguna_id untuk referensi transaksi
                            'rekening_id' => $rekening->id, // Simpan rekening_id untuk referensi transaksi
                            'login' => true,
                        ]);
                        log_message('info', 'Pengguna dengan rekening ditemukan, login berhasil.');
                    } else {
                        // Jika rekening tidak ditemukan, beri peringatan
                        session()->set('user', [
                            'id' => $user->id,
                            'username' => $user->username,
                            'email' => $user->email,
                            'role' => $user->role,
                            'status' => $user->status,
                            'login' => true,
                        ]);
                        log_message('info', 'Pengguna tanpa rekening, login berhasil.');
                    }
    
                    // Redirect ke halaman pengguna
                    return redirect()->to('/Home'); // Halaman pengguna
                } else {
                    // Jika datapengguna tidak ditemukan
                    return redirect()->to('/')->with('error', 'Pengguna tidak ditemukan.');
                }
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