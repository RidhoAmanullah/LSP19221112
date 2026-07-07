<?php
namespace App\Models;
use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'program_studi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_prodi', 'jenjang'];
}
