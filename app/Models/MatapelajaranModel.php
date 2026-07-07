<?php
namespace App\Models;
use CodeIgniter\Model;

class MatapelajaranModel extends Model
{
    protected $table            = 'matapelajaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_mapel', 'guru_id'];
}
