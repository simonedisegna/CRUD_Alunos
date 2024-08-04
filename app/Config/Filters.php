<?php
// app/Config/Filters.php
namespace Config;

use CodeIgniter\Config\BaseConfig;
use App\Filters\Cors;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'cors'     => Cors::class, // Adiciona o filtro CORS aqui
    ];

    public $globals = [
        'before' => [
            'cors', // Adiciona o filtro CORS aqui
            // 'honeypot',
            // 'csrf',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
        ],
    ];

    public $methods = [];

    public $filters = [];
}
?>