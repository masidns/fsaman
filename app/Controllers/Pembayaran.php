<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MutasiModel;
use App\Models\TagihanModel;
use App\Models\PenyediaModel;
use App\Models\RekeningModel;
use App\Models\TransasksiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pembayaran extends BaseController
{
    protected $tagihan;
    protected $penyedia;
    protected $rekening;
    protected $mutasi;
    protected $transaksi;

    public function __construct()
    {
        $this->tagihan = new TagihanModel();
        $this->penyedia = new PenyediaModel(); // Model Penyedia
        $this->rekening = new RekeningModel();
        $this->mutasi = new MutasiModel();
        $this->transaksi = new TransasksiModel();
    }

    // Menampilkan halaman utama pembayaran
    public function index()
    {
        // Ambil data penyedia untuk jenis tagihan
        $jenisTagihan = $this->penyedia->findAll();

        $data = [
            'title' => 'Pembayaran Tagihan',
            'jenis_tagihan' => $jenisTagihan, // Daftar penyedia yang ada
        ];
        return view('pengguna/pembayaran/index', $data);
    }

    // Proses cek tagihan berdasarkan nomor tagihan yang dimasukkan
    public function cekTagihan()
    {
        // Mengambil penyedia_id dan nomor_tagihan dari form
        $penyediaId = $this->request->getPost('penyedia_id');
        $nomorTagihan = $this->request->getPost('nomor_tagihan');

        // Cari tagihan berdasarkan penyedia_id dan nomor_tagihan dengan join ke tabel penyedia
        // Check if the tagihan exists and the status field is included in the query result
        $tagihan = $this->tagihan->select('tagihan.id, tagihan.nomor_tagihan, tagihan.jumlah_tagihan, tagihan.status_pembayaran, penyedia.nama_penyedia')
        ->join('penyedia', 'penyedia.id = tagihan.penyedia_id')
        ->where('penyedia.id', $penyediaId)
        ->where('tagihan.nomor_tagihan', $nomorTagihan)
        ->first();

        // Debug the result
        log_message('info', print_r($tagihan, true));

        // Check if the tagihan exists
        if (!$tagihan) {
        return redirect()->back()->with('error', 'Tagihan tidak ditemukan.');
        }

// Check if the tagihan is already paid
if (isset($tagihan->status_pembayaran) && $tagihan->status_pembayaran == 'Lunas') {
return redirect()->back()->with('info', 'Tagihan sudah lunas.');
}

// Continue with the rest of the logic for pembayaran


        // Ambil saldo pengirim dari mutasi terakhir
        $rekeningPengirimId = session()->get('user')['rekening_id'];
        $mutasiPengirim = $this->mutasi->where('rekening_id', $rekeningPengirimId)
                                       ->orderBy('tanggal_mutasi', 'DESC')
                                       ->first();
        $saldoPengirim = $mutasiPengirim ? $mutasiPengirim->saldo_setelah : 0;

        // Cek apakah saldo mencukupi untuk membayar tagihan
        if ($saldoPengirim < $tagihan->jumlah_tagihan) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk membayar tagihan.');
        }

        // Proses pembayaran tagihan
        $this->bayarTagihan($rekeningPengirimId, $tagihan);

        return redirect()->to('/pembayaran/konfirmasi')->with('success', 'Pembayaran tagihan berhasil.');
    }

    // Fungsi untuk melakukan pembayaran tagihan
    // Fungsi untuk melakukan pembayaran tagihan
    private function bayarTagihan($rekeningPengirimId, $tagihan)
{
    // Mulai transaksi database
    $db = \Config\Database::connect();
    $db->transStart();
    
    // Check if the tagihan exists
    if (!$tagihan) {
        return redirect()->back()->with('error', 'Tagihan tidak ditemukan.');
    }

    // Check if the tagihan is already paid
    if ($tagihan->status_pembayaran == 'Lunas') {
        return redirect()->back()->with('info', 'Tagihan sudah lunas.');
    }
    
    // Tambahkan transaksi baru ke tabel transaksi
    $transaksiData = [
        'jenis_transaksi' => 'Pembayaran Tagihan',
        'nominal' => $tagihan->jumlah_tagihan,
        'tanggal' => date('Y-m-d'),
        'status' => 'Berhasil',
        'pengguna_id' => session()->get('user')['pengguna_id'],
        'rekening_id' => $rekeningPengirimId,
        'deskripsi' => 'Pembayaran untuk nomor tagihan: ' . $tagihan->nomor_tagihan
    ];
    $this->transaksi->save($transaksiData);
    $transaksiId = $this->transaksi->insertID();

    // Update saldo pengirim
    $saldoSebelum = $this->mutasi->getSaldoSebelum($rekeningPengirimId);  // Mendapatkan saldo sebelum
    $saldoSetelah = $this->mutasi->getSaldoSetelah($rekeningPengirimId, $tagihan->jumlah_tagihan);  // Mendapatkan saldo setelah

    $mutasiData = [
        'rekening_id' => $rekeningPengirimId,
        'transaksi_id' => $transaksiId,
        'tanggal_mutasi' => date('Y-m-d'),
        'jenis_transaksi' => 'Debet',
        'nominal' => $tagihan->jumlah_tagihan,
        'saldo_sebelum' => $saldoSebelum,
        'saldo_setelah' => $saldoSetelah,
    ];
    $this->mutasi->save($mutasiData);

    // Update status tagihan menjadi Lunas
    $this->tagihan->update($tagihan->id, ['status_pembayaran' => 'Lunas']);

    // Commit transaksi database
    $db->transComplete();
}

public function konfirmasi()
{
    $data = [
        'title' => 'Konfirmasi Pembayaran',
    ];
    return view('pengguna/pembayaran/konfirmasi', $data);
}


    

}