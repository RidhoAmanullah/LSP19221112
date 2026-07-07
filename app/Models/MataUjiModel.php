<?php
namespace App\Models;
use CodeIgniter\Model;

class MataUjiModel extends Model
{
    protected $table            = 'mata_uji';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_ujian', 'penguji_id'];
}
