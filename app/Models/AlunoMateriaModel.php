<?php
namespace App\Models;
use CodeIgniter\Model;

class AlunoMateriaModel extends Model {
    protected $table = 'aluno_materia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['aluno_id', 'materia_id', 'bimestre1', 'bimestre2', 'bimestre3', 'bimestre4'];
}
?>