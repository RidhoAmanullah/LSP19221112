<?php
namespace App\Models;
use CodeIgniter\Model;

class PengujiModel extends Model
{
    protected $table            = 'penguji';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nip', 'nama', 'email', 'password'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
