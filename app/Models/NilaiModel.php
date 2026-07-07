<?php
namespace App\Models;
use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table            = 'nilai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['siswa_id', 'mapel_id', 'nilai'];
}
