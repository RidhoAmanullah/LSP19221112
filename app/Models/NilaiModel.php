<?php
namespace App\Models;
use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table            = 'nilai_seleksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['calon_id', 'mata_uji_id', 'nilai'];
}
