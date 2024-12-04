<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Transaksi extends BaseController
{
    protected $transaksi;
    protected $mutasi;
    protected $rekening;

    public function __construct()
    {
        $this->transaksi = new \App\Models\TransasksiModel();
        $this->mutasi = new \App\Models\MutasiModel();
        $this->rekening = new \App\Models\RekeningModel();
    }

    public function tambah()
    {
        return view('admin/transaksi/tambah', ['title' => 'Tambah Transaksi']);
    }

    public function save()
    {
        $pengguna_id = session()->get('pengguna_id');
        if (!$pengguna_id) {
            return redirect()->to('/pengguna')->with('error', 'Session pengguna tidak ditemukan. Mulai dari awal.');
        }

        $rekening_id = session()->get('rekening_id');
        if (!$rekening_id) {
            return redirect()->to('/rekening/tambah')->with('error', 'Session rekening tidak ditemukan. Mulai dari awal.');
        }

        $nominal = $this->request->getVar('nominal');

        // Ambil saldo terakhir dari mutasi
        $mutasiTerakhir = $this->mutasi
            ->where('rekening_id', $rekening_id)
            ->orderBy('tanggal_mutasi', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();

        $saldo_sebelum = $mutasiTerakhir ? $mutasiTerakhir->saldo_setelah : 0;


        // Hitung saldo setelah transaksi
        $saldo_setelah = $saldo_sebelum + $nominal;

        // Simpan transaksi
        $this->transaksi->save([
            'rekening_id' => $rekening_id,
            'pengguna_id' => $pengguna_id,
            'jenis_transaksi' => 'Pembayaran',
            'nominal' => $nominal,
            'tanggal' => date('Y-m-d'),
            'status' => 'Berhasil',
            'deskripsi' => 'Saldo Awal',
        ]);

        $transaksi_id = $this->transaksi->getInsertID();

        // Simpan mutasi
        $this->mutasi->save([
            'rekening_id' => $rekening_id,
            'transaksi_id' => $transaksi_id,
            'tanggal_mutasi' => date('Y-m-d'),
            'nominal' => $nominal,
            'saldo_sebelum' => $saldo_sebelum,
            'saldo_setelah' => $saldo_setelah,
            'jenis_transaksi' => 'Kredit',
        ]);

        // Perbarui saldo rekening
        // $this->rekening->update($rekening_id, ['saldo' => $saldo_setelah]);

        // Hapus session
        session()->remove('pengguna_id');
        session()->remove('rekening_id');

        return redirect()->to('/pengguna')->with('success', 'Transaksi berhasil disimpan.');
    }
}
