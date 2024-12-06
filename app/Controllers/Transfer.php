<?php

namespace App\Controllers;

use App\Models\RekeningModel;
use App\Models\MutasiModel;
use App\Models\TransasksiModel;
use CodeIgniter\Controller;

class Transfer extends BaseController
{
    protected $rekeningModel;
    protected $mutasiModel;
    protected $transaksi;

    public function __construct()
    {
        $this->rekeningModel = new RekeningModel();
        $this->mutasiModel = new MutasiModel();
        $this->transaksi = new TransasksiModel();
    }

    public function index()
    {
        return view('pengguna/transfer/index', [
            'title' => 'Transfer Dana'
        ]);
    }

    public function cekRekening()
{
    try {
        $nomorRekening = $this->request->getVar('nomor_rekening');  // Nomor rekening yang dimasukkan

        // Log untuk memeriksa request method
        log_message('info', 'Request Method: ' . $this->request->getMethod());

        // Debugging log untuk memastikan data yang dikirim benar
        log_message('info', 'Nomor rekening yang dimasukkan: ' . $nomorRekening);

        // Cari rekening berdasarkan nomor
        $rekeningTujuan = $this->rekeningModel->getRekeningByNomor($nomorRekening);

        // Debugging log untuk memastikan query berhasil
        log_message('info', 'Rekening Tujuan: ' . json_encode($rekeningTujuan));

        if ($rekeningTujuan) {
            // Jika rekening ditemukan, arahkan ke form transfer dengan data rekening tujuan
            return view('pengguna/transfer/form', [
                'title' => 'Form Transfer',
                'rekeningTujuan' => $rekeningTujuan,
            ]);
        } else {
            // Jika rekening tidak ditemukan, kembalikan ke halaman input dengan pesan error
            return redirect()->to('/transfer')->with('error', 'Nomor rekening tidak ditemukan.');
        }
    } catch (\Exception $e) {
        log_message('error', 'Terjadi error: ' . $e->getMessage());
        return redirect()->to('/transfer')->with('error', 'Terjadi kesalahan saat memproses permintaan.');
    }
}


public function prosesTransfer()
{
    try {
        // Ambil rekening pengirim dari session
        $rekeningPengirimId = session()->get('user')['rekening_id'];
        if (!$rekeningPengirimId) {
            log_message('error', 'Rekening pengirim tidak ditemukan di session');
            return redirect()->to('/transfer')->with('error', 'Rekening pengirim tidak ditemukan.');
        }

        // Ambil data yang diperlukan dari form
        $nomorRekeningTujuan = $this->request->getVar('rekening_tujuan'); // Rekening tujuan
        $nominal = $this->request->getVar('nominal'); // Nominal transfer

        // Log untuk memeriksa data yang diterima
        log_message('info', 'Data transfer: Pengirim ID: ' . $rekeningPengirimId . ', Tujuan: ' . $nomorRekeningTujuan . ', Nominal: ' . $nominal);

        // Ambil rekening pengirim dan penerima
        $rekeningPengirim = $this->rekeningModel->find($rekeningPengirimId);
        $rekeningTujuan = $this->rekeningModel->getRekeningByNomor($nomorRekeningTujuan);

        // Validasi rekening pengirim
        if (!$rekeningPengirim) {
            log_message('error', 'Rekening pengirim tidak ditemukan: ' . $rekeningPengirimId);
            return redirect()->to('/transfer')->with('error', 'Rekening pengirim tidak ditemukan.');
        }

        // Validasi rekening tujuan
        if (!$rekeningTujuan) {
            log_message('error', 'Rekening tujuan tidak ditemukan: ' . $nomorRekeningTujuan);
            return redirect()->back()->with('error', 'Rekening tujuan tidak ditemukan.');
        }

        // Ambil saldo terakhir pengirim dari mutasi
        $mutasiPengirim = $this->mutasiModel->where('rekening_id', $rekeningPengirimId)
                                            ->orderBy('id', 'DESC')
                                            ->first();
        $saldoPengirim = $mutasiPengirim ? $mutasiPengirim->saldo_setelah : 0;  // Jika tidak ada mutasi, saldo 0

        // Log untuk memeriksa saldo pengirim sebelum transfer
        log_message('info', 'Saldo pengirim sebelum transfer: ' . $saldoPengirim);

        // Cek apakah saldo pengirim mencukupi
        if ($saldoPengirim < $nominal) {
            log_message('error', 'Saldo pengirim tidak mencukupi: ' . $saldoPengirim);
            return redirect()->to('/transfer')->with('error', 'Saldo tidak mencukupi untuk melakukan transfer.');
        }

        // Ambil saldo terakhir penerima dari mutasi
        $mutasiPenerima = $this->mutasiModel->where('rekening_id', $rekeningTujuan->id)
                                            ->orderBy('id', 'DESC')
                                            ->first();
        $saldoPenerima = $mutasiPenerima ? $mutasiPenerima->saldo_setelah : 0;  // Jika tidak ada mutasi, saldo 0

        // Log untuk memeriksa saldo penerima sebelum transfer
        log_message('info', 'Saldo penerima sebelum transfer: ' . $saldoPenerima);

        // Mulai transaksi database
        $db = \Config\Database::connect();
        $db->transStart();

        // Tambahkan transaksi baru ke tabel transaksi
        $transaksiData = [
            'jenis_transaksi' => 'Transfer',
            'nominal' => $nominal,
            'tanggal' => date('Y-m-d'),
            'status' => 'Berhasil', // Status transaksi
            'pengguna_id' => session()->get('user')['pengguna_id'],
            'rekening_id' => $rekeningPengirim->id,
            'deskripsi' => 'Transfer ke rekening: ' . $nomorRekeningTujuan
        ];
        
        // Simpan transaksi
        $this->transaksi->save($transaksiData);
        
        // Ambil Insert ID transaksi yang baru saja disimpan
        $transaksiId = $this->transaksi->insertID();

        // Update saldo pengirim
        $newSaldoPengirim = $saldoPengirim - $nominal;
        log_message('info', 'Saldo pengirim setelah transfer: ' . $newSaldoPengirim);  // Periksa saldo pengirim setelah transaksi
        $this->mutasiModel->save([
            'rekening_id' => $rekeningPengirim->id,
            'transaksi_id' => $transaksiId, // Menghubungkan mutasi dengan transaksi
            'tanggal_mutasi' => date('Y-m-d'),
            'jenis_transaksi' => 'Debet',
            'nominal' => $nominal,
            'saldo_sebelum' => $saldoPengirim,
            'saldo_setelah' => $newSaldoPengirim,
        ]);

        // Update saldo penerima
        $newSaldoPenerima = $saldoPenerima + $nominal;
        log_message('info', 'Saldo penerima setelah transfer: ' . $newSaldoPenerima);  // Periksa saldo penerima setelah transaksi
        $this->mutasiModel->save([
            'rekening_id' => $rekeningTujuan->id,
            'transaksi_id' => $transaksiId, // Menghubungkan mutasi dengan transaksi
            'tanggal_mutasi' => date('Y-m-d H:i:s'),
            'jenis_transaksi' => 'Kredit',
            'nominal' => $nominal,
            'saldo_sebelum' => $saldoPenerima,
            'saldo_setelah' => $newSaldoPenerima,
        ]);

        // Commit transaksi database
        $db->transComplete();

        // Pengalihan berdasarkan sesi pengguna
        if (session()->get('role') == 'admin') {
            log_message('info', 'Transfer berhasil, admin redirect ke dashboard.');
            return redirect()->to('/Home')->with('success', 'Transfer berhasil dilakukan.');
        } else {
            log_message('info', 'Transfer berhasil, pengguna redirect ke dashboard.');
            return redirect()->to('/Home')->with('success', 'Transfer berhasil dilakukan.');
        }
    } catch (\Exception $e) {
        log_message('error', 'Terjadi error saat proses transfer: ' . $e->getMessage());
        return redirect()->to('/transfer')->with('error', 'Terjadi kesalahan saat memproses transfer.');
    }
}




}