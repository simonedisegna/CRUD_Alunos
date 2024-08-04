<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes = Services::routes();

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Rotas para a Home
$routes->get('/', 'Home::index');

// Rotas para Auth
$routes->post('/auth/register', 'Auth::register');
$routes->post('/auth/login', 'Auth::login');
$routes->post('/auth/logout', 'Auth::logout');

// Rotas para Students
$routes->get('/students', 'StudentController::index');
$routes->post('/students', 'StudentController::create');
$routes->get('/students/(:num)', 'StudentController::show/$1');
$routes->put('/students/(:num)', 'StudentController::update/$1');
$routes->delete('/students/(:num)', 'StudentController::delete/$1');

// Rotas para Subjects (Matérias)
$routes->get('/subjects', 'SubjectController::index');
$routes->post('/subjects', 'SubjectController::create');
$routes->get('/subjects/(:num)', 'SubjectController::show/$1');
$routes->put('/subjects/(:num)', 'SubjectController::update/$1');
$routes->delete('/subjects/(:num)', 'SubjectController::delete/$1');

// Rotas para Aluno Materia (Associação de Aluno com Matérias e Notas)
$routes->get('/student/(:num)/subjects', 'StudentController::getSubjects/$1');
$routes->post('/student/(:num)/subjects', 'StudentController::saveSubjects/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to do it without disturbing the default routing in this file.
 * Environment based routes is one such time. require() additional
 * route files here to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
?>