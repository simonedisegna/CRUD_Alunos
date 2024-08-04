# :computer: CRUD de Alunos com CodeIgniter e ReactJS :computer:

## Descrição

Este projeto é um sistema CRUD (Create, Read, Update, Delete) para gerenciar informações de alunos, incluindo nome, email, telefone, endereço e notas por matéria e bimestre. O backend foi desenvolvido com o framework PHP CodeIgniter, e o frontend foi desenvolvido com ReactJS. O sistema inclui autenticação de usuários e segue uma abordagem RESTful para comunicação entre frontend e backend.

## Funcionalidades

- Listar todos os alunos cadastrados
- Adicionar um novo aluno
- Visualizar os detalhes de um aluno específico
- Atualizar as informações de um aluno
- Excluir um aluno do sistema
- Gerenciar matérias e notas por bimestre para cada aluno
- Autenticação de usuários

## Tecnologias Utilizadas

- PHP 8.x
- CodeIgniter 4.x
- MySQL
- ReactJS
- Axios
- Bootstrap

## Configuração do Ambiente

### Backend

1. **Clonar o Repositório**

    ```bash
    git clone https://github.com/usuario/repositorio.git
    cd repositorio/backend
    ```

2. **Instalar Dependências**

    ```bash
    composer install
    ```

3. **Configurar o Banco de Dados**

    - Crie um banco de dados MySQL e atualize as configurações no arquivo `.env`.

    ```dotenv
    database.default.hostname = localhost
    database.default.database = seu_banco_de_dados
    database.default.username = seu_usuario
    database.default.password = sua_senha
    database.default.DBDriver = MySQLi
    ```

    - Execute as migrações para criar as tabelas necessárias.

    ```bash
    php spark migrate
    ```
##TABELAS 
```
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE aluno_materia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    materia_id INT NOT NULL,
    bimestre1 DECIMAL(5,2) DEFAULT NULL,
    bimestre2 DECIMAL(5,2) DEFAULT NULL,
    bimestre3 DECIMAL(5,2) DEFAULT NULL,
    bimestre4 DECIMAL(5,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
);
CREATE TABLE ci_sessions (
    id VARCHAR(128) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    timestamp INT(10) unsigned DEFAULT 0 NOT NULL,
    data BLOB NOT NULL,
    PRIMARY KEY (id),
    KEY `ci_sessions_timestamp` (`timestamp`)
);
```


4. **Iniciar o Servidor**

    ```bash
    php spark serve --port=8080
    ```

### Frontend

1. **Navegar para o Diretório do Frontend**

    ```bash
    cd repositorio/frontend
    ```

2. **Instalar Dependências**

    ```bash
    npm install
    ```

3. **Iniciar o Servidor de Desenvolvimento**

    ```bash
    npm start
    ```

## Estrutura do Projeto

### Backend

```plaintext
backend/
├── app/
│   ├── Config/
│   │   ├── Events.php
│   │   ├── Filters.php
│   │   ├── Migrations.php
│   │   ├── Paths.php
│   │   ├── Routes.php
│   ├── Controllers/
│   │   ├── Auth.php
│   │   ├── BaseController.php
│   │   ├── Home.php
│   │   ├── StudentController.php
│   │   ├── SubjectController.php
│   ├── Database/
│   │   ├── Migrations/
│   │   ├── Seeds/
│   ├── Filters/
│   │   └── Cors.php
│   ├── Models/
│   │   ├── AlunoMateriaModel.php
│   │   ├── MateriaModel.php
│   │   ├── StudentModel.php
│   │   ├── UserModel.php
│   ├── Views/
│   ├── Helpers/
├── public/
│   └── index.php
├── writable/
├── tests/
├── .env
├── composer.json
├── spark
frontend/
├── public/
│   ├── index.html
│   ├── logo192.png
│   ├── logo512.png
│   ├── manifest.json
│   ├── robots.txt
├── src/
│   ├── assets/
│   │   └── logo.png
│   ├── components/
│   │   ├── Login.js
│   │   ├── Register.js
│   │   ├── StudentList.js
│   │   ├── StudentSubjects.js
│   │   ├── MateriaList.js
│   ├── contexts/
│   │   └── AuthContext.js
│   ├── App.js
│   ├── App.css
│   ├── index.js
│   ├── index.css
├── .env
├── package.json
├── README.md
```
#Configuração CORS
Para permitir requisições entre o frontend e o backend, configuramos o CORS no arquivo public/index.php do backend.
```
// public/index.php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Continuar com o resto do index.php

```
#Rotas do Backend
```
// app/Config/Routes.php
$routes->get('/', 'Home::index');

$routes->post('/auth/register', 'Auth::register');
$routes->post('/auth/login', 'Auth::login');
$routes->post('/auth/logout', 'Auth::logout');

$routes->get('/students', 'StudentController::index');
$routes->post('/students', 'StudentController::create');
$routes->get('/students/(:num)', 'StudentController::show/$1');
$routes->put('/students/(:num)', 'StudentController::update/$1');
$routes->delete('/students/(:num)', 'StudentController::delete/$1');

$routes->get('/subjects', 'SubjectController::index');
$routes->post('/subjects', 'SubjectController::create');
$routes->get('/subjects/(:num)', 'SubjectController::show/$1');
$routes->put('/subjects/(:num)', 'SubjectController::update/$1');
$routes->delete('/subjects/(:num)', 'SubjectController::delete/$1');

$routes->get('/student/(:num)/subjects', 'StudentController::getSubjects/$1');
$routes->post('/student/(:num)/subjects', 'StudentController::saveSubjects/$1');
```
#Modelos do Backend
##StudentModel.php
```
// app/Models/StudentModel.php
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model {
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'address'];
}
```
##MateriaModel.php
```
// app/Models/MateriaModel.php
namespace App\Models;
use CodeIgniter\Model;

class MateriaModel extends Model {
    protected $table = 'materias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
}
```
##AlunoMateriaModel.php
```
// app/Models/AlunoMateriaModel.php
namespace App\Models;
use CodeIgniter\Model;

class AlunoMateriaModel extends Model {
    protected $table = 'aluno_materia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['aluno_id', 'materia_id', 'bimestre1', 'bimestre2', 'bimestre3', 'bimestre4'];
}
```
#Instruções para Uso
1. Registrar um Usuário
   Acesse a página de registro e crie um novo usuário.
2. Fazer Login
   Faça login com as credenciais criadas.
3. Gerenciar Alunos
   Na página de listagem de alunos, você pode adicionar, editar ou excluir alunos.
4. Gerenciar Matérias e Notas
   Na página de um aluno específico, você pode gerenciar as matérias e as notas para cada bimestre.
   
#TELAS
##Login
<img src="https://github.com/simonedisegna/CRUD_Alunos/main/public/img/login.jpg" alt="Disegna" width="400">
##Registrar
<img src="https://github.com/simonedisegna/CRUD_Alunos/main/public/img/registrar.jpg" alt="Disegna" width="400">
##Dasboard
<img src="https://github.com/simonedisegna/CRUD_Alunos/main/public/img/dashboard.jpg" alt="Disegna" width="400">
##Alunos
<img src="https://github.com/simonedisegna/CRUD_Alunos/main/public/img/alunos.jpg" alt="Disegna" width="400">
##Notas
<img src="https://github.com/simonedisegna/CRUD_Alunos/main/public/img/notas.jpg" alt="Disegna" width="400">
##Matérias
<img src="https://github.com/simonedisegna/CRUD_Alunos/main/public/img/materias.jpg" alt="Disegna" width="400">

