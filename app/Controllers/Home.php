<?php

namespace App\Controllers;

class Home extends BaseController
{
    // public function index(): string
    // {
    //     return view('welcome_message');
    // }

    public function Home(): string
    {
        if (!session()->get('user.login')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $data = [
            'title' => 'Halaman dashboard',
        ];
        return view('home', $data);
    }
}
