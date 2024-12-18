<?php

namespace App\Models;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    protected $table            = 'rekening';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pengguna_id',
        'nomor_rekening',
        'bank',
        'tipe',
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

    public function getRekeningWithOwner($nomorRekening)
    {
        return $this->select('rekening.*, pengguna.nama AS nama_pemilik')
                    ->join('pengguna', 'pengguna.id = rekening.pengguna_id', 'left')
                    ->where('rekening.nomor_rekening', $nomorRekening)
                    ->get()
                    ->getRowObject(); // Mengembalikan satu baris sebagai objek
    }

    public function findObject($id)
{
    return $this->where('id', $id)->get()->getRowObject();
}

public function getRekeningByNomor($nomorRekening)
{
    return $this->select('rekening.*, pengguna.nama AS nama_pemilik')
                ->join('pengguna', 'pengguna.id = rekening.pengguna_id', 'left')
                ->where('rekening.nomor_rekening', $nomorRekening)
                ->get()
                ->getRowObject();  // Mengembalikan objek
}



}