<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller; // Use Controller em vez de BaseController
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends Controller {
    protected $session;

    public function __construct() {
        // Carregar a biblioteca de sessão
        $this->session = \Config\Services::session();
    }

    public function login() {
        $userModel = new UserModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $this->session->set(['isLoggedIn' => true]);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON(['message' => 'Login realizado com sucesso']);
        } else {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                                  ->setJSON(['message' => 'Credenciais inválidas']);
        }
    }

    public function register() {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ];

        $userModel->save($data);

        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
                              ->setJSON(['message' => 'Usuário registrado com sucesso']);
    }

    public function logout() {
        $this->session->destroy();
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                              ->setJSON(['message' => 'Logout realizado com sucesso']);
    }
}
?>