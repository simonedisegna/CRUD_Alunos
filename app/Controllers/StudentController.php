<?php
namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\MateriaModel;
use App\Models\AlunoMateriaModel;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function index()
    {
        $model = new StudentModel();
        $data = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function show($id)
    {
        $model = new StudentModel();
        $data = $model->find($id);
        if (!$data) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON(['message' => 'Aluno não encontrado']);
        }
        return $this->response->setJSON($data);
    }

    public function create()
    {
        $model = new StudentModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
        ];
        $model->save($data);
        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON(['message' => 'Aluno criado com sucesso']);
    }

    public function update($id)
    {
        $model = new StudentModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
        ];
        if (!$model->update($id, $data)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON(['message' => 'Aluno não encontrado']);
        }
        return $this->response->setJSON(['message' => 'Aluno atualizado com sucesso']);
    }

    public function delete($id)
    {
        $model = new StudentModel();
        if (!$model->delete($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON(['message' => 'Aluno não encontrado']);
        }
        return $this->response->setJSON(['message' => 'Aluno excluído com sucesso']);
    }

    public function getSubjects($student_id)
    {
        $materiaModel = new MateriaModel();
        $alunoMateriaModel = new AlunoMateriaModel();

        $materias = $materiaModel->findAll();
        foreach ($materias as &$materia) {
            $alunoMateria = $alunoMateriaModel->where(['aluno_id' => $student_id, 'materia_id' => $materia['id']])->first();
            $materia['bimestre1'] = $alunoMateria['bimestre1'] ?? '';
            $materia['bimestre2'] = $alunoMateria['bimestre2'] ?? '';
            $materia['bimestre3'] = $alunoMateria['bimestre3'] ?? '';
            $materia['bimestre4'] = $alunoMateria['bimestre4'] ?? '';
        }

        return $this->response->setJSON($materias);
    }

    public function saveSubjects($student_id)
    {
        $alunoMateriaModel = new AlunoMateriaModel();
        $subjects = $this->request->getJSON(true)['subjects'];

        foreach ($subjects as $subject) {
            $data = [
                'aluno_id' => $student_id,
                'materia_id' => $subject['id'],
                'bimestre1' => isset($subject['bimestre1']) ? $subject['bimestre1'] : null,
                'bimestre2' => isset($subject['bimestre2']) ? $subject['bimestre2'] : null,
                'bimestre3' => isset($subject['bimestre3']) ? $subject['bimestre3'] : null,
                'bimestre4' => isset($subject['bimestre4']) ? $subject['bimestre4'] : null,
            ];

            $existing = $alunoMateriaModel->where(['aluno_id' => $student_id, 'materia_id' => $subject['id']])->first();
            if ($existing) {
                $alunoMateriaModel->update($existing['id'], $data);
            } else {
                $alunoMateriaModel->insert($data);
            }
        }

        return $this->response->setJSON(['message' => 'Notas atualizadas com sucesso']);
    }
}
?>