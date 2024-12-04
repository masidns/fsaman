<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;
use App\Models\PenggunaModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{

    protected $user;
    protected $pengguna;
    public function __construct() {
        $this->user = new UserModel();
        $this->pengguna = new PenggunaModel();
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
        $user = $this->user->where('username', $username)->first();

        if($user){
            $user_id = $user->id;
            $datapengguna = $this->pengguna->where('user_id', $user_id)->first();
            if(password_verify($password, $user->password)){
                if(!isset($datapengguna->id)){
                    session()->set('user',[
                        'id' => $user->id,
                        'username' => $user->username,
                        // 'password' => $user->password,
                        'email' => $user->email,
                        'role' => $user->role,
                        'status' => $user->status,
                        'login' => true,
                    ]);
                }else {
                    session()->set('user',[
                        'id' => $user->id,
                        'username' => $user->username,
                        'pengguna_id' => $datapengguna->id,
                        'email' => $user->email,
                        'role' => $user->role,
                        'status' => $user->status,
                        'login' => true,
                    ]);
                }
                if ($user->role === 'admin') {
                    return redirect()->to('/pengguna');
                } else {
                    return redirect()->to('/Dashboard');
                }
                return redirect()->to('/Home');
            }else {
                return redirect()->to('/')->with('error', 'Password salah');
            }
        }else {
            return redirect()->to('/')->with('error', 'Username tidak ditemukan');
        }
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }

}