<?php
namespace App\Models;
use CodeIgniter\Model;

class CalonModel extends Model
{
    protected $table            = 'calon_mahasiswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nomor_pendaftaran', 'nama', 'email', 'tanggal_lahir', 'asal_sekolah', 'prodi_id', 'status_seleksi', 'password'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
