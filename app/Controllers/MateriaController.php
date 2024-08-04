<?php
namespace App\Controllers;
use App\Models\MateriaModel;
use CodeIgniter\HTTP\ResponseInterface;

class MateriaController extends BaseController {
    public function index() {
        $model = new MateriaModel();
        $data = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function show($id) {
        $model = new MateriaModel();
        $data = $model->find($id);
        if (!$data) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['message' => 'Matéria não encontrada']);
        }
        return $this->response->setJSON($data);
    }

    public function create() {
        $model = new MateriaModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
        ];
        $model->save($data);
        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
                              ->setJSON(['message' => 'Matéria criada com sucesso']);
    }

    public function update($id) {
        $model = new MateriaModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
        ];
        if (!$model->update($id, $data)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['message' => 'Matéria não encontrada']);
        }
        return $this->response->setJSON(['message' => 'Matéria atualizada com sucesso']);
    }

    public function delete($id) {
        $model = new MateriaModel();
        if (!$model->delete($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['message' => 'Matéria não encontrada']);
        }
        return $this->response->setJSON(['message' => 'Matéria excluída com sucesso']);
    }
}
?>