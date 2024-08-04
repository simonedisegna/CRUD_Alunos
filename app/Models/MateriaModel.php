<?php
// app/Models/MateriaModel.php
namespace App\Models;
use CodeIgniter\Model;

class MateriaModel extends Model {
    protected $table = 'materias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
}
?>