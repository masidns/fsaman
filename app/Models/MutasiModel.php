<?php

namespace App\Models;

use CodeIgniter\Model;

class MutasiModel extends Model
{
    protected $table            = 'mutasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanggal_mutasi',
        'jenis_transaksi',
        'nominal',
        'saldo_sebelum',
        'saldo_setelah',
        'rekening_id',
        'transaksi_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getMutasi($rekening_id){
        return $this->db->table('mutasi')
        ->select('mutasi.*, transaksi.*, transaksi.jenis_transaksi AS jenis, mutasi.jenis_transaksi AS jenis_mutasi')
        ->join('transaksi', 'transaksi.id = mutasi.transaksi_id')
        ->where('mutasi.rekening_id', $rekening_id)
        ->orderBy('transaksi_id', 'DESC')
        ->get()->getResult();
    }

    public function getsaldo($rekening_id)
    {
    return $this->db->table('mutasi') 
        ->where('rekening_id', $rekening_id)
        ->orderBy('transaksi_id', 'DESC')
        ->limit(1)  // Ambil hanya satu mutasi terbaru
        ->get()
        ->getRow();
    }

        // Get saldo before the payment
        public function getSaldoSebelum($rekeningId)
        {
            // Fetch the last mutation record for the given rekening_id
            $mutasi = $this->where('rekening_id', $rekeningId)
                           ->orderBy('id', 'DESC')
                           ->first();
            
            return $mutasi ? $mutasi->saldo_setelah : 0;
        }
    
        // Get saldo after the payment
        public function getSaldoSetelah($rekeningId, $nominal)
        {
            // Get saldo before, then subtract the nominal from it
            $saldoSebelum = $this->getSaldoSebelum($rekeningId);
            return $saldoSebelum - $nominal;
        }
    
}